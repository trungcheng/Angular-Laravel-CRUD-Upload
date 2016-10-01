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
        console.log($scope.files);
        $http({
            method: 'POST',
            url: API_URL,
            data: {
                name: $scope.Member.name,
                address: $scope.Member.address,
                age: $scope.Member.age,
                file: $scope.files
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
                alert(response.message);
                $(".modal").modal("hide");
                $state.reload();
            }else{
                alert(response.message);
                $(".modal").modal("hide");
                $state.reload();
            }
        })
    }

    $scope.update = function(){
        $http({
            method: 'PUT',
            url: API_DELETE + $stateParams.id,
            data: {
                name: $scope.Member.name,
                address: $scope.Member.address,
                age: $scope.Member.age,
                file: $scope.myFile
            }
        }).success(function(response){
            if(response.status){
                alert(response.message);
                $(".modal").modal("hide");
                $state.reload();
            }else{
                alert(response.message);
                $(".modal").modal("hide");
                $state.reload();
            }
        })
    }

    $scope.remove = function(id){
        var deleteUser = $window.confirm('Are you sure you want to delete this member?');
        if(deleteUser){
            $http.delete(API_DELETE + id).success(function(response){
                $state.reload();
            })
        }
    }
});