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

app.constant('API_URL', 'api/members');
app.constant('API_UL', 'uploadImg');
app.constant('API_DELETE', 'api/members/');
