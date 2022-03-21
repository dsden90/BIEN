import {Event} from './Event.js';
import {EventDispatcher} from './EventDispatcher.js';

export class TemplateLoader extends EventDispatcher {
	
	static TEMPLATE_LOADED = 'template loaded';

	templateURI = null;
	templateContent = "";

	constructor(templateURI) {
		super();
		this.templateURI = './frontend/'+templateURI;
	}

	// data: the data you want to push in the template
	async load(data, callback = function(){}) {
		let postDataBody = {};

		for(let i = 0; i < data.length; i++) {
			postDataBody[data[i][0]] = data[i][1];
		}

		let fetchResponse = await fetch(this.templateURI, {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(postDataBody)
		});


		if(fetchResponse.status != 200)
			throw new Error('Unable to load template (error: no 200 status)');

		this.templateContent = await fetchResponse.text();
		this.dispatchEvent(new Event(TemplateLoader.TEMPLATE_LOADED));
		callback();
		return this.templateContent;
	}
}