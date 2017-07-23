import { OAuthProvider } from './oauth.provider';
import { container } from './container';

export class OAuthGitlabProvider extends OAuthProvider
{


	constructor()
	{
		super();
		this.url = "https://gitlab.com/oauth";

		this.client_id = container.get('env').oauth.gitlab.client.id;
		this.client_secret = container.get('env').oauth.gitlab.client.secret;
		this.redirect_uri = container.get('env').oauth.gitlab.redirect_uri;
	}

	getAuthorizeUrl()
	{


		return this.url+"/authorize"+this.obj_to_query({
			client_id: this.client_id,
			response_type: 'code',
			redirect_uri: this.redirect_uri,
			scope: 'read_user'
		})
	}

	getParamsAccessToken(vars)
	{
		return {
			client_id: this.client_id,
			client_secret: this.client_secret,
			redirect_uri: this.redirect_uri,
			code: vars.code
		};
	}


}