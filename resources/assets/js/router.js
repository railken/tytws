import Vue from 'vue'
import VueRouter from 'vue-router'
import Example from './components/Example'
import Ban from './components/Ban'


export default new VueRouter({
	routes: [
		{
		  path: '/',
		  name: 'Hello',
		  component: Example
		},

		{
		  path: '/foo',
		  name: 'Hello',
		  component: Ban
		}
	],
	hashbang: false,
	mode: 'history'
});


Vue.use(VueRouter);