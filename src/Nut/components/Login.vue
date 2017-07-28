<template>
	<main class="fluid fluid-center container-content full-height">
	    <div class="content">
	        <div class='buttons'>
		        <button class="btn btn-block btn-social btn-gitlab" v-on:click="login('gitlab');">
		            <span class="fa fa-gitlab"></span> Sign in with GitLab
		        </button>
		        <button class="btn btn-block btn-social btn-github" v-on:click="login('github');">
		            <span class="fa fa-github"></span> Sign in with GitHub
		        </button>
	        </div>
	    </div>
	</main>

</template>

<script>

	import { container } from '../services/container'

    export default {
    	data: function() {
    		return {
    			login: function(provider) {

    				container.get('services.oauth').providerSignIn(provider);

    			}
    		};
    	},
        mounted () 
        {
        }
    }
</script>

<style>
	
	body, main {
        background-color: #52525d;
	}

	.btn-gitlab {
		background: #554488;
		color: white;
	}


	.btn-gitlab:hover {
		background: #2b2343 !important;
		color: white;
	}

	.container-content {
	}
	.content {
		margin-top: -50px;
		padding: 20px;
		background: #3d3d47;
    	margin: 10px;
    	border: 1px solid #3d3d47;

	}

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
