"use strict";
angular.module("muzloTemplateApp", ["ngAnimate", "ngAria", "ngCookies", "ngMessages", "ngResource", "ngRoute", "ngSanitize", "ngTouch"]).config(["$routeProvider", function (a) {
    a.when("/", {
        templateUrl: "views/login.html",
        controller: "LoginCtrl",
        controllerAs: "login"
    }).otherwise({redirectTo: "/"})
}]);