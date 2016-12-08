<?php
namespace Edu\Cnm\Growify;

require_once("autoload.php");

/**
 * Class CombativePlant represents a pair of plants that DO NOT grow well together.
 * @author Rebecca Dicharry <rdicharry@cnm.edu>
 *
 */
class CombativePlant implements \JsonSerializable{

	/**
	 * name of one combative plant - this is a foreign key
	 * @var string $combativePlant1Name;
	 */
	private $combativePlant1Name;

	/**
	 * name of another combative plant - this is a foreign key
	 * @var string $combativePlant2Name
	 */
	private $combativePlant2Name;

	/**
	 * combative plant 1 with latin name
	 * @var string $combativePlant1LatinName
	 */
	private $combativePlant1LatinName;

	/**
	 * combative plant 2 with latin name
	 * @var string $combativePlant2LatinName
	 */
	private $combativePlant2LatinName;

	/**
	 * CombativePlant constructor.
	 * @param string $newCombativePlant1Name
	 * @param string $newCombativePlant2Name
	 * @param string $newCombativePlant1LatinName
	 * @param string $newCombativePlant2LatinName
	 * @throws \InvalidArgumentException if data has invalid contents or is empty
	 * @throws \RangeException if data is too long
	 * @throws \TypeError if parameters violate type hints
	 * @throws \Exception if some other exception occurs
	 * @internal param string $combativePlant1Name first CombativePlant
	 * @internal param string $combativePlant2Name second CombativePlant
	 * @internal param string $combativePlant1LatinName first CombativePlant LatinName
	 * @internal param string $combativePlant2LatinName second CombativePlant LatinName
	 *
	 */
	public function __construct(string $newCombativePlant1Name, string $newCombativePlant2Name, string $newCombativePlant1LatinName, string $newCombativePlant2LatinName){
		try{
			$this->setCombativePlant1Name($newCombativePlant1Name);
			$this->setCombativePlant2Name($newCombativePlant2Name);
			$this->setCombativePlant1LatinName($newCombativePlant1LatinName);
			$this->setCombativePlant2LatinName($newCombativePlant2LatinName);
		} //rethrow to caller
		 catch(\RangeException $range){
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError){
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception){
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * Accessor method for combativePlant1Name
	 * @return string $combativePlant1Name a plant name
	 */
	public function getCombativePlant1Name(): string {
		return $this->combativePlant1Name;
	}

	/**
	 * Mutator method for combativePlant1Name.
	 * @param string $newCombativePlant1Name
	 * @throws \InvalidArgumentException if $newCombativePlant1Name has invalid contents or is empty
	 * @throws \RangeException if $newCombativePlant is too long.
	 */
	public function setCombativePlant1Name(string $newCombativePlant1Name) {

		$newCombativePlant1Name = trim($newCombativePlant1Name);
		$newCombativePlant1Name = filter_var($newCombativePlant1Name, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newCombativePlant1Name) > 64) {
			throw(new \RangeException("name is too large"));
		}
		// convert and store the companion plant 1 name
		$this->combativePlant1Name =$newCombativePlant1Name;
	}

	/**
	 * Accessor method for combativePlant2Name
	 * @return string $combativePlant2Name a plant name.
	 */
	public function getCombativePlant2Name(): string {
		return $this->combativePlant2Name;
	}

	/**
	 * Mutator method for combativePlant2Name
	 * @param string $newCombativePlant2Name new value of combative plant 2
	 * @throws \InvalidArgumentException if $newCombativePlant2Name has invalid contents or is empty
	 * @throws \RangeException if $newCombativePlant is too long
	 */
	public function setCombativePlant2Name(string $newCombativePlant2Name) {
		$newCombativePlant2Name = trim($newCombativePlant2Name);
		$newCombativePlant2Name = filter_var($newCombativePlant2Name, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newCombativePlant2Name) > 64) {
			throw(new \RangeException("name is too large"));
		}
		// convert and store the combative plant 1 name
		$this->combativePlant2Name =$newCombativePlant2Name;
	}

	/**
	 * Accessor method for combativePlant1LatinName
	 * @return string $combativePlant1LatinName a plant name
	 */
	public function getCombativePlant1LatinName(): string {
		return $this->combativePlant1LatinName;
	}

	/**
	 * Mutator method for combativePlant1LatinName.
	 * @param string $newCombativePlant1LatinName
	 * @throws \InvalidArgumentException if $newCombativePlant1LatinName has invalid contents or is empty
	 * @throws \RangeException if $newCombativePlant is too long
	 */
	public function setCombativePlant1LatinName(string $newCombativePlant1LatinName) {

		$newCombativePlant1LatinName = trim($newCombativePlant1LatinName);
		$newCombativePlant1LatinName = filter_var($newCombativePlant1LatinName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newCombativePlant1LatinName) > 64) {
			throw(new \RangeException("latin name is too large"));
		}
		// convert and store the companion plant 1 name
		$this->combativePlant1Name =$newCombativePlant1LatinName;
	}

	/**
	 * Accessor method for combativePlant2LatinName
	 * @return string $combativePlant2LatinName a plant name.
	 */
	public function getCombativePlant2LatinName(): string {
		return $this->combativePlant2LatinName;
	}

	/**
	 * Mutator method for combativePlant2LatinName
	 * @param string $newCombativePlant2LatinName new value of combative plant 2
	 * @throws \InvalidArgumentException if $newCombativePlant2LatinName has invalid contents or is empty
	 * @throws \RangeException if $newCombativePlant is too long
	 */
	public function setCombativePlant2LatinName($newCombativePlant2LatinName) {

		$newCombativePlant2LatinName = trim($newCombativePlant2LatinName);
		$newCombativePlant2LatinName = filter_var($newCombativePlant2LatinName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newCombativePlant2LatinName) > 72) {
			throw(new \RangeException("latin name is too large"));
		}
		// convert and store the companion plant 1 name
		$this->combativePlant2LatinName =$newCombativePlant2LatinName;
	}

	/**
	 * check whether a mySQL entry for a given pair of plant names already exists in the table.
	 * @param \PDO $pdo a PDO connection object
	 * @param string $combativePlant1Name a valid plant name
	 * @param string $combativePlant2Name a valid plant name
	 * @return bool true if the entry already exists in mySQL, false if it doesn't
	 */
	public static function existsCombativePlantEntry(\PDO $pdo, string $combativePlant1Name,string $combativePlant2Name){
		// first check if this will create a duplicate DB entry
		$query = "SELECT combativePlant1Name, combativePlant2Name FROM combativePlant WHERE 
(combativePlant1Name = :combativePlant1Name) AND (combativePlant2Name = :combativePlant2Name) OR 
(combativePlant1Name = :combativePlant2Name) AND (combativePlant2Name = :combativePlant1Name)";
		$parameters = ["combativePlant1Name"=>$combativePlant1Name, "combativePlant2Name"=>$combativePlant2Name];
		$statement = $pdo->prepare($query);
		$statement->execute($parameters);

		if($statement->rowCount() > 0){
			return true;
		}
		return false;
	}

	/**
	 * insert a new combative plant relationship into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 */
	public function insert(\PDO $pdo){

		if(CombativePlant::existsCombativePlantEntry($pdo, $this->combativePlant1Name, $this->combativePlant2Name,$this->combativePlant1LatinName, $this->combativePlant2LatinName )===false){
			//bind the member variables to the place holders in the template
			$parameters = ["combativePlant1Name" => $this->combativePlant1Name, "combativePlant2Name" => $this->combativePlant2Name, "combativePlant1LatinName" => $this->combativePlant1LatinName, "combativePlant2LatinName" => $this->combativePlant2LatinName];

			//create query template
			$insertQuery = "INSERT INTO combativePlant(combativePlant1Name, combativePlant2Name,combativePlant1LatinName, combativePlant2LatinName) VALUES (:combativePlant1Name, :combativePlant2Name, :combativePlant1LatinName, :combativePlant2LatinName)";
			$insertStatement = $pdo->prepare($insertQuery);

			// bind the member variables to the place holders in the template
			$insertStatement->execute($parameters);
		} else {
			throw(new \PDOException("cannot insert duplicate combative plant entry"));
		}
	}

	/**
	 * delete mySQL entry corresponding to this combative plant entry
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException if mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 */
	public function delete(\PDO $pdo){
		/// first check if the entry exists, if not, throw an exception
		if(CombativePlant::existsCombativePlantEntry($pdo, $this->combativePlant1Name, $this->combativePlant2Name) === false){
			throw new \PDOException("cannot delete an entry that does not exist");
		}

		// bind parameters
		$parameters = ["combativePlant1Name" => $this->combativePlant1Name, "combativePlant2Name" => $this->combativePlant2Name];

		// create query template
		$query = "DELETE FROM combativePlant WHERE (combativePlant1Name  = :combativePlant1Name) AND (combativePlant2Name = :combativePlant2Name)";
		$statement = $pdo->prepare($query);

		// execute statement
		$statement->execute($parameters);

		// switch order of parameters input into mySQL, and run new query
		$query = "DELETE FROM combativePlant WHERE (combativePlant1Name = :combativePlant2Name) AND ( combativePlant2Name = :combativePlant1Name)";
		$statement = $pdo->prepare($query);

		// execute statement
		$statement->execute($parameters);
	}

	/**
	 * Get all of the Combative Plant entries that have the specified plant name.
	 * @param \PDO $pdo the PDO connection object.
	 * @param string $plantName the name of the plant we are searching for.
	 * @return \SplFixedArray SplFixedArray of Combative Plants, or null if no matches found.
	 * @throws \PDOException for mySQL related errors
	 * @throws \TypeError if $pdo is not a PDO connection
	 */
	public static function getAllCombativePlantsByPlantName(\PDO $pdo, string $plantName){
		$plantName = trim($plantName);
		$plantName = filter_var($plantName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($plantName)>72) {
			throw(new \RangeException("name is too large"));
		}

		// create query template
		$query = "SELECT combativePlant1Name, combativePlant2Name, combativePlant1LatinName, combativePlant2LatinName FROM combativePlant WHERE ((combativePlant1Name = :plantName) OR (combativePlant2Name =: plantName) OR (combativePlant1LatinName = :plantName) OR (combativePlant2LatinName =:plantName))";
		$statement = $pdo->prepare($query);

		// bind parameters
		$parameters = ["plantName"=>$plantName];
		$statement->execute($parameters);

		// build an array of combativePlants
		$combativePlants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row=$statement->fetch()) !== false){
			try{
				$combativePlant = new CombativePlant($row["combativePlant1Name"], $row["combativePlant2Name"], $row["combativePlant1LatinName"], $row["combativePlant2LatinName"] );
				$combativePlants[$combativePlants->key()]=$combativePlant;
				$combativePlants->next();
			}catch(\Exception $exception){
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($combativePlants);
	}

	/**
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of combative plants found or null if none found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 */
	public static function getAllCombativePlants(\PDO $pdo){

		// create query template
		$query = "SELECT combativePlant1Name, combativePlant2Name, combativePlant1LatinName, combativePlant2LatinName FROM combativePlant";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of combativePlants
		$combativePlants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch())!==false){
			try{
				$combativePlant = new CombativePlant($row["combativePlant1Name"], $row["combativePlant2Name"],$row["combativePlant1LatinName"], $row["combativePlant2LatinName"]);
				$combativePlants[$combativePlants->key()] = $combativePlant;
				$combativePlants->next();
			} catch(\Exception $exception){
				// rethrow if the row couldn't be converted'
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($combativePlants);
	}

	/**
	 * format state variables for JSON serialization
	 * @return array an array with serialized state variables
	 */
	public function jsonSerialize(){
		$fields = get_object_vars($this);
		return($fields);
	}
}