export class Request {

	constructor()
	{
		this.stackCall = [];
	}

	/**
	 * Make a call to api
	 *
	 * @param {string} method
	 * @param {string} url
	 * @param {object} params
	 * @param {closure} callback
	 *
	 * @return void
	 */
	call(method, url, params, callback){

		var self = this;

		var vars = {
			url: url,
			method: method,
			params: params,
			callback: callback
		};

		self.__call(method, url, params, callback);
		
	};


	obj_to_query(obj) {
	    var parts = [];
	    for (var key in obj) {
	        if (obj.hasOwnProperty(key)) {
	            parts.push(encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]));
	        }
	    }
	    return "?" + parts.join('&');
	}

	/**
	 * Make a call to api
	 *
	 * @param {string} method
	 * @param {string} url
	 * @param {object} params
	 * @param {closure} callback
	 *
	 * @return void
	 */
	__call(method, url, data, callback){

		var self = this;
		var params = data.params;
		var headers = data.headers;

		if (method == 'GET') {
			url += this.obj_to_query(params);
		}

		var call = {
			type: method,
			url: url, 
			data : params,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			success: function(response) {

				callback(response);
			},
			error: function(jqXHR, textStatus, errorThrown) {

				// If response is still in json than is still valid
				if (jqXHR && jqXHR.responseJSON) {

					callback(jqXHR.responseJSON);

				} else {

					console.log('Error during call: '+url);
					console.log(jqXHR);
					console.log(params);
					console.log(errorThrown);

					callback();

				}
			},
			xhrFields: {
				widthCredentials: false
			},
			dataType:'json',
			headers: headers
		};

				
		return $.ajax(call);
	};

	/**
	 * Fetch the response with call info
	 *
	 * @param {object} response
	 * @param {object} call
	 *
	 * @¶eturn void
	 */
	fetchResponse(response, call)
	{

		if (!response) {

			if (call.fatal) {
				
				call.fatal();

			} else {
				
				call.error();

			}

			return;
		}
		
		/** Basic API **/
		if(response.status == 'success' && call.success != undefined) {
			call.success(response);
			return;
		}
		
		if(response.status == 'error' && call.error != undefined) {

			call.error(response);
			return;
		}

		if(response.error != undefined) {

			call.error(response);
			return;
		}


	};

	/**
	 * Call basic 
	 *
	 * @param {string} method
	 * @param {string} url
	 * @param {object} call
	 *
	 * @return void
	 */
	basicCall(method, url, call)
	{
		var self = this;
		var params = call.params != undefined ? call.params : {};
		var headers = call.headers != undefined ? call.headers : {};

		self.call(method, url, { headers: headers, params: params }, function(response) {

			self.fetchResponse(response, call);

		});
	}
}