import { container } from './container';

export class Team
{

	constructor()
	{
		this.container = container;
	}

	all(vars)
	{
	    this.container.get('services.request').basicCall("GET", "/api/v1/teams", vars);
	}

	insert(vars)
	{
	    this.container.get('services.request').basicCall("POST", "/api/v1/teams", vars);
	}

	update(id, vars)
	{
	    this.container.get('services.request').basicCall("PUT", "/api/v1/teams/"+id, vars);
	}

	remove(id, vars)
	{
	    this.container.get('services.request').basicCall("DELETE", "/api/v1/teams/"+id, vars);
	}
	
	get(id, vars)
	{
	    this.container.get('services.request').basicCall("GET", "/api/v1/teams/"+id, vars);
	}
}