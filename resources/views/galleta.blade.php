<!DOCTYPE html>
<html ng-app="AppFortuna">
<head>
    <title>Galleta de la Fortuna</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: url("{{ asset('imagenes/Background.jpg') }}") center/cover no-repeat fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            text-align: center;
            margin-top: 20px;
        }

        h1 {
            color: white;
            font-size: 3em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .galleta-section {
            margin-bottom: 30px;
            position: relative;
        }

        .imagen-galleta {
            width: 450px;
            height: 450px;
            margin: 0 auto 20px;
            transition: transform 0.3s, filter 0.3s;
        }

        .imagen-galleta:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .galleta {
            width: 300px;
            height: 80px;
            background: linear-gradient(135deg, #f5d547 0%, #f9e79f 100%);
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 30px;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: transform 0.3s, box-shadow 0.3s;
            font-weight: bold;
            color: #333;
            font-size: 1.2em;
            border: 3px solid #d4a744;
        }

        .galleta:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        .mensaje-container {
            position: relative;
            width: 450px;
            height: 450px;
            margin: 0 auto;
        }

        .mensaje-container .imagen-galleta {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        .mensaje {
            position: absolute;
            top: 32%;
            left: 40%;
            transform: translate(-50%, -50%);
            background: transparent;
            padding: 15px;
            border-radius: 10px;
            width: 220px;
            color: #333;
            font-size: 0.9em;
            font-style: italic;
            line-height: 1.5;
            max-height: 180px;
            overflow-y: auto;
            z-index: 2;
            text-align: center;
        }

        .loading {
            color: white;
            font-size: 1.2em;
        }

        .botones {
            margin-top: 30px;
        }

        button {
            background: linear-gradient(135deg, #f5d547 0%, #f9e79f 100%);
            color: #333;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1em;
            margin: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body ng-controller="GalletaController">
<div class="container">
    <h1>🥠 Galleta de la Fortuna 🥠</h1>

    <div class="galleta-section" ng-show="!galleta_abierta">
        <img src="/imagenes/galleta.png" class="imagen-galleta">

        <div class="galleta" ng-click="abrirGalleta()">
            ABRE TU GALLETA
        </div>
    </div>

    <div class="galleta-section" ng-show="galleta_abierta">
        <div class="mensaje-container">
            <img src="/imagenes/galleta_abierta.png" class="imagen-galleta">
            <div class="mensaje" ng-show="mensaje">
                @{{ mensaje }}
            </div>
        </div>
    </div>

    <div class="loading" ng-show="cargando">
        Cargando mensaje...
    </div>

    <div class="botones" ng-show="galleta_abierta">
        <button ng-click="abrirOtraGalleta()">Otra Galleta</button>
        <button ng-click="logout()">Logout</button>
    </div>
</div>

<script>
    var app = angular.module('AppFortuna', []);

    app.controller('GalletaController', ['$scope', '$http', function($scope, $http) {
        $scope.mensaje = '';
        $scope.galleta_abierta = false;
        $scope.cargando = false;

        $scope.abrirGalleta = function() {
            if ($scope.galleta_abierta) return;

            $scope.galleta_abierta = true;
            $scope.cargando = true;

            $http.get('/api/mensaje').then(function(response) {
                $scope.mensaje = response.data.mensaje;
                $scope.cargando = false;
            }, function(error) {
                $scope.mensaje = 'Error al cargar el mensaje';
                $scope.cargando = false;
            });
        };

        $scope.abrirOtraGalleta = function() {
            $scope.galleta_abierta = false;
            $scope.mensaje = '';
        };

        $scope.logout = function() {
            window.location.href = '/login';
        };
    }]);
</script>
</body>
</html>
