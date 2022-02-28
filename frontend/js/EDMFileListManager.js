import {DataWiper} from './DataWiper.js';
import {DataGrabber} from './DataGrabber.js';
import {ScriptExecutor} from './ScriptExecutor.js';

export class EDMFileListManager {
	
	HTMLContainer = null;
	HTMLContent = null;
	datas = null;

	constructor(HTMLContainer) {
		if(HTMLContainer !== null) {
			this.HTMLContainer = HTMLContainer;
		}
	}

	display() {
		this.HTMLContainer.innerHTML = this.HTMLContent;
		this.setButtonsBehaviors();
	}

	generateHTML(datas = null) {
		let generatedHTML = "Aucun fichiers à afficher";

		if(datas != null)
			this.setDatas(datas);

		if(this.datas != null) {
			generatedHTML = "<table><tr><td>Nom</td><td>Type</td><td>Propriétaire</td><td>Statut</td><td>Actions</td></tr>";
			let nbFiles = this.datas.length;
			for(let fileIndex = 0; fileIndex < nbFiles; fileIndex++) {
				generatedHTML += '<tr><td>'+this.datas[fileIndex].name+'</td>';
				generatedHTML += '<td>'+this.datas[fileIndex].file_type+'</td>';
				generatedHTML += '<td>'+this.datas[fileIndex].owner+'</td>';
				generatedHTML += '<td>'+this.datas[fileIndex].state+'</td>';
				generatedHTML += '<td>';
					// generatedHTML += '<a href="#approve'+this.datas[fileIndex].id+'" class="action-button" data-id="'+this.datas[fileIndex].id+'" data-action="next-step">Approuver</a> ';
					generatedHTML += '<a href="#treat'+this.datas[fileIndex].id+'" class="action-button" data-id="'+this.datas[fileIndex].id+'" data-action="treat">Traiter</a> ';
					generatedHTML += '<a href="#" class="action-button" data-id="'+this.datas[fileIndex].id+'" data-action="delete">Supprimer</a>';
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
			wiper.wipeDatas([['file_id', parseInt(event.target.dataset.id)]]);
		}
	}

	loadDatas(event = null) {
		let fileListGrabber = new DataGrabber("r-edm-files.php");
		let refreshDisplay = function() {
			this.generateHTML(fileListGrabber.grabbedDatas.results);
			this.display();
		};

		fileListGrabber.getDatas(refreshDisplay.bind(this)
			);
	}

	treatDatas(event = null) {
		// ask backend script to extr&act data from the selected file
		let fileDataExtractorGrabber = new ScriptExecutor("EDM/extract-data-from-file");
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

	setDatas(datas) {
		this.datas = datas;
	}
}