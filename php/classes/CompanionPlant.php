<?php
namespace Edu\Cnm\Growify;

require_once("autoload.php");

/**
 * Creating class for CompanionPlant
 *
 * This is the class for the CompanionPlant for the Growify capstone.
 *
 * @author Ana Vela <avela7@cnm.edu>
 * @version 1.0
 **/

class CompanionPlant implements \JsonSerializable{
	/**
	 *
	 *  Name of  first CompanionPlant - foreign key
	 * @var string $companionPlant1Name
	 **/
	private $companionPlant1Name;

	/**
	 *
	 * Name for second CompanionPlant - foreign key
	 * @var string $companionPlant2Name
	 *
	 **/

	private $companionPlant2Name;

	/**
	 * companion plant 1 with latin name
	 *
	 * @var string $companionPlant1LatinName
	 */
	private $companionPlant1LatinName;

	/**
	 * companion plant 2 with latin name
	 *
	 * @var string $companionPlant2LatinName
	 */
	private $companionPlant2LatinName;


	/**
	 * constructor for this CompanionPlant
	 *
	 * @param string $newCompanionPlant1Name
	 * @param string $newCompanionPlant2Name
	 * @param string $newCompanionPlant1LatinName
	 * @param string $newCompanionPlant2LatinName
	 * @throws \InvalidArgumentException if data has invalid contents or is empty
	 * @throws \RangeException if data is too long
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 * @internal param string $companionPlant1IName first CompanionPlant
	 * @internal param string $companionPlant2Name second CompanionPlant
	 * @internal param string $companionPlant1LatinIName first CompanionPlant LatinName
	 * @internal param string $companionPlant2LatinName second CompanionPlant LatinName
	 *
	 **/
	public function __construct(string $newCompanionPlant1Name, string $newCompanionPlant2Name, string $newCompanionPlant1LatinName, string $newCompanionPlant2LatinName) {
		try {
			$this->setCompanionPlant1Name($newCompanionPlant1Name);
			$this->setCompanionPlant2Name($newCompanionPlant2Name);
			$this->setCompanionPlant1LatinName($newCompanionPlant1LatinName);
			$this->setCompanionPlant2LatinName($newCompanionPlant2LatinName);

		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for companion plant 1 name
	 * @return string value of companion plant 1 name
	 **/
	public function getCompanionPlant1Name(): string {
		return ($this->companionPlant1Name);
	}

	/**
	 * mutator method for this companion plant 1 name
	 *
	 * @param string $newCompanionPlant1Id new value of companion plant 1 name
	 * @throws \InvalidArgumentException if $newCompanionPlant1Name has invalid contents or is empty
	 * @throws \RangeException if $newCompanionPlant1Name is too long
	 **/
	public function setCompanionPlant1Name (string $newCompanionPlant1Name) {
		// verify the companion plant 1 is not too long

		$newCompanionPlant1Name = trim($newCompanionPlant1Name);
		$newCompanionPlant1Name = filter_var($newCompanionPlant1Name, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newCompanionPlant1Name) > 64) {
			throw(new \RangeException("name is too large"));
		}
		// convert and store the companion plant 1 name
		$this->companionPlant1Name =$newCompanionPlant1Name;
	}
	/**
	 * accessor method for companion plant 2 name
	 *
	 * @return string value for companion plant 2 name
	 **/
	public function getCompanionPlant2Name(): string {
		return $this->companionPlant2Name;
	}
	/**
	 * mutator method for this companion plant 2 name
	 *@param string $newCompanionPlant2Name new value of companion plant 2
	 * @throws \InvalidArgumentException if $newCompanionPlant2Name has invalid contents or is empty
	 * @throws \RangeException if $newCompanionPlant2Name is too long
	 **/

	public function setCompanionPlant2Name(string $newCompanionPlant2Name) {
		$newCompanionPlant2Name = trim($newCompanionPlant2Name);
		$newCompanionPlant2Name = filter_var($newCompanionPlant2Name, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newCompanionPlant2Name) > 64) {
			throw(new \RangeException("name is too large"));
		}
		$this->companionPlant2Name = $newCompanionPlant2Name;
	}
	/**
	 * @throws \InvalidArgumentException if $newPlantLatinName has invalid contents or is empty
	 * @throws \RangeException if $newPlantLatinName is too long
	 **/
	public function setPlantLatinName($newPlantLatinName){
		$newPlantLatinName = trim($newPlantLatinName);
		$newPlantLatinName = filter_var($newPlantLatinName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newPlantLatinName)>72) {
			throw(new \RangeException("latin name is too large"));
		}
		$this->plantLatinName = $newPlantLatinName;
	}


	/**
	 * accessor method for plantLatinName
	 * @return string the latin name for this plant
	 **/
	public function getCompanionPlant1LatinName(){
		return $this->companionPlant1LatinName;
	}

	/**
	 * mutator method for companionPlant1LatinName
	 * @param string $newCompanionPlant1LatinName new value of companion plant 1 latin name
	 * @throws \InvalidArgumentException if $newCompanionPlant1LatinName has invalid contents or is empty
	 * @throws \RangeException if $newPlant1LatinName is too long
	 **/
	public function setCompanionPlant1LatinName($newCompanionPlant1LatinName){
		$newCompanionPlant1LatinName = trim($newCompanionPlant1LatinName);
		$newCompanionPlant1LatinName = filter_var($newCompanionPlant1LatinName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newCompanionPlant1LatinName)>72) {
			throw(new \RangeException("latin name is too large"));
		}
		$this->Companionplant1LatinName = $newCompanionPlant1LatinName;
	}

	/**
	 * accessor method for CompanionPlant1LatinName
	 * @return string the latin name for this plant
	 **/
	public function getCompanionPlant2LatinName(){
		return $this->companionPlant2LatinName;
	}

	/**
	 * mutator method for companionPlant2LatinName
	 * @param string $newCompanionPlant2LatinName new value of companion plant 2 latin name
	 * @throws \InvalidArgumentException if $newCompanionPlant2LatinName has invalid contents or is empty
	 * @throws \RangeException if $newCompanionPlant2LatinName is too long
	 **/
	public function setCompanionPlant2LatinName($newCompanionPlant2LatinName){
		$newCompanionPlant2LatinName = trim($newCompanionPlant2LatinName);
		$newCompanionPlant2LatinName = filter_var($newCompanionPlant2LatinName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newCompanionPlant2LatinName)>72) {
			throw(new \RangeException("latin name is too large"));
		}
		$this->CompanionPlant2LatinName = $newCompanionPlant2LatinName;
	}
	//**made changes and committed up to here**//
	/**
	 * check whether a mySQL entry for a given pair of plant ids already exists in the table.
	 * @param \PDO $pdo a PDO connection object
	 * @param int $companionPlant1Id a valid plant id
	 * @param int $companionPlant2Id a valid plant id
	 * @return bool true if the entry already exists in mySQL, false if it doesn't
	 **/
	public static function existsCompanionPlantEntry(\PDO $pdo, int $companionPlant1Id, int $companionPlant2Id) {
		// first check if this will create a duplicate DB entry
		$query = "SELECT companionPlant1Id, companionPlant2Id FROM companionPlant WHERE (companionPlant1Id = :companionPlant1Id AND companionPlant2Id = :companionPlant2Id) OR (companionPlant1Id = :companionPlant2Id AND companionPlant2Id = :companionPlant1Id)";
		$parameters = ["companionPlant1Id"=>$companionPlant1Id, "companionPlant2Id"=>$companionPlant2Id];
		$statement = $pdo->prepare($query);
		$statement->execute($parameters);

		if($statement->rowCount() > 0) {
			return true;
		}
		return false;
	}


	/**
	 * insert a new companion plant relationship ito mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 **/
	public function insert(\PDO $pdo) {

		if(CompanionPlant::existsCompanionPlantEntry($pdo, $this->companionPlant1Id, $this->companionPlant2Id)===false) {
			// bind the member variables to the place holders in the template
			$parameters = ["companionPlant1Id" => $this->companionPlant1Id, "companionPlant2Id" => $this->companionPlant2Id];

			//create query template
			$insertQuery = "INSERT INTO companionPlant(companionPlant1Id, companionPlant2Id) VALUES (:companionPlant1Id, :companionPlant2Id)";
			$insertStatement = $pdo->prepare($insertQuery);

			//bind the member variables to the place holders in the template
			$insertStatement->execute($parameters);
		} else {
			throw(new \PDOException("cannot insert duplicate companion plant entry"));
		}
	}

	/**
	 * delete a companion plant from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL related errors occur
	 * @throws \TypeError i $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// first check if the entry exists in order to delete , throw an error otherwise
		if(CompanionPlant::existsCompanionPlantEntry($pdo, $this->companionPlant1Id, $this->companionPlant2Id) === false){
			throw new \PDOException("cannot delete an entry that does not exist");
		}

		// bind parameters
		$parameters = ["companionPlant1Id" => $this->companionPlant1Id, "companionPlant2Id" => $this->companionPlant2Id];

		// create query template and execute
		$query = "DELETE FROM companionPlant WHERE (companionPlant1Id  = :companionPlant1Id) AND (companionPlant2Id = :companionPlant2Id)";
		$statement = $pdo->prepare($query);
		$statement->execute($parameters);

		// switch order of parameters input int mySQL, and run the new query
		$query = "DELETE FROM companionPlant WHERE (companionPlant1Id = :companionPlant2Id) AND (companionPlant2Id =:companionPlant1Id)";
		$statement = $pdo->prepare($query);
		$statement->execute($parameters);
	}

	/**
	 * Gets all Companion Plant entries that have the specified plant id.
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $plantId of the plant we are searching for.
	 * @return \SplFixedArray SplFixedArray of companion plants found or null if none found
	 * @throws \PDOException when mySQL related errors occur
	 * @throw \TypeError if $pdo is not a PDO conneciton object.
	 **/
	public static function getAllCompanionPlantsByPlantId(\PDO $pdo, int $plantId){
		if($plantId <= 0){
			throw(new \RangeException("companion plant id must be positive"));
		}
		// create query template
		$query = "SELECT companionPlant1Id, companionPlant2Id FROM companionPlant WHERE ((companionPlant1Id = :plantId) OR (companionPlant2Id=:plantId))";
		$statement = $pdo->prepare($query);

		//bind parameters
		$parameters = ["plantId"=>$plantId];
		$statement->execute($parameters);

		// build an array of CompanionPlants
		$companionPlants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row=$statement->fetch()) !==false){
			try{
				$companionPlant = new CompanionPlant ($row["companionPlant1Id"], $row["companionPlant2Id"]);
				$companionPlants[$companionPlants->key()]=$companionPlant;
				$companionPlants->next();
			}catch(\Exception $exception){
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($companionPlants);
	}

	/**
	 * get all companion plants
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of companion plants found or null if none found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $do is not a PDO connection object.
	 **/

	public static function getAllCompanionPlants(\PDO $pdo) {

		// create query template
		$query = "SELECT companionPlant1Id, companionPlant2Id FROM companionPlant";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of companionPlants
		$companionPlants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !=false) {
			try {
				$companionPlant = new CompanionPlant ($row["companionPlant1Id"], $row["companionPlant2Id"]);
				$companionPlants[$companionPlants->key()] = $companionPlant;
				$companionPlants->next();
			} catch(\Exception $exception){
				//if the row couldn't be converted, rethrow it
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($companionPlants);
	}


	/**
	 * format state variables for JSON serialization
	 * @return array an array with serialized state variables
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}



}