<?php

/**
 * Import plant information into Plant table. from
 * plants for a future and NMSU vegetable tables.
 * run this before running plantAreaImport.php
 * but NOTE: if this script is re-run, the plantAreaImport.php script
 * should also be re-run in order to ensure the plantIds are correctly
 * cross-referenced.
 *
 * source: http://pfaf.org/
 * source: http://aces.nmsu.edu/pubs/_circulars/CR457B.pdf

 */

use Edu\Cnm\Growify\Plant;

// minimum temp (degrees F) for USDA plant hardiness zones in NM
// source: http://planthardiness.ars.usda.gov/
$usdaHardinessZones = [
	"1a" => -60.0,
	"1b" => -55.0,
	"2a" => -50.0,
	"2b" => -45.0,
	"3a" => -40.0,
	"3b" => -35.0,
	"4a" => -30.0,
	"4b" => -25.0,
	"5a" => -20.0,
	"5b" => -15.0,
	"6a" => -10.0,
	"6b" => -5.0,
	"7a" => 0.0,
	"7b" => 5.0,
	"8a" => 10.0,
	"8b" => 15.0,
	"9a" => 20.0,
	"9b" => 25.0,
	"10a" => 30,
	"10b" => 35,
	"11a" => 40,
	"11b" => 45,
	"12a" => 50,
	"12b" => 55,
	"13a" => 60,
	"13b" => 65
];

// cross-reference USDA plant hardiness (min winter temp) to NMSU planting areas
// source http://aces.nmsu.edu/pubs/_circulars/CR457B.pdf

$usdaHardinessToNMSUAreas = [
	"4a" => 3,
	"4b" => 3,
	"5a" => 3,
	"5b" => 3,
	"6a" => 3,
	"6b" => 2,
	"7a" => 2,
	"7b" => 1,
	"8a" => 1,
	"8b" => 1,
	"9a" => 1,
	"9b" => 1
];

require_once "/etc/apache2/capstone-mysql/encrypted-config.php";
require_once(dirname(__DIR__) . "/classes/autoload.php");


$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/growify.ini");

// works best if you insert plants for afuture first.
function insertPlantData(\PDO $pdo){
	insertPlantsForAFuture($pdo);
	insertNMSUPlantData($pdo);
}

// iterate over PlantsForAFuture data and add to Plant table.
function insertPlantsForAFuture(\PDO $pdo){

	global $usdaHardinessZones; // access global data

// get line-by-line with pdo object.
	$query = "SELECT `Latin name`, `Common name`, `Habit`, `Height`, `Width`, `Hardyness`, `FrostTender`, `Moisture`, `Edible uses`, `Uses notes`, `Cultivation details`, `Propagation 1`, `Author`, `Botanical references` FROM PlantsForAFuture ";
	$statement = $pdo->prepare($query);
	$statement->execute();

	// get data from PDO object
	try {
		$plant = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);


		while(($row = $statement->fetch()) !== false ) {
			if($row !== false) {
				$plantName = $row["Common name"];
				$latinName = $row["Latin name"];
				$plantVariety = null;
				$plantType = $row["Habit"];

				// plant description - take from plant uses, uses notes, cultivation details, propagation, author, references
				$plantDescription = $row["Edible uses"] ." ". $row["Uses notes"] ." ". $row["Cultivation details"] ." ". $row["Propagation 1"] ." ". $row["Author"] ." ". $row["Botanical references"];
				$plantSpread = floatval($row["Width"])*3.2808; //  meters - convert to feet
				$plantHeight = floatval($row["Height"])*3.2808; //  meters - convert to feet
				$plantDaysToHarvest = null; // not provided in this table

				// get min temps -
				// if hardiness data available get from there
				$plantMinTemp = 32; // default min temp is 32 F
				$hardiness = null;
				if($row["Hardyness"] !== null) {
					$hardiness = intval($row["Hardyness"]);
					if($hardiness > 0) {

						$plantMinTemp = $usdaHardinessZones[$hardiness . "b"];
					}
				}

				// if plant is "frost tender" then set to 32F (esp. if this is higher than hardiness zone temp
				if($row["FrostTender"] === "Y") {
					if($plantMinTemp < 32) {
						$plantMinTemp = 32;
					}
				}
				// (if nothing specified, default to 32F)

				$plantMaxTemp = null; // we dont have ANY data for this. :P

				$plantSoilMoisture = $row["Moisture"];

				$plant = new Plant(null, $plantName, $latinName, $plantVariety, $plantDescription, $plantType, $plantSpread, $plantHeight, $plantDaysToHarvest, $plantMinTemp, $plantMaxTemp, $plantSoilMoisture);
				$plant->insert($pdo);
			}
		}

		echo $plant->getPlantId()."<br>";
		/*echo $plant->getPlantName()."<br>";*/
		echo "adding plant: ".$plant->getPlantLatinName()."<br>";
		/*echo $plant->getPlantVariety()."<br>";
		echo $plant->getPlantType()."<br>";
		echo $plant->getPlantDescription()."<br>";
		echo $plant->getPlantSpread()."<br>";
		echo $plant->getPlantHeight()."<br>";
		echo $plant->getPlantDaysToHarvest()."<br>";
		echo $plant->getPlantMinTemp()."<br>";
		echo $plant->getPlantMaxTemp()."<br>";
		echo $plant->getPlantSoilMoisture()."<br>";*/



	} catch (\PDOException $pdoe){
		throw(new \PDOException($pdoe->getMessage(), 0, $pdoe));

	}
}

// iterate over NMSU Vegetable Data and add to Plant table (remember to check if an entry already exists for a given Plant Name.
function insertNMSUPlantData(\PDO $pdo){


	// keep a list of the plants for a future entries that we have visited so we can delete any duplicates.
	$pfafPlantsUpdated = [];

	// get a row from CSV

	if(($handle = fopen("NMSUVegetablesWithLatinNames.csv", "r")) !== FALSE) {
		while(($dataCSV = fgetcsv($handle, 0, ",", "\"")) !== FALSE) { // set length to zero for unlimited line length php > 5.1

			$plantName = $dataCSV[0];
			$plantLatinName = $dataCSV[9];
			//$plantNameLike = "%$plantName%";
			echo $plantName . "<br/>";
			//  first step - see if this plant already has an entry
			// query on plantLatinName
			$query = "SELECT plantId, plantName, plantLatinName, plantDescription, plantSpread, plantHeight, plantMinTemp, plantSoilMoisture FROM plant WHERE plantLatinName = :plantLatinName";
			$statement = $pdo->prepare($query);
			$parameters = ["plantLatinName" => $plantLatinName];
			$statement->execute($parameters);

			// get data from PDO object
			try {
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$rowFromPlantPDO = $statement->fetch();

				// if the entry is there, update it
				if($rowFromPlantPDO !== false) { // found an entry
					// find the entry, get data from it, insert a NEW entry
					// (will delete old plants for a future entry later.)
					// store plant ID of pfaf entry to delete

					array_push($pfafPlantsUpdated, $rowFromPlantPDO["plantId"]);
					echo "Found pfaf entry: ".$plantName.", ".$rowFromPlantPDO["plantId"]."<br/>";

					//$plantLatinName = $rowFromPlantPDO["plantLatinName"];

					$plantType = "Vegetable";
					if(floatval($rowFromPlantPDO["plantMinTemp"]) < 32.0) {
						$plantMinTemp = $rowFromPlantPDO["plantMinTemp"];
					} else {
						$plantMinTemp = 32.0;
					}

					$plantDescription = $rowFromPlantPDO["plantDescription"];

					if(floatval($rowFromPlantPDO["plantSpread"] !== null)) {
						$plantSpread = $rowFromPlantPDO["plantSpread"];
					} else {
						$size = explode("-", $dataCSV[7]); // get larger size
						$plantSpread = floatval($size[1]) / 12.0; // convert to feet
					}

					$query = "INSERT INTO plant SET plantName = :plantName, plantLatinName = :plantLatinName, plantVariety = :plantVariety, plantType = :plantType, plantDescription = :plantDescription, plantDaysToHarvest = :plantDaysToHarvest, plantMinTemp = :plantMinTemp, plantSpread = :plantSpread  ";
					$statement = $pdo->prepare($query);

					$parameters = ["plantName" => $plantName,
						"plantLatinName" => $plantLatinName,
						"plantVariety" => $dataCSV[1],
						"plantType" => $plantType,
						"plantDescription" => $plantDescription,
						"plantDaysToHarvest" => $dataCSV[2],
						"plantMinTemp" => $plantMinTemp,
						"plantSpread" => $plantSpread];
					$statement->execute($parameters);


				} else {

					// if the entry is not already there, insert it.
					//$plantLatinName = null;
					$plantVariety = $dataCSV[1];
					$plantType = "Vegetable";
					$plantDescription = null;
					// convert from inches to feet, and parse out from string "24 - 36"
					$dashPosition = strpos($dataCSV[7],"—" );
					if($dashPosition === false){ // no dash, single size value in plant spread
						$size = floatval($dataCSV[7]);
					} else {
						$size = explode("—", $dataCSV[7])[1]; // get larger size
					}
					//for($i = 0; $i < count($size); $i++) {
					//	echo($size[$i]);
					//}

					$plantSpread = $size / 12.0; // convert to feet
					$plantHeight = null;
					$plantDaysToHarvest = $dataCSV[2];
					$plantMinTemp = 32.0;
					$plantMaxTemp = null;
					$plantSoilMoisture = null;

					$plant = new Plant(null, $plantName, $plantLatinName, $plantVariety, $plantDescription, $plantType, $plantSpread, $plantHeight, $plantDaysToHarvest, $plantMinTemp, $plantMaxTemp, $plantSoilMoisture);
					$plant->insert($pdo);

				}

			} catch(\Exception $e) {
				throw(new \PDOException($e->getMessage(), 0, $e));
			}

		} // end while
		fclose($handle);
	}// endif


	// loop through all of the plants that we took update data from
	// delete the old entries (since the new ones actually have more information)
	/*for($i=0;$i < count($pfafPlantsUpdated); $i++){
		echo "Deleting Plant Id: ".$pfafPlantsUpdated[$i]."<br/>";
		$query = "DELETE FROM plant WHERE plantId = :plantId";
		$statement = $pdo->prepare($query);
		$parameters = ["plantId" => $pfafPlantsUpdated[$i]];
		$statement->execute($parameters);
	}*/
}// close function

// Add herb data?

insertPlantData($pdo);
