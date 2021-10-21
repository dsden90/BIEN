export class StringTool {
	
	constructor() {}

	static getExtensionFromFileName(fileName) {
		var matches = fileName.match(/\.\w+/g);
		if(matches.length > 0) {
			var fileExtension = matches[matches.length-1].substring(1);
			return fileExtension;
		} else {
			return false;
		}
	}

}