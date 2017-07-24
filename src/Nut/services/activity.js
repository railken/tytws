import { container } from './container';

export class ActivityService
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
	    this.request("GET", "/user/activities", vars);
	}

	insert(vars)
	{
	    this.request("POST", "/user/activities", vars);
	}

	update(id, vars)
	{
	    this.request("PUT", "/user/activities/"+id, vars);
	}

	remove(id, vars)
	{
	    this.request("DELETE", "/user/activities/"+id, vars);
	}
	
	get(id, vars)
	{
		this.request("GET", "/user/activities/"+id, vars);
	}
}