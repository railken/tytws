import Vue from 'vue'
import VueRouter from 'vue-router'
import Main from './components/Main'
import Login from './components/Login'
import LoginToken from './components/LoginToken'



export default new VueRouter({
	routes: [
		{
			path: '/',
			name: 'Hello',
			component: Main
		},
		{
			path: '/login',
			name: 'Autenticazione',
			component: Login
		},
		{
			path: '/oauth/:provider/token',
			name: 'Provider',
			component: LoginToken
		}
	],
	hashbang: false,
	mode: 'history'
});


Vue.component('team-list', require('./components/team-list.vue'));

Vue.use(VueRouter);