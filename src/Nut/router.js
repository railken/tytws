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
		},
		{
			path: '/team/:team',
			name: 'Team',
			component: Team
		}
	],
	hashbang: false,
	mode: 'history'
});


Vue.component('component-header', require('./components/header.vue'));
Vue.component('component-team-list', require('./components/team-list.vue'));
Vue.component('component-team-view', require('./components/team-view.vue'));

Vue.use(VueRouter);