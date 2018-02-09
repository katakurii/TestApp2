app.directive('fileModel', ['$parse',function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, iElement, iAttrs) {
            var model = $parse(iAttrs.fileModel);
            var modelSetter = model.assign;

            iElement.bind('change', function() {


                scope.$apply(function(){            
                    modelSetter(scope,iElement[0].files[0])                    
                    /*$('#error').html('');
                    $('#error-edit').html('');*/

                });
            });

        }
    };
}]);