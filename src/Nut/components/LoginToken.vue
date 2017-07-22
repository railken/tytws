<template>
	<div>
		Redirecting ...
	</div>
</template>

<script>

	import { OAuth } from '../services/oauth';
	import store from 'store';
	import * as Cookies from "js-cookie";

    export default {
        mounted () 
        {
        	var params = store.get('queryParams');
        	var provider = this.$route.params.provider;
        	var oauth = new OAuth();


        	oauth.providerSignInCode(provider, {
        		params: params,
        		success: function(response) {

        			Cookies.set('access_token', response.data.resource.access_token);
        			window.location.href = "/";
        		},
        		error: function(response) {
        			window.location.href = "/login";
        		}
        	});

        }
    }
</script>

