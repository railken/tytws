
Object.defineProperty(Array.prototype, 'addUnique', {
    enumerable: false,
    value: function(attribute, value)
	{
		
		if (this.findByAttribute(attribute, value[attribute]) == null)
			this.push(value);

		return null;
	}
});

Object.defineProperty(Array.prototype, 'getByAttribute', {
    enumerable: false,
    value: function(attribute, value)
	{
		for (var i = 0; i < this.length; i++) {


			if (this[i] && (typeof this[i][attribute] !== "undefined") && this[i][attribute] == value) {

				return this[i];
			}
		}

		return null;
	}
});

Object.defineProperty(Array.prototype, 'findByAttribute', {
    enumerable: false,
    value: function(attribute, value)
	{	
		for (var i = 0; i < this.length; i++) {

			if (this[i] && (typeof this[i][attribute] !== "undefined") && this[i][attribute] == value) {

				return i;
			}
		}

		return null;
	}
});

Object.defineProperty(Array.prototype, 'updateByAttribute', {
    enumerable: false,
    value: function(attribute, value, data)
	{	
		var el = this.getByAttribute(attribute, value);

		if (!el)
			return null;

		for (x in data) {
			el[x] = data[x];
		}
	}
});