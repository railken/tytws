import { container } from './container';

export class TeamService
{

	constructor()
	{
		this.container = container;
		this.url = container.get('env').api.url;
	}

	request(method, url, vars)
	{
		vars.headers = {
			Authorization: "Bearer "+this.container.get('services.oauth').access_token
		};

		return this.container.get('services.request').basicCall(method, this.url+"/api/v1"+url, vars);
	}

	all(vars)
	{
	    this.request("GET", "/user/teams", vars);
	}

	insert(vars)
	{
	    this.request("POST", "/user/teams", vars);
	}

	update(id, vars)
	{
	    this.request("PUT", "/user/teams/"+id, vars);
	}

	remove(id, vars)
	{
	    this.request("DELETE", "/user/teams/"+id, vars);
	}
	
	get(id, vars)
	{
		this.request("GET", "/user/teams/"+id, vars);
	}
}