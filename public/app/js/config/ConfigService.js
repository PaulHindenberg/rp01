/**
 * Created by Paul on 05.12.13.
 */
angular.module("app").factory("ConfigService", function(){
    return{
        getPhpConnectionString: function(methodName){
            str = '../api/';
            str= str+methodName;
            return str;
        }
    }
})