
import { OAuthGithubProvider } from './oauth.provider.github';
import { Request } from './request';
import { env } from '../env';

// import { OAuth2FacebookProvider } from '../oauth/oauth2.facebook.provider';
// import { OAuth2GoogleProvider } from '../oauth/oauth2.google.provider';

export class OAuth
{

	/**
	 * Sign in
	 *
	 * @param {User} user
	 *
	 * @return {Observable}
	 */
	providerSignIn(provider, vars)
	{


		provider = this.getProviderByName(provider);


		window.location.href = provider.getAuthorizeUrl();

	}

	providerSignInCode(provider_name, vars)
	{

		var provider = this.getProviderByName(provider_name);
		var params = provider.getParamsAccessToken(vars.params);


		var r = new Request();

		var r1 = function() {
			r.basicCall("GET", env.api.url+"/api/v1/oauth/"+provider_name+"/access_token", {
				params: params , 
				success: function(response) {
					r2(response.data.resource.access_token);
				},
				error: function(response) {
					vars.error(response);
				}
			});
		};

		var r2 = function(access_token) {
			r.basicCall("GET", env.api.url+"/api/v1/oauth/"+provider_name+"/exchange_token", {
				params: { 
					access_token: access_token
				}, 
				success: function(response) {
					vars.success(response);
				},
				error: function(response) {
					vars.error(response);
				}
			});
		}

		r1();

	}

	getProviderByName(provider)
	{	
		var providers = {
			github: new OAuthGithubProvider(),
		};

		return typeof providers[provider] !== "undefined" ? providers[provider] : null;
	}

	
}