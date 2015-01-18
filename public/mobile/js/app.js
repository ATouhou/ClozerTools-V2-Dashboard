var app = angular.module("app", ['ngResource']);


app.config(function($routeProvider) {
  $routeProvider.when('/login', {
    templateUrl: 'templates/login.html',
    controller: 'LoginController',

  });

  $routeProvider.when('/home', {
    templateUrl: 'templates/home.html',
    controller: 'LeadController',
     resolve: {
      leads : function(LeadService) {
        return LeadService.get();
      }
    }
  });

  $routeProvider.when('/books', {
    templateUrl: 'templates/books.html',
    controller: 'BooksController',
    resolve: {
      books : function(BookService) {
        return BookService.get();
      }
    }
  });

  $routeProvider.otherwise({ redirectTo: '/login' });

});



app.factory("LeadService", function($http) {
  return {
    get: function() {
      return $http.get('/leads');
    }
  };
});

app.factory("FlashService", function($rootScope) {
  return {
    show: function(message) {
      $rootScope.flash = message;
    },
    clear: function() {
      $rootScope.flash = "";
    }
  }
});

app.factory("SessionService", function() {
  return {
    get: function(key) {
      return sessionStorage.getItem(key);
    },
    set: function(key, val) {
      return sessionStorage.setItem(key, val);
    },
    unset: function(key) {
      return sessionStorage.removeItem(key);
    }
  }
});

app.controller("LeadController", function($scope, leads) {
  $scope.leads = leads.data;
});

app.controller("HomeController", function($scope, $location) {
  $scope.title = "Awesome Home";
  $scope.message = "Mouse Over these images to see a directive at work!";


});

app.directive("showsMessageWhenHovered", function() {
  return {
    restrict: "A", // A = Attribute, C = CSS Class, E = HTML Element, M = HTML Comment
    link: function(scope, element, attributes) {
      var originalMessage = scope.message;
      element.bind("mouseenter", function() {
        scope.message = attributes.message;
        scope.$apply();
      });
      element.bind("mouseleave", function() {
        scope.message = originalMessage;
        scope.$apply();
      });
    }
  };
});