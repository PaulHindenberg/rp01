angular.module("app").config(function($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/');

    $stateProvider
        .state('main', {
            abstract:true,
            url: '/',
            templateUrl: 'app/templates/main.html',
            controller:'MainCtrl',
            resolve:{
                affair: function(DepoService){
                    return DepoService.getAffair();
                },
                transcript: function(DepoService){
                    return DepoService.getTranscript();
                }
            }
        })
        .state('main.review', {
            url:"",
            templateUrl: 'app/templates/main.review.html',
            controller: 'MainReviewCtrl'
        })
        .state('main.issues', {
            url:'',
            templateUrl: 'app/templates/main.issues.html',
            controller: 'MainIssuesCtrl'
        })
        .state('main.exhibits', {
            url:'',
            templateUrl: 'app/templates/main.exhibits.html',
            controller: 'MainExhibitsCtrl'
        })
        .state('main.notes', {
            url:'',
            templateUrl: 'app/templates/main.notes.html',
            controller: 'MainNotesCtrl'
        });

});
