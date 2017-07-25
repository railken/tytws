import Vue from 'vue'
import VueRouter from 'vue-router'
import Main from './components/Main'
import Login from './components/Login'
import LoginToken from './components/LoginToken'
import Team from './components/Team'



export default new VueRouter({
	routes: [
		{
			path: '/',
			name: 'index',
			component: Main
		},
		{
			path: '/login',
			name: 'login',
			component: Login
		},
		{
			path: '/oauth/:provider/token',
			name: 'login_token',
			component: LoginToken
		},
		{
			path: '/team/:team',
			name: 'team',
			component: Team
		}
	],
	hashbang: false,
	mode: 'history'
});


Vue.component('component-header', require('./components/header.vue'));
Vue.component('component-team-list', require('./components/team-list.vue'));
Vue.component('component-team-view', require('./components/team-view.vue'));
Vue.component('component-activity-list', require('./components/activity-list.vue'));



import datePicker from 'vue-bootstrap-datetimepicker';
import 'bootstrap/dist/css/bootstrap.css';
import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
Vue.use(datePicker);
  
  
Vue.use(VueRouter);