import {DataGrabber} 	from './DataGrabber.js';
import {DataPusher} 	from './DataPusher.js';
import {TemplateLoader} from './TemplateLoader.js';
import {ScriptExecutor} from './ScriptExecutor.js';

/*
*	Once you got data from school sheet file, ask the user if data are correct before inserting them in DB
*/
export class SchoolSheetImporter {

	data = null;
	DOMElement = null;

	constructor(data = null) {
		this.setData(data);
		this.DOMElement = document.querySelector('div.overlay');
	}

	setData(data) {
		this.data = data;
	}

	startPrompting() {
		this.askForSchoolInfoConfirmation();
	}

	askForSchoolInfoConfirmation() {
		// search for an existing school in the DB
		let schoolListGrabber = new DataGrabber("r-schools.php");

		let loadForm = function() {
			// School not found
			if(schoolListGrabber.grabbedData.results.length < 1) {
				this.DOMElement.innerHTML = "L'école n'existe pas dans la base de données. Voulez-vous la créer ?<br />";
				let displayForm = function() {
					this.DOMElement.innerHTML += schoolCreationFormLoader.templateContent;
					this.setSchoolCreationFormBehavior();
				}

				let schoolCreationFormLoader = new TemplateLoader('form-create-school.php');

				schoolCreationFormLoader.load([
					['UAI', this.data.school.UAI],
					['name', this.data.school.name],
					['address', this.data.school.address],
					['phoneNumber', this.data.school.phoneNumber],
					['emailAddress', this.data.school.emailAddress],
					['midSchool', this.data.school.midSchool],
					['library', this.data.school.library]
				], displayForm.bind(this));
			} else {
				let displayForm = function() {

				}
				this.DOMElement.innerHTML = 'école trouvée';

			}
		}
		

		schoolListGrabber.getData([
			['UAI', this.data.school.UAI], 
			['name', this.data.school.name],
			['emailAddress', this.data.school.emailAddress]
		], loadForm.bind(this));
		
	}

	setSchoolCreationFormBehavior() {
		let form = this.DOMElement.querySelector('form');
		let button = form.querySelector('button#validate');
		button.addEventListener('click', function(event) {
			event.preventDefault();
			let pusher = new DataPusher('c-school.php');
			let formValues = [
				['UAI', form.querySelector('input[name=UAI]').value],
				['name', form.querySelector('input[name=name]').value],
				['address', form.querySelector('input[name=address]').value],
				['phoneNumber', form.querySelector('input[name=phoneNumber]').value],
				['emailAddress', form.querySelector('input[name=emailAddress]').value],
				['midSchool', form.querySelector('input[name=midSchool]').value],
				['library', form.querySelector('input[name=library]').value]
			];

			let getPushResult = function() {
				console.log(pusher.pushResult);
			}

			pusher.pushData(formValues, getPushResult().bind(this));
		});
	}

}