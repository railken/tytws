<template>
	<div>
		Redirecting ...
	</div>
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
                    
        			window.location.href = "/login";
        		}
        	});

        }
    }
</script>

