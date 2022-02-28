import {StringTool} from './StringTool.js';
import {Event} from './Event.js';
import {EventDispatcher} from './EventDispatcher.js';

export class SpreadSheetUploader extends EventDispatcher {
	
	static FILE_IMPORTED_EVENT = 'file uploaded';

	type = 'SpreadSheetUploader';
	DOMElement = null;
	backendScriptURL = './backend/import-datas-file.php';
	fileInfos = null;
	allowedFileExtensions = ['ods', 'xls', 'xlsx'];
	maxFileSize = 2097152;

	constructor(relativeDOMElement) {
		super();
		if(relativeDOMElement !== null) {
			this.DOMElement = relativeDOMElement;
			this.setSubmitButtonBehavior();	
		}
	}

	checkIfSelectedFileIsOK(fileInfos) {
		if(fileInfos === null) {
			throw new Error('SpreadSheetUploader.checkIfSelectedFileIsOK error because no file information have been given as parameter');
			return { success: false, error: 'no file info', code: 0 };
		} else {

			let fileNameExtension = StringTool.getExtensionFromFileName(fileInfos.name);
			if(fileNameExtension == false) {
				throw new Error('SpreadSheetUploader.checkIfSelectedFileIsOK error because no extension has been found in file name, so the function was unable to check if the extension is allowed.');
				return { success: false, error: 'file name has no extension', code: 1 };
			}
			let isFileExtensionAllowed = (this.allowedFileExtensions.indexOf(fileNameExtension)===-1?false:true);
			if(!isFileExtensionAllowed) return { success: false, error: 'file extension not allowed', code: 2 };

			if(fileInfos.size > this.maxFileSize) return { success: false, error: 'file size exceed limit ('+this.maxFileSize+')', code: 3};

			return { success: true };
		}
	}

	getSelectedFileInfo() {
		let formFileElement = this.DOMElement.querySelector('input[type=file][name=spreadSheet]');
		if(formFileElement.files.length == 0) {
			throw new Error('no file selected');
			return false;
		} else {
			var fileInfos = formFileElement.files[0];
			return fileInfos;
		}
	}

	async sendFormularData() {
		let fetchResponse = await fetch(this.backendScriptURL, {
			method: 'POST',
			credentials: 'same-origin',
			body: new FormData(this.DOMElement.querySelector('form'))
		});

		if(fetchResponse.status != 200)
	    	throw new Error('Impossible de charger les script serveur (erreur 200 status)');

	    let response = await fetchResponse.json();
	    if(response.success) {
	    	this.dispatchEvent(new Event(SpreadSheetUploader.FILE_IMPORTED_EVENT));
	    }
	}

	setSubmitButtonBehavior() {
		let submitButton = this.DOMElement.querySelector('button[name=submit]');

		submitButton.addEventListener('click', this.validateFormular.bind(this), false);
	}

	validateFormular(event) {
		event.preventDefault();
		try {
			let fileInfos = this.getSelectedFileInfo();
			var selectedFileIsOK = this.checkIfSelectedFileIsOK(fileInfos);

			if(selectedFileIsOK.success == false) {
				console.log(selectedFileIsOK.error);
			} else {
				let uploadResponse = this.sendFormularData();
			}
		} catch(error) {
			console.log(error);
		}
	}
}