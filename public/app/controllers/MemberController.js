var app = angular.module('TestApp');

app.controller('MemberController', function($window, $state, $stateParams, $scope, $http, API_URL, API_DELETE){

    $scope.Member = {};

    $scope.ageNum = /^[1-9]{2}$/;

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

    $scope.postImg = function(){
        $http({
            method: 'POST',
            url: '/api/members/upload-img/' + $scope.MemberEdit.id,
            data: $scope.myFile
        }).success(function(response){
            if(response.status){
                console.log('upload success');
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
                age: $scope.MemberEdit.age
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