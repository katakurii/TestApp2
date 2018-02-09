var app = angular.module('my-app', ['ngFileUpload'], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }).constant('API_URL', '../admin/');
app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            element.bind('change', function () {
                scope.$apply( function () {
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);
app.controller('AdminController', function($scope , $http, API_URL){
	$http.get(API_URL + 'list').then(function successCallback(response){
        $scope.posts = response.data;
        $scope.reverse = false;
        $scope.sortData = function (column) {
            if ($scope.sortColumn == column)
                $scope.reverse = !$scope.reverse;
            else
                $scope.reverse = false;
                $scope.sortColumn = column;
        }
        $scope.getSortClass = function (column) {
            if ($scope.sortColumn == column) {
                return $scope.reverse ? 'arrow-up' : 'arrow-down';
            }
            return '';
        }
	});
	$scope.modal = function(status, id){
        // console.log(id);
		$scope.status = status;
		switch(status){
			case 'add':
				$scope.frmTitle = "Add Members";
                // $('#FrmMember').find('.help-block').hide();
				break;
			case 'edit':
                // $("#photo").val('');
				$scope.frmTitle = "Edit Members";
                $scope.id = id;
                $http.get(API_URL + 'edit/' + id).then(function successCallback(response) {
                    $scope.members = response.data;
                });
				break;
		}
		$('#Members').modal('show');
        $scope.members = null;
        $scope.photo = null;
        $scope.myFile = null;
        $scope.frmMember.$setPristine();
	}
	$scope.save = function(status, id) {
		if (status == "add") {
            var url = API_URL + "add";

            var data = {
                    "name" : $scope.members.name,
                    "address" : $scope.members.address,
                    "age" : $scope.members.age
                }
            if($scope.myFile){
                data.photo = $scope.myFile;
            }                          
            if($scope.frmMember.$invalid == false){
                $http({
                method: 'POST',
                url: url,
                headers: {'Content-Type': undefined},
                data: data,
                cache: true,
                transformRequest: function (data, headersGetter) {
                    var fd = new FormData();
                    angular.forEach(data, function (value, key) {
                        fd.append(key, value);
                    });
                    var headers = headersGetter();
                    delete headers['Content-Type'];
                    return fd;
                }
            })
            .then(function successCallback (response) {
                $http.get(API_URL + 'list').then(function successCallback(response){
                    $scope.posts = response.data;
                });
                $('#Members').modal('hide');
            }, function errorCallback (response) {
                console.log(response);
                $scope.messages = response.data.errors.photo[0];
                // console.log($scope.messages);
            });
            }
        }
        if (status == "edit") {
			var url = API_URL + "edit/" + id;	
            // console.log($scope.members.age);
            var data = {
                    "name" : $scope.members.name,
                    "address" : $scope.members.address,
                    "age" : $scope.members.age
                }
            if($scope.myFile){
                data.photo = $scope.myFile;
            }
            if($scope.frmMember.$invalid == false){
                $http({
                method: 'POST',
                url: url,
                headers: {'Content-Type': undefined},
                data: data,
                cache: true,
                transformRequest: function (data, headersGetter) {
                    var fd = new FormData();
                    angular.forEach(data, function (value, key) {
                        fd.append(key, value);
                    });
                    var headers = headersGetter();
                    delete headers['Content-Type'];
                    return fd;
                }
            })
            .then(function successCallback (response) {
                $http.get(API_URL + 'list').then(function successCallback(response){
                    $scope.posts = response.data;
                });
                $('#Members').modal('hide');
            },function errorCallback (response) {
                $scope.messages = response.data.errors.photo[0];
            });
			}
		}
	}
    $scope.confirmDelete = function(id) {
        console.log(id);
        var isConfirmDelete = bootbox.confirm('Are you sure', function (result) {
            if(result){
                    $http.get(API_URL + 'delete/' + id).then(function successCallback (response) {
                        $http.get(API_URL + 'list').then(function successCallback(response){
                        $scope.posts = response.data;
                    });
                    $('#Members').modal('hide');
                        /*console.log(response);
                        location.reload();*/
                    },function errorCallback (response) {
                        console.log(response);
                        alert('Error!');
                    });
                }
        });
    }
});
