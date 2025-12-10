var app = angular.module('AppFortuna', ['ngRoute']);

app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/login', {
            templateUrl: '/views/login.html',
            controller: 'LoginController'
        })
        .when('/register', {
            templateUrl: '/views/register.html',
            controller: 'RegisterController'
        })
        .when('/galleta', {
            templateUrl: '/views/galleta.html',
            controller: 'GalletaController',
            resolve: {
                auth: function(AuthService, $location) {
                    if (!AuthService.isAuthenticated()) {
                        $location.path('/login');
                    }
                }
            }
        })
        .when('/admin', {
            templateUrl: '/views/admin.html',
            controller: 'AdminController',
            resolve: {
                auth: function(AuthService, $location) {
                    if (!AuthService.isAuthenticated() || !AuthService.isAdmin()) {
                        $location.path('/galleta');
                    }
                }
            }
        })
        .when('/historial', {
            templateUrl: '/views/historial.html',
            controller: 'HistorialController',
            resolve: {
                auth: function(AuthService, $location) {
                    if (!AuthService.isAuthenticated()) {
                        $location.path('/login');
                    }
                }
            }
        })
        .otherwise({
            redirectTo: '/login'
        });

    $locationProvider.html5Mode(true);
}]);

app.run(['$rootScope', '$location', 'AuthService', function($rootScope, $location, AuthService) {
    $rootScope.$on('$routeChangeSuccess', function() {
        var path = $location.path();

        if (path === '/login' || path === '/register') {
            $rootScope.bodyClass = 'auth-page';
            $rootScope.showNavbar = false;
        } else if (path === '/galleta') {
            $rootScope.bodyClass = 'galleta-page logged-in';
            $rootScope.showNavbar = true;
        } else {
            $rootScope.bodyClass = 'app-page logged-in';
            $rootScope.showNavbar = true;
        }

        if (AuthService.isAuthenticated()) {
            $rootScope.currentUser = AuthService.getUser();
        }
    });
}]);

app.factory('AuthInterceptor', ['$q', '$window', '$location', function($q, $window, $location) {
    return {
        request: function(config) {
            config.headers = config.headers || {};
            var token = $window.localStorage.getItem('token');
            if (token) {
                config.headers.Authorization = 'Bearer ' + token;
            }
            return config;
        },
        responseError: function(rejection) {
            if (rejection.status === 401) {
                $window.localStorage.removeItem('token');
                $window.localStorage.removeItem('user');
                $location.path('/login');
            }
            return $q.reject(rejection);
        }
    };
}]);

app.config(['$httpProvider', function($httpProvider) {
    $httpProvider.interceptors.push('AuthInterceptor');
}]);

app.service('AuthService', ['$window', function($window) {
    this.saveToken = function(token, user) {
        $window.localStorage.setItem('token', token);
        $window.localStorage.setItem('user', JSON.stringify(user));
    };

    this.getToken = function() {
        return $window.localStorage.getItem('token');
    };

    this.getUser = function() {
        var user = $window.localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    };

    this.isAuthenticated = function() {
        return !!this.getToken();
    };

    this.isAdmin = function() {
        var user = this.getUser();
        return user && user.role === 'admin';
    };

    this.logout = function() {
        $window.localStorage.removeItem('token');
        $window.localStorage.removeItem('user');
    };
}]);

app.service('ApiService', ['$http', function($http) {
    var baseUrl = '/api';

    // Auth
    this.login = function(credentials) {
        return $http.post(baseUrl + '/login', credentials);
    };

    this.register = function(userData) {
        return $http.post(baseUrl + '/register', userData);
    };

    this.logout = function() {
        return $http.post(baseUrl + '/logout');
    };

    this.me = function() {
        return $http.get(baseUrl + '/me');
    };

    // Galleta
    this.getMensaje = function() {
        return $http.get(baseUrl + '/mensaje');
    };

    // Historial
    this.getUserHistory = function() {
        return $http.get(baseUrl + '/user/history');
    };

    // Admin - Fortunes
    this.getFortunes = function() {
        return $http.get(baseUrl + '/admin/fortunes');
    };

    this.createFortune = function(fortune) {
        return $http.post(baseUrl + '/admin/fortunes', fortune);
    };

    this.updateFortune = function(id, fortune) {
        return $http.put(baseUrl + '/admin/fortunes/' + id, fortune);
    };

    this.deleteFortune = function(id) {
        return $http.delete(baseUrl + '/admin/fortunes/' + id);
    };

    // Admin - Stats
    this.getStats = function() {
        return $http.get(baseUrl + '/admin/stats');
    };

    this.getGlobalHistory = function() {
        return $http.get(baseUrl + '/admin/history');
    };
}]);

app.controller('GlobalController', ['$scope', '$location', 'ApiService', 'AuthService',
    function($scope, $location, ApiService, AuthService) {
        $scope.globalLogout = function() {
            ApiService.logout().then(
                function() {
                    AuthService.logout();
                    $location.path('/login');
                },
                function() {
                    AuthService.logout();
                    $location.path('/login');
                }
            );
        };
    }
]);

angular.element(document).ready(function() {
    var bodyElement = angular.element(document.body);
    bodyElement.attr('ng-controller', 'GlobalController');
    angular.bootstrap(bodyElement, ['AppFortuna']);
});
