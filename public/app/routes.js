var app = angular.module('TestApp',['ui.router']);

app.config(function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise("/members");
    $stateProvider
        .state('home', {
            url: "/members",
            templateUrl: "templates/index.html",
            controller: 'MemberController'
        })
});

app.constant('API_URL', 'http://localhost:8000/api/members');
app.constant('API_UL', 'http://localhost:8000/uploadImg');
app.constant('API_DELETE', 'http://localhost:8000/api/members/');
