<?php

use Edu\Cnm\Growify\CompanionPlant;
use Edu\Cnm\Growify\CombativePlant;
use Edu\Cnm\Growify\Plant;


/**
 * import data about pairs of companion and combative plants.
 * source: http://www.ufseeds.com/Vegetable-Companion-Planting-Chart.html
 */


require_once "/etc/apache2/capstone-mysql/encrypted-config.php";
require_once(dirname(__DIR__) . "/classes/autoload.php");

$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/growify.ini");

importCompanionPlants($pdo);
importCombativePlants($pdo);

function importCompanionPlants(\PDO  $pdo) {
	echo "-- Companion Plants -- ";

	if(($handle = fopen("companion-plants-latin-names.csv", "r")) !== FALSE) {
		while(($dataCSV = fgetcsv($handle, 0, ",", "\"")) !== FALSE) { // set length to zero for unlimited line length php > 5.1

			$plant1Name = trim($dataCSV[0]);
			$plant2Name = trim($dataCSV[1]);

			$plant1LatinName = trim($dataCSV[2]);
			$plant2LatinName = trim($dataCSV[3]);

			echo $plant1Name.", ".$plant2Name.", ".$plant1LatinName.", ".$plant2LatinName."<br/>";

			try {
				$companionEntry = new CompanionPlant($plant1Name, $plant2Name, $plant1LatinName, $plant2LatinName);

				$companionEntry->insert($pdo);
			} catch(\PDOException $pe) {
				echo($pe->getMessage() . "<br/>");
			}

		}
	}
}

function importCombativePlants(\PDO  $pdo) {

	echo "-- Combative Plants --";

	if(($handle = fopen("combative-plants-latin-names.csv", "r")) !== FALSE) {
		while(($dataCSV = fgetcsv($handle, 0, ",", "\"")) !== FALSE) { // set length to zero for unlimited line length php > 5.1

			$plant1Name = trim($dataCSV[0]);
			$plant2Name = trim($dataCSV[1]);

			$plant1LatinName = trim($dataCSV[2]);
			$plant2LatinName = trim($dataCSV[3]);

			echo $plant1Name.", ".$plant2Name.", ".$plant1LatinName.", ".$plant2LatinName."<br/>";

			try {
				$combativeEntry = new CombativePlant($plant1Name, $plant2Name, $plant1LatinName, $plant2LatinName);

				$combativeEntry->insert($pdo);
			} catch(\PDOException $pe) {
				echo($pe->getMessage() . "<br/>");
			}

		}
	}
}