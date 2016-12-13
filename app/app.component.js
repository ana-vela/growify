"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require('@angular/core');
var core_2 = require("@angular/core");
var login_component_1 = require("./components/login-component");
var logout_component_1 = require("./components/logout-component");
var login_service_1 = require("./services/login-service");
var AppComponent = (function () {
    function AppComponent(loginService) {
        this.loginService = loginService;
        this.navCollapse = true;
        this.loggedIn = false; // note: this value is only to set appropriate nav links
    }
    // it does *NOT* represent adequate authentication!
    AppComponent.prototype.toggleCollapse = function () {
        this.navCollapse = !this.navCollapse;
    };
    __decorate([
        core_1.ViewChild(login_component_1.LoginComponent), 
        __metadata('design:type', login_component_1.LoginComponent)
    ], AppComponent.prototype, "loginComponent", void 0);
    __decorate([
        // isLoggedIn tracked via login service - ideally we would combine login & logout into the same component for a cleaner design
        core_1.ViewChild(logout_component_1.LogoutComponent), 
        __metadata('design:type', logout_component_1.LogoutComponent)
    ], AppComponent.prototype, "logoutComponent", void 0);
    AppComponent = __decorate([
        core_2.Component({
            // Update selector with YOUR_APP_NAME-app. This needs to match the custom tag in webpack/index.php
            selector: 'growify-app',
            // templateUrl path to your public_html/templates directory.
            templateUrl: './templates/growify-app.php'
        }), 
        __metadata('design:paramtypes', [login_service_1.LoginService])
    ], AppComponent);
    return AppComponent;
}());
exports.AppComponent = AppComponent;
//# sourceMappingURL=app.component.js.map