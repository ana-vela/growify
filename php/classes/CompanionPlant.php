<?php
namespace Edu\Cnm\Growify;

require_once("autoload.php");

/**
 * Creating class for CompanionPlant
 *
 * This class represents a pair of plants that grow well together.
 *
 * @author Ana Vela <avela7@cnm.edu>
 * @version 1.0
 **/

class CompanionPlant implements \JsonSerializable{
	/**
	 * Name of first CompanionPlant - foreign key
	 * @var string $companionPlant1Name
	 **/
	private $companionPlant1Name;

	/**
	 * Name for second CompanionPlant - foreign key
	 * @var string $companionPlant2Name
	 *
	 **/
	private $companionPlant2Name;

	/**
	 * companion plant 1 with latin name
	 * @var string $companionPlant1LatinName
	 */
	private $companionPlant1LatinName;

	/**
	 * companion plant 2 with latin name
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
	 * @internal param string $companionPlant1LatinName first CompanionPlant LatinName
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
	 * @param string $newCompanionPlant1Name new value of companion plant 1 name
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
	 * accessor method for companionPlant1LatinName
	 * @return string the latin name for this plant
	 **/
	public function getCompanionPlant1LatinName(): string {
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
		$this->companionPlant1LatinName = $newCompanionPlant1LatinName;
	}

	/**
	 * accessor method for CompanionPlant2LatinName
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
		$this->companionPlant2LatinName = $newCompanionPlant2LatinName;
	}
	//**made changes and committed up to here**//
	/**
	 * check whether a mySQL entry for a given pair of plant names already exists in the table.
	 *
	 * @param \PDO $pdo a PDO connection object
	 * @param string $companionPlant1Name a valid plant name
	 * @param string $companionPlant2Name a valid plant name
	 * @return bool true if the entry already exists in mySQL, false if it doesn't
	 **/
	public static function existsCompanionPlantEntry(\PDO $pdo, string $companionPlant1Name, string $companionPlant2Name) {
		// first check if this will create a duplicate DB entry
		$query = "SELECT companionPlant1Name, companionPlant2Name FROM companionPlant WHERE (companionPlant1Name = :companionPlant1Name) AND (companionPlant2Name = :companionPlant2Name) OR (companionPlant1Name = :companionPlant2Name) AND (companionPlant2Name = :companionPlant1Name)";
		$parameters = ["companionPlant1Name"=>$companionPlant1Name, "companionPlant2Name"=>$companionPlant2Name];
		$statement = $pdo->prepare($query);
		$statement->execute($parameters);

		if($statement->rowCount() > 0) {
			return true;
		}
		return false;
	}

	/**
	 * insert a new companion plant relationship ito mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 **/
	public function insert(\PDO $pdo) {

		if(CompanionPlant::existsCompanionPlantEntry($pdo, $this->companionPlant1Name, $this->companionPlant2Name) ===false) {
			// bind the member variables to the place holders in the template
			$parameters = ["companionPlant1Name" => $this->companionPlant1Name, "companionPlant2Name" => $this->companionPlant2Name, "companionPlant1LatinName" => $this->companionPlant1LatinName, "companionPlant2LatinName" => $this->companionPlant2LatinName];

			//create query template
			$insertQuery = "INSERT INTO companionPlant(companionPlant1Name, companionPlant2Name, companionPlant1LatinName, companionPlant2LatinName) VALUES (:companionPlant1Name, :companionPlant2Name, :companionPlant1LatinName, :companionPlant2LatinName)";
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
	 * @throws \TypeError  $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		// first check if the entry exists in order to delete , throw an error otherwise
		if(CompanionPlant::existsCompanionPlantEntry($pdo, $this->companionPlant1Name, $this->companionPlant2Name) === false){
			throw new \PDOException("cannot delete an entry that does not exist");
		}

		// bind parameters
		$parameters = ["companionPlant1Name" => $this->companionPlant1Name, "companionPlant2Name" => $this->companionPlant2Name];

		// create query template and execute
		$query = "DELETE FROM companionPlant WHERE (companionPlant1Name  = :companionPlant1Name) AND (companionPlant2Name = :companionPlant2Name)";
		$statement = $pdo->prepare($query);
		$statement->execute($parameters);

		// switch order of parameters input int mySQL, and run the new query
		$query = "DELETE FROM companionPlant WHERE (companionPlant1Name = :companionPlant2Name) AND (companionPlant2Name =:companionPlant1Name)";
		$statement = $pdo->prepare($query);
		$statement->execute($parameters);
	}

	/**
	 * Gets all Companion Plant entries that have the specified plant name.
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $plantName of the plant we are searching for.
	 * @return \SplFixedArray SplFixedArray of companion plants found or null if none found
	 * @throws \PDOException when mySQL related errors occur
	 * @throw \TypeError if $pdo is not a PDO connection object.
	 **/
	public static function getAllCompanionPlantsByPlantName(\PDO $pdo, string $plantName){
		$plantName = trim($plantName);
		$plantName = filter_var($plantName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($plantName)>72) {
			throw(new \RangeException("name is too large"));
		}
		// create query template
		$query = "SELECT companionPlant1Name, companionPlant2Name, companionPlant1LatinName, companionPlant2LatinName FROM companionPlant WHERE ((companionPlant1Name = :plantName) OR (companionPlant2Name=:plantName) OR (companionPlant1LatinName = :plantName) OR (companionPlant2LatinName = :plantName))";
		$statement = $pdo->prepare($query);

		//bind parameters
		$parameters = ["plantName"=>$plantName];
		$statement->execute($parameters);

		// build an array of CompanionPlants
		$companionPlants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row = $statement->fetch()) !==false){
			try{
				$companionPlant = new CompanionPlant ($row["companionPlant1Name"], $row["companionPlant2Name"], $row["companionPlant1LatinName"], $row["companionPlant2LatinName"]);
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
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of companion plants found or null if none found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $do is not a PDO connection object.
	 **/

	public static function getAllCompanionPlants(\PDO $pdo) {

		// create query template
		$query = "SELECT companionPlant1Name, companionPlant2Name, companionPlant1LatinName, companionPlant2LatinName FROM companionPlant";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of companionPlants
		$companionPlants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !=false) {
			try {
				$companionPlant = new CompanionPlant ($row["companionPlant1Name"], $row["companionPlant2Name"], $row["companionPlant1LatinName"], $row["companionPlant2LatinName"]);
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