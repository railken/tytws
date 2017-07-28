/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import router from './router';
import { OAuth } from './services/oauth';
import { container } from './services/container';
import { env } from './env';
import * as Cookies from "js-cookie";
import { Request } from './services/request';
import { TeamService } from './services/team';
import { ActivityService } from './services/activity';
import { ReportService } from './services/report';


/**
 * Bootstrap
 */
require('./bootstrap');


var Cropper = require('cropperjs');
require('cropperjs/dist/cropper.min.css');


require('./lib');


/**
 * Including CSS libraries
 *
 */
require('bootstrap/dist/css/bootstrap.min.css');
require('bootstrap-social/bootstrap-social.css');
require('font-awesome/css/font-awesome.min.css');

require("./app.css");
require("./libs/uploader.js");



window.Vue = require('vue');

Vue.use(router);

router.mode = 'html5';

const queryString = require('query-string');

container.set('env', env);
container.set('queryParams', queryString.parse(location.search));

container.set('router', router);
container.set('route', window.location.pathname);

container.set('services.oauth', new OAuth());
container.set('services.request', new Request());
container.set('services.cookies', Cookies);
container.set('services.team', new TeamService());
container.set('services.activity', new ActivityService());
container.set('services.report', new ReportService());
container.set('date', require('moment'));
container.get('date').locale('en', {
  week: { dow: 1 } // Monday is the first day of the week
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    router
});
