import Vue from 'vue'
import VueRouter from 'vue-router'
import Main from './components/Main'
import Login from './components/Login'
import LoginToken from './components/LoginToken'
import TeamView from './components/team-view';
import Dashboard from './components/dashboard';


export default new VueRouter({
	routes: [
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
			path: '/',
			name: 'index',
			component: Main,
			children: [	
				{
					path: '',
					name: 'dashboard',
					component: Dashboard
				},	
				{
					path: '/team/:team',
					name: 'team',
					component: TeamView
				}
			]
		}
	],
	hashbang: false,
	mode: 'history'
});


Vue.component('component-header', require('./components/header.vue'));
Vue.component('component-team-list', require('./components/team-list.vue'));
Vue.component('component-activity-list', require('./components/activity-list.vue'));



import datePicker from 'vue-bootstrap-datetimepicker';
import 'bootstrap/dist/css/bootstrap.css';
import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
Vue.use(datePicker);
  
  
Vue.use(VueRouter);