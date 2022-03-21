import {Event} from './Event.js';
import {EventDispatcher} from './EventDispatcher.js';

export class DataPusher extends EventDispatcher {
	
	static DATA_PUSHED_EVENT = 'all data pushed';

	backendScriptURL = '';
	pushResult = null;

	constructor(phpDBScript) {
		super();
		this.backendScriptURL = './backend/DB/'+phpDBScript;
	}

	async pushData(data, callback = function(){}) {
		let postDataBody = data;

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
			throw new Error('Unable to reach server side data pusher (error: no 200 status)');

		this.pushResult = await fetchResponse.json();
		this.dispatchEvent(new Event(DataGrabber.DATA_PUSHED_EVENT));
		callback();
		return this.pushResult;
	}
}