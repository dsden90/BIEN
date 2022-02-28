import {Event} from './Event.js';
import {EventDispatcher} from './EventDispatcher.js';

export class DataWiper extends EventDispatcher {

	static DATA_WIPED_EVENT = 'all data wiped';
	
	backendScriptURL = '';
	lastRequestValue = null;

	constructor(phpDBScript) {
		super();
		this.backendScriptURL = './backend/DB/'+phpDBScript;
	}

	// filters: select the datas you want to wiper, can be an id, etc.
	// callback:function called when php response loaded
	async wipeDatas(filters, callback = function(){}) {
		let postDataBody = {}

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
			throw new Error('Impossible d\'accéder au server (erreur 200 status)');

		let response = await fetchResponse.json();
		this.lastRequestValue = response;
		callback();
		this.dispatchEvent(new Event(DataWiper.DATA_WIPED_EVENT));
		return this.lastRequestValue;
	}
}