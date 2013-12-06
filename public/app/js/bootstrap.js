/**
 * Created by Paul on 04.12.13.
 */

angular.element(document).ready(function(){
    var app = angular.module("app");
    //$.ajax({method:"GET", type: "json", url: '/auth/csrf_token'}).then(function(response){
    //    app.constant("CSRF_TOKEN", response.csrf_token);
        angular.bootstrap(document,['app']);
        /* var elem = document.getElementById("removeMe");
         elem.parentNode.removeChild(elem);*/
       // $('#removeMe').hide(150, function(){ $(this).remove(); });

    //});
    //app.constant("OFFSET", new Date().getTimezoneOffset()*60*1000);
});
