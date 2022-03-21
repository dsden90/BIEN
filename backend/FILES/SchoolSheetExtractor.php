<?php
/**
 * School Sheet Extractor
 * Extrait les données d'une fiche école
 */

require_once('SheetManager.php');

class SchoolSheetExtractor {

	private $sheetManager;

	function __construct($uri) {
		$this->sheetManager = new SheetManager();
		$this->sheetManager->load($uri);
	}

	/*
	* Check if there are no teacher in the class
	*/
	function checkIfClassIsEmpty($lineIndex) {
		$teacherOne = $this->sheetManager->getCellValue('B'.$lineIndex);
		$teacherTwo = $this->sheetManager->getCellValue('B'.($lineIndex+1));
		return ($teacherOne == "" && $teacherTwo == "")?true:false;
	}

	function getAddress() {
		return $this->sheetManager->getCellValue('D4');
	}

	function getAdministrativeCitiesCommunity() {
		$community = new stdClass();
		$community->name = $this->getAdministrativeCitiesCommunityName();
		$community->emailAddress = $this->getAdministrativeCitiesCommunityEmailAddress();
		$community->phoneNumber = $this->getAdministrativeCitiesCommunityPhoneNumber();
		$community->presidentName = $this->getAdministrativeCitiesCommunityPresidentName();
		return $community;
	}

	function getAdministrativeCitiesCommunityName() {
		return $this->sheetManager->getCellValue('D12');
	}

	function getAdministrativeCitiesCommunityEmailAddress() {
		return $this->sheetManager->getCellValue('D15');
	}

	function getAdministrativeCitiesCommunityPhoneNumber() {
		return $this->sheetManager->getCellValue('D14');
	}

	function getAdministrativeCitiesCommunityPresidentName() {
		return $this->sheetManager->getCellValue('D13');
	}

	function getCityMayorName() {
		return $this->sheetManager->getCellValue('D9');
	}

	function getCityMayorEmailAddress() {
		return $this->sheetManager->getCellValue('D11');
	}

	function getCityMayorPhoneNumber() {
		return $this->sheetManager->getCellValue('D10');
	}

	function getClass($lineIndex) {
		$class = new stdClass();
		$class->name = $this->sheetManager->getCellValue('A'.$lineIndex);

		$class->teachers = $this->getWorkers($lineIndex);

		$class->levels = array();
		$cellLetterIndex = 'MNOPQRSTU';
		for($letterIndex = 0; $letterIndex < strlen($cellLetterIndex); $letterIndex++) {
			$headCount = $this->sheetManager->getCellValue(substr($cellLetterIndex, $letterIndex, 1).$lineIndex);
			if($headCount > 0) {
				$level = new stdClass();
				$level->name = $this->sheetManager->getCellValue(substr($cellLetterIndex, $letterIndex, 1).'19');
				$level->headCount = $headCount;
				$level->ulisCount = $this->sheetManager->getCellValue('V'.$lineIndex);
				array_push($class->levels, $level);
			}
		}

		return $class;
	}

	function getDirectorName() {
		return $this->sheetManager->getCellValue('O13');
	}

	function getDirectorPhoneNumber() {
		return $this->sheetManager->getCellValue('S13');
	}

	function getDirectorSubstitue() {
		return $this->sheetManager->getCellValue('O14');
	}

	function getEmailAddress() {
		return $this->sheetManager->getCellValue('D6');
	}

	function getLibrary() {
		return $this->sheetManager->getCellValue('D16');
	}

	function getLMS() {
		return $this->sheetManager->getCellValue('D7');
	}

	function getMidSchool() {
		return $this->sheetManager->getCellValue('D8');
	}

	function getName() {
		return $this->sheetManager->getCellValue('B2');
	}

	function getPhoneNumber() {
		return $this->sheetManager->getCellValue('D5');
	}

	function getTimeTableDay($spreadsheetLine) {
		$day = new stdClass();
		$day->AMOpening = $this->sheetManager->getCellValue('K'.$spreadsheetLine);
		$day->AMClosing = $this->sheetManager->getCellValue('L'.$spreadsheetLine);
		$day->PMOpening = $this->sheetManager->getCellValue('N'.$spreadsheetLine);
		$day->PMClosing = $this->sheetManager->getCellValue('O'.$spreadsheetLine);
		return $day;
	}

	function getUAI() {
		return $this->sheetManager->getCellValue('D3');
	}

	function getWorkers($lineIndex) {
		$workers = array();
		if($this->sheetManager->getCellValue('B'.$lineIndex) !== "") {
			$workers[0] = new stdClass();
			$workers[0]->name = $this->sheetManager->getCellValue('B'.$lineIndex);
			$workers[0]->substitueName = $this->sheetManager->getCellValue('C'.$lineIndex);
			$workers[0]->status = $this->sheetManager->getCellValue('D'.$lineIndex);
			$workers[0]->typeOfPosition = $this->sheetManager->getCellValue('E'.$lineIndex);
			$workers[0]->extraMission = $this->sheetManager->getCellValue('F'.$lineIndex);
			$workers[0]->foreignLanguage = $this->sheetManager->getCellValue('G'.$lineIndex);
			$workers[0]->timeQuota = $this->sheetManager->getCellValue('H'.$lineIndex);
		}
		return $workers;
	}

	/*
	* Mega shortcut that gives all the data
	*/

	function extractAll() {
		$infoBox = new stdClass();
		$infoBox->school = $this->getSchool();
		$infoBox->cityMayor = $this->getCityMayor();
		$infoBox->AdministrativeCitiesCommunity = $this->getAdministrativeCitiesCommunity();
		$infoBox->timeTable = $this->getTimeTable();
		$infoBox->director = $this->getDirector();
		$infoBox->classes = $this->getClasses();
		$infoBox->extraWorkers = $this->getExtraWorkers();
		return $infoBox;
	}

	/*
	* Functions that concat other functions of this class
	* (kind of shortcuts that merge data)
	*/

	function getCityMayor() {
		$mayor = new stdClass();
		$mayor->name = $this->getCityMayorName();
		$mayor->emailAddress = $this->getCityMayorEmailAddress();
		$mayor->phoneNumber = $this->getCityMayorPhoneNumber();
		return $mayor;
	}

	function getSchool() {
		$school = new stdClass();
		$school->name = $this->getName();
		$school->UAI = $this->getUAI();
		$school->address = $this->getAddress();
		$school->phoneNumber = $this->getPhoneNumber();
		$school->emailAddress = $this->getEmailAddress();
		$school->LMS = $this->getLMS();
		$school->midSchool = $this->getMidSchool();
		$school->library = $this->getLibrary();
		return $school;
	}

	function getTimeTable() {
		$timeTable = new stdClass();
		
		$timeTable->monday = $this->getTimeTableDay('5');
		$timeTable->tuesday = $this->getTimeTableDay('6');
		$timeTable->wednesday = $this->getTimeTableDay('7');
		$timeTable->thursday = $this->getTimeTableDay('8');
		$timeTable->friday = $this->getTimeTableDay('9');
		return $timeTable;
	}

	function getDirector() {
		$director = new stdClass();

		$director->name = $this->getDirectorName();
		$director->phoneNumber = $this->getDirectorPhoneNumber();
		$director->subsitute = $this->getDirectorSubstitue();
		return $director;
	}

	function getClasses() {
		$classes = array();
		$classCellIndex = 20;
		while(!$this->checkIfClassIsEmpty($classCellIndex)) {
			array_push($classes, $this->getClass($classCellIndex));
			$classCellIndex += 2;
		}
		return $classes;
	}

	function getExtraWorkers() {
		$extraWorkers = array();

		$firstClassLineIndex = 20;
		$currentReadLine = $firstClassLineIndex;
		while($this->sheetManager->getCellValue('A'.$currentReadLine) != 'TR') {
			$currentReadLine++;
		}

		while($this->sheetManager->getCellValue('A'.$currentReadLine) != "") {
			$workers = $this->getWorkers($currentReadLine);
			for($workerIndex = 0; $workerIndex < count($workers); $workerIndex++) {
				if($workers[$workerIndex]->name !== null) {
					$workers[$workerIndex]->mission = $this->sheetManager->getCellValue('A'.$currentReadLine);
					array_push($extraWorkers, $workers);
				}
			}
			$currentReadLine += 2;
		}
		
		return $extraWorkers;
	}

}
?>