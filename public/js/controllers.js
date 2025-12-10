app.controller('LoginController', ['$scope', '$location', 'ApiService', 'AuthService',
    function($scope, $location, ApiService, AuthService) {
        $scope.credentials = {};
        $scope.error = '';
        $scope.loading = false;

        if (AuthService.isAuthenticated()) {
            $location.path('/galleta');
        }

        $scope.login = function() {
            $scope.error = '';
            $scope.loading = true;

            ApiService.login($scope.credentials).then(
                function(response) {
                    AuthService.saveToken(response.data.token, response.data.user);
                    $location.path('/galleta');
                },
                function(error) {
                    $scope.loading = false;
                    $scope.error = error.data.message || 'Error al iniciar sesión';
                }
            );
        };
    }]);

app.controller('RegisterController', ['$scope', '$location', 'ApiService', 'AuthService',
    function($scope, $location, ApiService, AuthService) {
        $scope.userData = {};
        $scope.error = '';
        $scope.loading = false;

        if (AuthService.isAuthenticated()) {
            $location.path('/galleta');
        }

        $scope.register = function() {
            $scope.error = '';
            $scope.loading = true;

            if ($scope.userData.password !== $scope.userData.password_confirmation) {
                $scope.error = 'Las contraseñas no coinciden';
                $scope.loading = false;
                return;
            }

            ApiService.register($scope.userData).then(
                function(response) {
                    AuthService.saveToken(response.data.token, response.data.user);
                    $location.path('/galleta');
                },
                function(error) {
                    $scope.loading = false;
                    $scope.error = error.data.message || 'Error al registrarse';
                }
            );
        };
    }]);

app.controller('GalletaController', ['$scope', '$location', 'ApiService', 'AuthService',
    function($scope, $location, ApiService, AuthService) {
        $scope.mensaje = '';
        $scope.galleta_abierta = false;
        $scope.cargando = false;
        $scope.user = AuthService.getUser();

        $scope.abrirGalleta = function() {
            if ($scope.galleta_abierta) return;

            $scope.galleta_abierta = true;
            $scope.cargando = true;

            ApiService.getMensaje().then(
                function(response) {
                    $scope.mensaje = response.data.mensaje;
                    $scope.cargando = false;
                },
                function(error) {
                    $scope.mensaje = 'Error al cargar el mensaje';
                    $scope.cargando = false;
                }
            );
        };

        $scope.abrirOtraGalleta = function() {
            $scope.galleta_abierta = false;
            $scope.mensaje = '';
        };

        $scope.irHistorial = function() {
            $location.path('/historial');
        };

        $scope.irAdmin = function() {
            $location.path('/admin');
        };

        $scope.logout = function() {
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
    }]);

app.controller('HistorialController', ['$scope', '$location', 'ApiService', 'AuthService',
    function($scope, $location, ApiService, AuthService) {
        $scope.historial = [];
        $scope.loading = true;
        $scope.user = AuthService.getUser();

        ApiService.getUserHistory().then(
            function(response) {
                $scope.historial = response.data;
                $scope.loading = false;
            },
            function(error) {
                $scope.loading = false;
                console.error('Error al cargar historial', error);
            }
        );

        $scope.volver = function() {
            $location.path('/galleta');
        };

        $scope.logout = function() {
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
    }]);

app.controller('AdminController', ['$scope', '$location', 'ApiService', 'AuthService',
    function($scope, $location, ApiService, AuthService) {
        $scope.user = AuthService.getUser();
        $scope.fortunes = [];
        $scope.stats = null;
        $scope.historialGlobal = [];
        $scope.loading = true;
        $scope.vistaActual = 'fortunes';

        $scope.fortuneForm = {
            id: null,
            message: '',
            editing: false
        };

        function cargarFortunes() {
            $scope.loading = true;
            ApiService.getFortunes().then(
                function(response) {
                    $scope.fortunes = response.data;
                    $scope.loading = false;
                },
                function(error) {
                    $scope.loading = false;
                    console.error('Error al cargar mensajes', error);
                }
            );
        }

        function cargarStats() {
            $scope.loading = true;
            ApiService.getStats().then(
                function(response) {
                    $scope.stats = response.data;
                    $scope.loading = false;
                },
                function(error) {
                    $scope.loading = false;
                    console.error('Error al cargar estadísticas', error);
                }
            );
        }

        function cargarHistorial() {
            $scope.loading = true;
            ApiService.getGlobalHistory().then(
                function(response) {
                    $scope.historialGlobal = response.data;
                    $scope.loading = false;
                },
                function(error) {
                    $scope.loading = false;
                    console.error('Error al cargar historial', error);
                }
            );
        }

        $scope.cambiarVista = function(vista) {
            $scope.vistaActual = vista;
            if (vista === 'fortunes') {
                cargarFortunes();
            } else if (vista === 'stats') {
                cargarStats();
            } else if (vista === 'history') {
                cargarHistorial();
            }
        };

        $scope.crearFortune = function() {
            if (!$scope.fortuneForm.message) return;

            ApiService.createFortune({ message: $scope.fortuneForm.message }).then(
                function(response) {
                    cargarFortunes();
                    $scope.fortuneForm.message = '';
                    alert('Mensaje creado exitosamente');
                },
                function(error) {
                    alert('Error al crear mensaje');
                }
            );
        };

        $scope.editarFortune = function(fortune) {
            $scope.fortuneForm.id = fortune.id;
            $scope.fortuneForm.message = fortune.message;
            $scope.fortuneForm.editing = true;

            // Scroll al formulario
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        $scope.actualizarFortune = function() {
            ApiService.updateFortune($scope.fortuneForm.id, { message: $scope.fortuneForm.message }).then(
                function(response) {
                    cargarFortunes();
                    $scope.cancelarEdicion();
                    alert('Mensaje actualizado exitosamente');
                },
                function(error) {
                    alert('Error al actualizar mensaje');
                }
            );
        };

        $scope.eliminarFortune = function(id) {
            if (!confirm('¿Estás seguro de eliminar este mensaje?')) return;

            ApiService.deleteFortune(id).then(
                function(response) {
                    cargarFortunes();
                    alert('Mensaje eliminado exitosamente');
                },
                function(error) {
                    alert('Error al eliminar mensaje');
                }
            );
        };

        $scope.cancelarEdicion = function() {
            $scope.fortuneForm = {
                id: null,
                message: '',
                editing: false
            };
        };

        $scope.volver = function() {
            $location.path('/galleta');
        };

        $scope.logout = function() {
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

        cargarFortunes();
    }]);
