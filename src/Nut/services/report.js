import { container } from './container';

export class ReportService
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

	activities(vars)
	{
	    this.request("GET", "/user/reports/activities", vars);
	}
}