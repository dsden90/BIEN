// ask serveur to execute script and return result
export class ScriptExecutor {
	
	backendScriptName = '';
	resultingData = null;
	params = null;

	constructor(phpScript) {
		this.backendScriptName = './backend/'+phpScript;
	}

	async executeScript(params = {}, callback = function(){}) {
		let fetchResponse = await fetch(this.backendScriptName,
			{
				method: 'POST',
				body: JSON.stringify(params),
				headers: {
					'Content-Type': 'application/json'
				},
			}
		);

		if(fetchResponse.status != 200)
			throw new Error('Unable to reach server side script (error: no 200 status)');

		this.resultingData = await fetchResponse.json();
		callback();
		return this.resultingData;
	}
}