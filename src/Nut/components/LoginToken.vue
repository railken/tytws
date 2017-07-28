<template>
	<main>
		<div class='container-loader'>
            <div class='sk-rotating-plane'></div>
        </div>
	</main>
</template>

<script>

	import { container } from '../services/container';

    export default {
        mounted () 
        {
        	var params = container.get('queryParams');
        	var provider = this.$route.params.provider;

        	container.get('services.oauth').providerSignInCode(provider, {
        		params: params,
        		success: function(response) {

        			window.location.href = "/";
        		},
        		error: function(response) {
                    
                    container.get('router').push({ name: 'login'});
        		}
        	});

        }
    }
</script>

<style>

    .container-loader {
        margin: 100px auto;
    }
    .container-loader > div {
        background-color: white;

    }

    body, main {
        background-color: #52525d;
    }
</style>

