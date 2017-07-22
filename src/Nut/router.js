import Vue from 'vue'
import VueRouter from 'vue-router'
import Example from './components/Example'
import Login from './components/Login'
import LoginToken from './components/LoginToken'



export default new VueRouter({
	routes: [
		{
		  path: '/',
		  name: 'Hello',
		  component: Example
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


Vue.use(VueRouter);