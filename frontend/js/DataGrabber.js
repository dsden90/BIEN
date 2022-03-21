import {Event} from './Event.js';
import {EventDispatcher} from './EventDispatcher.js';

export class DataGrabber extends EventDispatcher {
	
	static DATA_GRABBED_EVENT = 'all data grabbed';

	DOMElement = null;
	backendScriptURL = '';
	grabbedData = null;

	constructor(phpDBScript, relativeDOMElement) {
		super();
		if(relativeDOMElement !== null) {
			this.DOMElement = relativeDOMElement;
		}
		this.backendScriptURL = './backend/DB/'+phpDBScript;
	}

	// filters: select the datas you want to grab, can be an id, etc.
	// callback:function called when php response loaded
	async getData(filters, callback = function(){}) {
		let postDataBody = {};

		for(let i = 0; i < filters.length; i++) {
			postDataBody[filters[i][0]] = filters[i][1];
		}

		let fetchResponse = await fetch(this.backendScriptURL, {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(postDataBody)
		});


		if(fetchResponse.status != 200)
			throw new Error('Unable to reach server side data grabber (error: no 200 status)');

		this.grabbedData = await fetchResponse.json();
		this.dispatchEvent(new Event(DataGrabber.DATA_GRABBED_EVENT));
		callback();
		return this.grabbedData;
	}
}