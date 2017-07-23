
import { OAuthGithubProvider } from './oauth.provider.github';
import { OAuthGitlabProvider } from './oauth.provider.gitlab';
import { container } from './container';

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


		var r = container.get('services.request');

		var r1 = function() {
			r.basicCall("GET", container.get('env').api.url+"/api/v1/oauth/"+provider_name+"/access_token", {
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
			r.basicCall("GET", container.get('env').api.url+"/api/v1/oauth/"+provider_name+"/exchange_token", {
				params: { 
					access_token: access_token
				}, 
				success: function(response) {
        			container.get('services.cookies').set('access_token', response.data.resource.access_token);
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
			gitlab: new OAuthGitlabProvider(),
		};

		return typeof providers[provider] !== "undefined" ? providers[provider] : null;
	}

	loadUser(vars)
	{
		var access_token = container.get('services.cookies').get('access_token');


        if (access_token) {

            // Verify access_token

            container.get('services.request').basicCall("GET", "/api/v1/user", {
                params: {},
                headers: {
                    Authorization: "Bearer "+access_token
                },
                success: function(response) {
                	vars.success(response);
                },
                error: function(response) {
                	vars.error(response);
                }
            });

            return;

        }
        vars.error();
	}

	logout()
	{
		container.get('services.cookies').remove('access_token');
	}
	
}