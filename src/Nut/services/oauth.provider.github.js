import { OAuthProvider } from './oauth.provider';
import { container } from './container';

export class OAuthGithubProvider extends OAuthProvider
{


	constructor()
	{
		super();
		this.url = "https://github.com/login/oauth";

		this.client_id = container.get('env').oauth.github.client.id;
		this.client_secret = container.get('env').oauth.github.client.secret;
	}

	getAuthorizeUrl()
	{
		return this.url+"/authorize"+this.obj_to_query({
			client_id: this.client_id,
			client_secret: this.client_secret,
			scope: 'user:email'
		})
	}

	getParamsAccessToken(vars)
	{
		return {
			url: 'https://github.com/login/oauth/access_token',
			client_id: this.client_id,
			client_secret: this.client_secret,
			code: vars.code
		};
	}


}