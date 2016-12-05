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
	 * @var int $combativePlant2Id
	 */
	private $combativePlant2Name;

	/**
	 * CombativePlant constructor.
	 * @param string $newCombativePlant1Name
	 * @param string $newCombativePlant2Name
	 * @throws \InvalidArgumentException if data has invalid contents or is empty
	 * @throws \RangeException if data is too long
	 * @throws \TypeError if parameters violate type hints
	 * @throws \Exception if some other exception occurs
	 *
	 */
	public function __construct(string $newCombativePlant1Name, string $newCombativePlant2Name){
		try{
			$this->setCombativePlant1Name($newCombativePlant1Name);
			$this->setCombativePlant2Name($newCombativePlant2Name);
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
	 * @throws \TypeError if $newCombativePlant is not a string.
	 */
	public function setCombativePlant1Name(string $newCombativePlant) {
		if($newCombativePlant <= 0){
			throw(new \RangeException("combative plant is too large"));
		}
		$this->combativePlant1Name = $newCombativePlant;
	}

	/**
	 * Accessor method for combativePlant2Name
	 * @return string $combativeplant2Id a plant name.
	 */
	public function getCombativePlant2Name(): string {
		return $this->combativePlant2Name;
	}

	/**
	 * Mutator method for combativePlant2Name
	 * @param string $newCombativePlant
	 * @throws \InvalidArgumentException if $newCombativePlant2Name has invalid contents or is empty
	 * @throws \RangeException if $newCombativePlant is too long
	 * @throws \TypeError if $newCombativePlant is not an int.
	 */
	public function setCombativePlant2Name(int $newCombativePlant) {

		if($newCombativePlant <= 0){
			throw (new \RangeException("combative plant name is too long"));
		}

		$this->combativePlant2Id = $newCombativePlant;
	}

	/**
	 * check whethere a mySQL entry for a given pair of plant names already exists in the table.
	 * @param \PDO $pdo a PDO connection object
	 * @param int $combativePlant1Id a valid plant name
	 * @param int $combativePlant2Id a valid plant name
	 * @return bool true if the entry already exists in mySQL, false if it doesn't
	 */
	public static function existsCombativePlantEntry(\PDO $pdo, string $combativePlant1Name, int $combativePlant2Name){
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

		if(CombativePlant::existsCombativePlantEntry($pdo, $this->combativePlant1Name, $this->combativePlant2Name)===false){
			//bind the member variables to the place holders in the template
			$parameters = ["combativePlant1Name"=>$this->combativePlant1Name, "combativePlant2Name"=>$this->combativePlant2Name];

			//create query template
			$insertQuery = "INSERT INTO combativePlant(combativePlant1Name, combativePlant2Name) VALUES (:combativePlant1Name, :combativePlant2Name)";
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
		$parameters = ["combativePlant1Name"=>$this->combativePlant1Name, "combativePlant2Name"=>$this->combativePlant2Name];

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

/*	no update for this object - we do not have a use case for it. public function update(\PDO $pdo){	}*/



	/**
	 * Get all of the Combative Plant entries that have the specified plant name.
	 * @param \PDO $pdo the PDO connection object.
	 * @param string $plantName the name of the plant we are searching for.
	 * @return \SplFixedArray SplFixedArray of Combative Plants, or null if no matches found.
	 * @throws \PDOException for mySQL related errors
	 * @throws \TypeError if variables are not the correct data type.
	 */
	public static function getCombativePlantsByPlantName(\PDO $pdo, string $plantId, $plantName){
		if($plantId <= 0){
			throw(new \RangeException("combative plant name must be positive"));
		}

		// create query template
		$query = "SELECT combativePlant1Name, combativePlant2Name FROM combativePlant WHERE ((combativePlant1Name = :plantName) OR (combativePlant2Name =: plantName))";
		$statement = $pdo->prepare($query);

		// bind parameters
		$parameters = ["plantName"=>$plantName];
		$statement->execute($parameters);

		// build an array of combativePlants
		$combativePlants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row=$statement->fetch()) !== false){
			try{
				$combativePlant = new CombativePlant($row["combativePlant1Name"], $row["combativePlant2Name"]);
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
		$query = "SELECT combativePlant1Name, combativePlant2Name FROM combativePlant";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of combativePlants
		$combativePlants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch())!==false){
			try{
				$combativePlant = new CombativePlant($row["combativePlant1Name"], $row["combativePlant2Name"]);
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