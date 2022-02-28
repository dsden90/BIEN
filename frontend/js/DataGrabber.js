export class DataGrabber {
	
	DOMElement = null;
	backendScriptURL = '';
	grabbedDatas = null;

	constructor(phpDBScript, relativeDOMElement) {
		if(relativeDOMElement !== null) {
			this.DOMElement = relativeDOMElement;
		}
		this.backendScriptURL = './backend/DB/'+phpDBScript;
	}

	// callback:function called when data are loaded
	async getDatas(callback = function(){}) {
		let fetchResponse = await fetch(this.backendScriptURL, {
			method: 'GET'
		});


		if(fetchResponse.status != 200)
			throw new Error('Impossible d\'accéder au server (erreur 200 status)');

		let response = await fetchResponse.json();
		this.grabbedDatas = response;
		callback();
		return this.grabbedDatas;
	}
}