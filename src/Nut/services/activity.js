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

	paramsToHttp(params)
	{

		var c = {};

		for (var i in params)
			c[i] = params[i];


        c.started_at = c.started_at.format("YYYY-MM-DD HH:mm:00");
        c.ended_at = c.ended_at.format("YYYY-MM-DD HH:mm:00");

        if (c.team)
        	c.team_id = c.team.id;

        return c;
	}

	responseToEntity(obj)
	{

        obj.started_at = container.get('date')(obj.started_at, "YYYY-MM-DD HH:mm:ss");
        obj.ended_at = container.get('date')(obj.ended_at, "YYYY-MM-DD HH:mm:ss");

        return obj;
	}

	all(vars)
	{
		var self = this;
		
	    this.request("GET", "/user/activities", {
	    	params: vars.params,
	    	success: function(response) {

	    		for (var i in response.data.resources) {
	    			response.data.resources[i] = self.responseToEntity(response.data.resources[i]);
	    		}

	    		vars.success(response);
	    	},
	    	error: function(response) {
	    		vars.error(response);
	    	}
	    });
	}

	insert(vars)
	{
		var self = this;
		
		vars.params = this.paramsToHttp(vars.params);
	    this.request("POST", "/user/activities", {
	    	params: vars.params,
	    	success: function(response) {

	    		response.data.resource = self.responseToEntity(response.data.resources);

	    		vars.success(response);
	    	},
	    	error: function(response) {
	    		vars.error(response);
	    	}
	    });
	}

	update(id, vars)
	{
		var self = this;
		
		vars.params = this.paramsToHttp(vars.params);
	    this.request("PUT", "/user/activities/"+id, {
	    	params: vars.params,
	    	success: function(response) {
	    		response.data.resource = self.responseToEntity(response.data.resources);
	    		vars.success(response);
	    	},
	    	error: function(response) {
	    		vars.error(response);
	    	}
	    });
	}

	remove(id, vars)
	{
	    this.request("DELETE", "/user/activities/"+id, {
	    	params: vars.params,
	    	success: function(response) {
	    		vars.success(response);
	    	},
	    	error: function(response) {
	    		vars.error(response);
	    	}
	    });
	}
	
	get(id, vars)
	{
		var self = this;
		
		this.request("GET", "/user/activities/"+id, {
			params: vars.params,
			success: function(response) {
	    		response.data.resource = self.responseToEntity(response.data.resources);
				vars.success(response);
			},
			error: function(response) {
				vars.error(response);
			}
		});
	}
}