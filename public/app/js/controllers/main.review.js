angular.module('app')
  .controller('MainReviewCtrl', function ($log, $scope, transcript) {
        $scope.searchString = '';
        $scope.transcript = (transcript);
        window.trans = $scope.transcript;

        $scope.search = function(string){
            $log.log('search started');
            var array = $.map($scope.transcript.Lines.Line, function(value, index){
                return [value];
            });
            angular.forEach(array, function (value, key){
               $log(typeof(value));
                /*if(value.indexOf(string) !== -1){
                    alert('found one');
                }*/
            });
        };

  });
