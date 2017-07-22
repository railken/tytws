/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import router from './router'
import { OAuth } from './services/oauth';
import store from 'store';
import env from './env';
import * as Cookies from "js-cookie";


require('./bootstrap');


/**
 * Including CSS libraries
 *
 */
require('bootstrap/dist/css/bootstrap.min.css');
require('bootstrap-social/bootstrap-social.css');
require('font-awesome/css/font-awesome.min.css');

require("./app.css")

window.Vue = require('vue');

Vue.use(router);

router.mode = 'html5';

const queryString = require('query-string');

store.set('queryParams', queryString.parse(location.search));


store.set('route', window.location.pathname);

/**
 * Verify authentication
 */
var access_token = Cookies.get('access_token');

if (access_token) {

	// Verify access_token
}



/*
if (store.get('route') != '/login') {
	window.location.href = "/login";

	throw new Error("User not logged");
}
*/



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    router
});
