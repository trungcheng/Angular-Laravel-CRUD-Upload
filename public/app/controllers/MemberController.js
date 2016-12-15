var app = angular.module('TestApp');

app.controller('MemberController', function($window, $state, $stateParams, $scope, $http, API_UL, API_URL, API_DELETE){

    $scope.Member = {};

    $scope.MemberEdit = {};

    $scope.ageNum = /^[1-9]{2}$/;

    $scope.sortType     = 'name';
    
    $scope.sortReverse  = false;

    $scope.checkName = function(){
        if($scope.Member.name1){
            $scope.blured =  true;
            $http({
                method: 'GET',
                url: 'checkDuplicate/' + $scope.Member.name1,
            }).success(function(response){
                if(response.status){
                    $scope.nameStatus = true;
                } else {
                    $scope.nameStatus = false;
                }
            })
        }
    }

    $scope.imageUpload = function(event){
        var files = event.target.files;
        var file = files[files.length-1];
        $scope.file = file;
        var reader = new FileReader();
        reader.onload = $scope.imageIsLoaded;
        reader.readAsDataURL(file);
    }

    $scope.imageIsLoaded = function(e){
        $scope.$apply(function(){
            $scope.step = e.target.result;
        })
    }
    
    $scope.showall = function(){
        $http.get(API_URL).success(function(response){
            if(response.status){
                $scope.members = response.data;
            }
        });
    }

    $scope.add = function(){
        $http({
            method: 'POST',
            url: API_URL,
            headers: {'Content-Type': undefined},
            data: {
                name: $scope.Member.name1,
                address: $scope.Member.address1,
                age: $scope.Member.age1,
                photo: $scope.files
            },
            transformRequest: function (data, headersGetter) {
                var fd = new FormData();
                angular.forEach(data, function (value, key) {
                    fd.append(key, value);
                });
                var headers = headersGetter();
                delete headers['Content-Type'];
                return fd;
            }
        }).success(function(response){
            if(response.status){
                $(".modal").modal("hide");
                $state.reload();
            }else{
                alert(response.message);
            }
        })
    }

    $scope.edit = function(id){
        $http.get(API_DELETE + id).success(function(response){
            $scope.MemberEdit = response.data[0];
        })
    }

    $scope.uploadImg = function(){
        $http({
            method: 'POST',
            url: API_UL,
            headers: {'Content-Type': undefined},
            data: $scope.MemberEdit,
            transformRequest: function (data, headersGetter) {
                var fd = new FormData();
                angular.forEach(data, function (value, key) {
                    fd.append(key, value);
                });
                var headers = headersGetter();
                delete headers['Content-Type'];
                return fd;
            }
        }).success(function(response){
            if(response.status){
                $scope.MemberEdit.photo = response.path;
            }else{
                alert(response.message);
            }
        })
    }

    $scope.update = function(){
        $http({
            method: 'PUT',
            url: API_DELETE + $scope.MemberEdit.id,
            data: {
                name: $scope.MemberEdit.name,
                address: $scope.MemberEdit.address,
                age: $scope.MemberEdit.age,
                photo: $scope.MemberEdit.photo
            }
        }).success(function(response){
            if(response.status){
                $(".modal").modal("hide");
                $state.reload();
            }else{
                alert(response.message);
            }
        })
    }

    $scope.remove = function(id, index){
        var deleteUser = $window.confirm('Are you sure you want to delete this member?');
        if(deleteUser){
            $http({
                method: 'DELETE',
                url: API_DELETE + id,
            }).success(function(response){
                $scope.members.splice(index, 1);
            })
        }
    }
});