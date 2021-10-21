import {StringTool} from './StringTool.js';

export class SpreadSheetUploader {
	
	DOMElement = null;
	backendScriptURL = 'backend/GED/import-datas.php';
	self = null;
	fileInfos = null;
	allowedFileExtensions = ['ods', 'xls', 'xlsx'];
	maxFileSize = 2097152;

	constructor(relativeDOMElement) {
		if(relativeDOMElement !== null) {
			this.DOMElement = relativeDOMElement;
			this.setSubmitButtonBehavior();	
		}
		self = this;
	}

	checkIfSelectedFileIsOK(fileInfos) {
		if(fileInfos === null) {
			throw new Error('SpreadSheetUploader.checkIfSelectedFileIsOK error because not file information have been given as parameter');
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
		let fetchResponse = await fetch('./backend/import-datas.php', {
			method: 'POST',
			credentials: 'same-origin',
			body: new FormData(this.DOMElement.querySelector('form'))
		});

		if(fetchResponse.status != 200)
	    	throw new Error('Can not communicate with server (no 200 status)');

	    let response = await fetchResponse.json();
	}

	setSubmitButtonBehavior() {
		let submitButton = this.DOMElement.querySelector('button[name=submit]');
		submitButton.addEventListener('click', function(event) {
			event.preventDefault();

			try {
				let fileInfos = self.getSelectedFileInfo();
				var selectedFileIsOK = self.checkIfSelectedFileIsOK(fileInfos);

				if(selectedFileIsOK.success == false) {
					console.log(selectedFileIsOK.error);
				} else {
					let uploadResponse = self.sendFormularData();
				}
			} catch(error) {
				console.log(error);
			}

		})
	}
}