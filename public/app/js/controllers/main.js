angular.module('app')
  .controller('MainCtrl', function ($scope, affair) {
    $scope.affair = affair;
  });
