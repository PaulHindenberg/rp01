angular.module("app").factory('DepoService', function($http, ConfigService) {
    return {
        getAffair: function(){
            var promise = $http.get(ConfigService.getPhpConnectionString('affair')).then(function(response){
                return response.data;
            });
            return promise;
        },
        getTranscript: function(){
            var promise = $http.get(ConfigService.getPhpConnectionString('transcript')).then(function(response){
                return response.data;
            });
            return promise;
        }
    };
});