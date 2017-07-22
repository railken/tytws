<template>
	<div class="fluid fluid-center">
	    <div class="content">
	        <div class="title m-b-md">
	            Track your timey stuff
	        </div>
	        <p>
	            The Doctor approve it. 
	        </p>
	        <div class='buttons'>
		        <a class="btn btn-block btn-social btn-dropbox">
		            <span style='display:flex;align-items:center;justify-content:center'><img src="/assets/horizon.png" width='20' height='20'></span> Sign in with Horizon
		        </a>
		        <button class="btn btn-block btn-social btn-odnoklassniki" style='background: #554488' v-on:click="login('github');">
		            <span class="fa fa-gitlab"></span> Sign in with GitLab
		        </button>
		        <button class="btn btn-block btn-social btn-github" v-on:click="login('github');">
		            <span class="fa fa-github"></span> Sign in with GitHub
		        </button>
	        </div>
	    </div>
	</div>

</template>

<script>

	import { OAuth } from '../services/oauth'

    export default {
    	data: function() {
    		return {
    			login: function(provider) {

    				var oauth = new OAuth();
    				oauth.providerSignIn(provider);

    			}
    		};
    	},
        mounted () 
        {
            console.log('Component mounted.');
        }
    }
</script>

<style>
	.position-ref {
    	position: relative;
	}

	.buttons {
		max-width: 180px;
		margin: 0 auto;
	}

	p {
	    font-weight: 600;
	}
	.content {
	    text-align: center;
	}

	.title {
	    font-size: 34px;
	}

	.m-b-md {
	    margin-bottom: 30px;
	}

</style>
