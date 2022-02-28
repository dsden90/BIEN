// ask serveur to execute script and return result
export class ScriptExecutor {
	
	backendScriptURL = '';
	resultingDatas = null;

	constructor(phpScript) {
		this.backendScriptURL = './backend/'+phpDBScript+'.php';
	}

	// callback:function called when data are loaded
	async executeScript(callback = function(){}, params = null) {
		let fetchResponse = await fetch(this.backendScriptURL, {
			method: 'GET'
		});


		if(fetchResponse.status != 200)
			throw new Error('Impossible d\'accéder au server (erreur 200 status)');

		let response = await fetchResponse.json();
		this.resultingDatas = response;
		callback();
		return this.resultingDatas;
	}
}