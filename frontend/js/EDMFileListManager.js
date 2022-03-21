import {DataWiper} from './DataWiper.js';
import {DataGrabber} from './DataGrabber.js';
import {ScriptExecutor} from './ScriptExecutor.js';
import {SchoolSheetImporter} from './SchoolSheetImporter.js';

export class EDMFileListManager {
	
	HTMLContainer = null;
	HTMLContent = null;
	data = null;

	constructor(HTMLContainer) {
		if(HTMLContainer !== null) {
			this.HTMLContainer = HTMLContainer;
		}
	}

	display() {
		this.HTMLContainer.innerHTML = this.HTMLContent;
		this.setButtonsBehaviors();
	}

	generateHTML(data = null) {
		let generatedHTML = "Aucun fichiers à afficher";

		if(data != null)
			this.setData(data);

		if(this.data != null) {
			generatedHTML = "<table><tr><td>Nom</td><td>Type</td><td>Propriétaire</td><td>Statut</td><td>Actions</td></tr>";
			let nbFiles = this.data.length;
			for(let fileIndex = 0; fileIndex < nbFiles; fileIndex++) {
				generatedHTML += '<tr><td>'+this.data[fileIndex].name+'</td>';
				generatedHTML += '<td>'+this.data[fileIndex].file_type+'</td>';
				generatedHTML += '<td>'+this.data[fileIndex].owner+'</td>';
				generatedHTML += '<td>'+this.data[fileIndex].state+'</td>';
				generatedHTML += '<td>';
					// generatedHTML += '<a href="#approve'+this.data[fileIndex].id+'" class="action-button" data-id="'+this.data[fileIndex].id+'" data-action="next-step">Approuver</a> ';
					generatedHTML += '<a href="#treat'+this.data[fileIndex].id+'" class="action-button" data-id="'+this.data[fileIndex].id+'" data-action="treat">Traiter</a> ';
					generatedHTML += '<a href="#" class="action-button" data-id="'+this.data[fileIndex].id+'" data-action="delete">Supprimer</a>';
				generatedHTML += '</td></tr>';
			}
			generatedHTML += "</table>";
		}
		this.HTMLContent = generatedHTML;
		return generatedHTML;
	}

	deleteDatas(event = null) {
		if(event !== null) {
			let wiper = new DataWiper('d-edm-file.php');
			wiper.addEventListener(DataWiper.DATA_WIPED_EVENT, this.loadDatas.bind(this));
			wiper.wipeData([['file_id', parseInt(event.target.dataset.id)]]);
		}
	}

	loadDatas(event = null) {
		let fileListGrabber = new DataGrabber("r-edm-files.php");
		let refreshDisplay = function() {
			this.generateHTML(fileListGrabber.grabbedData.results);
			this.display();
		};

		fileListGrabber.getData([], refreshDisplay.bind(this)
			);
	}

	treatDatas(event = null) {
		// ask backend script to extract data from the selected file
		let executor = new ScriptExecutor("extract-data-from-file.php");
		executor.executeScript({fileId: event.target.dataset.id}).then(
			function(value) {
				if(value.type == "fiche école") {
					let confirmationPrompter = new SchoolSheetImporter(value.data);
					confirmationPrompter.startPrompting();
				}
			},
			function(error) {
				console.log(error);
			}
		);
	}

	setButtonsBehaviors() {
		let deleteButtons = this.HTMLContainer.querySelectorAll("a.action-button[data-action='delete']");
		for(let i = deleteButtons.length-1; i >= 0; i--) {
			deleteButtons[i].addEventListener('click', this.deleteDatas.bind(this));
		}

		let treatButtons = this.HTMLContainer.querySelectorAll("a.action-button[data-action='treat']");
		for(let i = treatButtons.length-1; i >= 0; i--) {
			treatButtons[i].addEventListener('click', this.treatDatas.bind(this));
		}
	}

	setData(data) {
		this.data = data;
	}
}