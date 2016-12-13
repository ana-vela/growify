<?php
namespace Edu\Cnm\Growify;

require_once("autoload.php");

class Garden implements \JsonSerializable {
	use ValidateDate;

	/**
	 * the id of the User who "Owns" this garden
	 * @var int $gardenProfileId
	 */
	private $gardenProfileId;

	/**
	 * the (user entered) date the plant (specified by gardenPlantId) was planted
	 * @var \DateTime $gardenPlantId
	 */
	private $gardenDatePlanted;

	/**
	 * The Id of the Plant for this garden entry.
	 * @var int $gardenPlantId
	 */
	private $gardenPlantId;

	/**
	 * Garden constructor.
	 * @param int $newGardenProfileId required Id of the profile user who "owns" this garden.
	 * @param \DateTime $newGardenDatePlanted User-entered planting date for the plant being added to the garden.
	 * @param int $newGardenPlantId the Plant being added to the user's garden.
	 * @throws \InvalidArgumentException if $newGardenDatePlanted is not a DateTime object.
	 * @throws \RangeException if $newGardenProfileId or $newGardenPlantId are not valid (positive), or if $newGardenDatePlanted is not a valid date.
	 * @throws \TypeError if the data types violate type hints
	 * @throws \Exception if some other exception occurs.
	 */
	public function __construct(int $newGardenProfileId, \DateTime $newGardenDatePlanted, int $newGardenPlantId){

		try{
			$this->setGardenProfileId($newGardenProfileId);
			$this->setGardenDatePlanted($newGardenDatePlanted);
			$this->setGardenPlantId($newGardenPlantId);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError){
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception){
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}

	}

	/**
	 * Accessor method for gardenProfileId.
	 * @return int profileId of user who owns this garden.
	 */
	public function getGardenProfileId(){
		return($this->gardenProfileId);
	}

	/**
	 * Mutator method for gardenProfileId.
	 * @param int $newGardenProfileId
	 * @throws \RangeException if the $newGardenProfileId is not positive.
	 * @throws \TypeError if $newGardenProfileId does not represent an int.
	 */
	public function setGardenProfileId(int $newGardenProfileId){
		// verify the profile id is positive
		if($newGardenProfileId <= 0){
			throw(new \RangeException("Garden profile id must be positive."));
		}

		//convert and store the profile id
		$this->gardenProfileId = $newGardenProfileId;
	}

	/**
	 * Accessor method for gardenDatePlanted.
	 * @return \DateTime user-entered date the garden was planted.
	 */
	public function getGardenDatePlanted(){
		return($this->gardenDatePlanted);
	}

	/**
	 * Mutator method for gardenDatePlanted.
	 * @param \DateTime $newGardenDatePlanted user-entered date that the Plant was planted in this Garden.
	 * @throws \InvalidArgumentException if $newGardenDatePlanted is not a valid object.
	 * @throws \RangeException if the date is not a valid date.
	 */
	public function setGardenDatePlanted(\DateTime $newGardenDatePlanted){
		// store the date
		try{
			$newGardenDatePlanted = self::validateDateTime($newGardenDatePlanted);
		} catch(\InvalidArgumentException $invalidArgument){
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range){
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->gardenDatePlanted = $newGardenDatePlanted;
	}

	/**
	 * Accessor method for gardenPlantId.
	 * @return int the PlantId of the Plant being added to the garden.
	 */
	public function getGardenPlantId(){
		return($this->gardenPlantId);
	}

	/**
	 * Mutator method for gardenPlantId.
	 * @param int $newGardenPlantId the Id of the Plant being added to the Garden.
	 */
	public function setGardenPlantId(int $newGardenPlantId){
		// verify the plantId is positive
		if($newGardenPlantId <= 0){
			throw(new \RangeException("Plant id must be positive."));
		}

		// store
		$this->gardenPlantId = $newGardenPlantId;
	}

	/**
	 * Insert a new Garden entry.
	 * @param \PDO $pdo the PDO connection object.
	 * @throws \PDOException if mySQL related errors occur.
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 */
	public function insert(\PDO $pdo){

		if(Garden::existsGardenEntry($pdo, $this->gardenProfileId, $this->gardenDatePlanted, $this->gardenPlantId)){
			throw(new \PDOException("cannot add new garden entry - this entry already exists"));
		}

		//create query template
		$query = "INSERT INTO garden(gardenProfileId, gardenDatePlanted, gardenPlantId) VALUES (:gardenProfileId, :gardenDatePlanted, :gardenPlantId)";
		$statement = $pdo->prepare($query);

		// bind member variables to placeholders in the template
		// note: do not need to preserve any time information (there should not be any) as we are only interested in the planting date
		$formattedDate = $this->gardenDatePlanted->format("Y-m-d");
		$parameters = ["gardenProfileId"=>$this->gardenProfileId, "gardenDatePlanted"=>$formattedDate, "gardenPlantId"=>$this->gardenPlantId];
		$statement->execute($parameters);

	}

	/**
	 * Delete a Garden entry. This effective deletes one Plant from the collection that is
	 * a user's garden. To delete an entire garden for a user, you must delete ALL garden
	 * entries for that user.
	 * @param \PDO $pdo PDO connection object.
	 * @throws \PDOException if mySQL related errors occur.
	 * @throws \TypeError if $pdo is not a PDO object.
	 */
	public function delete(\PDO $pdo){

		if(Garden::existsGardenEntry($pdo, $this->gardenProfileId, $this->gardenDatePlanted, $this->gardenPlantId ) === false){
			throw(new \PDOException("cannot delete a garden entry that does not exist"));
		}

		// create query template
		$query = "DELETE FROM garden WHERE gardenProfileId = :gardenProfileId AND gardenPlantId = :gardenPlantId";
		$statement = $pdo->prepare($query);

		// bind member variables to placeholder in template
		$parameters = ["gardenProfileId"=>$this->gardenProfileId, "gardenPlantId"=>$this->gardenPlantId];
		$statement->execute($parameters);
	}

	/**
	 * Updates the garden plant entry in mySQL. This method can effectively ONLY UPDATE THE DATE PLANTED. Changing the plantId would require deleting the old entry and creating a new one.
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 */
	public function updateGardenDatePlanted(\PDO $pdo){

		// check if the garden has an entry in mySQL before entering
		$query = "SELECT * FROM garden WHERE gardenProfileId = :gardenProfileId AND gardenPlantId = :gardenPlantId";
		$statement = $pdo->prepare($query);

		$parameters = [ "gardenProfileId"=>$this->gardenProfileId, "gardenPlantId"=>$this->gardenPlantId];
		$statement->execute($parameters);

		// if we get no rows returned, there are no entries to update
		if($statement->rowCount()===0){
			throw(new \PDOException("cannot update a garden entry that does not exist"));
		}

		// otherwise, the entry does exist, so it can be updated.
		//create query template
		$query = "UPDATE garden SET gardenDatePlanted = :gardenDatePlanted WHERE gardenProfileId = :gardenProfileId AND gardenPlantId = :gardenPlantId";
		$statement = $pdo->prepare($query);

		// bind member variables to placeholders
		$formattedDate = $this->gardenDatePlanted->format("Y-m-d");
		$parameters = ["gardenDatePlanted"=>$formattedDate, "gardenProfileId"=>$this->gardenProfileId, "gardenPlantId"=>$this->gardenPlantId];
		$statement->execute($parameters);
	}

	/**
	 * Check whether a garden entry has already been added to mySQL.
	 * @param \PDO $pdo a PDO connection object
	 * @param int $gardenProfileId the profile ID of the user who owns this garden
	 * @param int $gardenPlantId the plant id for the garden entry that we are interested in
	 * @return bool true if the garden entry already exists, false if it doesn't.
	 */
	public static function existsGardenEntry(\PDO $pdo, int $gardenProfileId,\DateTime $gardenDatePlanted, int $gardenPlantId){

		// create query template
		$query = "SELECT * FROM garden WHERE (gardenProfileId = :gardenProfileId) AND (gardenDatePlanted = :gardenDatePlanted) AND (gardenPlantId = :gardenPlantId)";
		$statement = $pdo->prepare($query);

		// bind parameters
		$formattedDate = $gardenDatePlanted->format("Y-m-d");
		$parameters = ["gardenProfileId"=>$gardenProfileId, "gardenDatePlanted"=>$formattedDate, "gardenPlantId"=>$gardenPlantId];

		$statement->execute($parameters);

		if($statement->rowCount() > 0){
			return true;
		}
		return false;
	}

	/**
	 * Get all garden entries associated with the specified profile Id.
	 * @param \PDO $pdo a PDO connection object
	 * @param int $gardenProfileId a valid profile Id
	 * @return \SplFixedArray SplFixedArray of all garden entries associated with the given profile Id, or null if no entries found.
	 * @throws \RangeException when $gardenProfileId is not positive
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when parameters are not the correct data type
	 */
	public static function getGardensByGardenProfileId(\PDO $pdo, int $gardenProfileId){
		// could return many values (an array of garden entries
		// sanatize the profile id before searching
		if($gardenProfileId <=0){
			throw(new \RangeException("Garden profile id must be positive."));
		}

		// create query template
		$query = "SELECT gardenDatePlanted, gardenPlantId FROM garden WHERE gardenProfileId = :gardenProfileId";
		$statement = $pdo->prepare($query);

		// bind the garden profile id to place holder in the template
		$parameters = ["gardenProfileId" => $gardenProfileId];
		$statement->execute($parameters);

		// build an array of gardens
		$gardens = new \SplFixedArray($statement->rowCount() );
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false){
			try{
				$dateTime = new \DateTime($row['gardenDatePlanted']);
				$garden = new Garden($gardenProfileId, $dateTime, $row["gardenPlantId"] );
				$gardens[$gardens->key()] = $garden;
				$gardens->next();
			} catch(\Exception $exception){
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($gardens);
	}

	/**
	 * Get all garden entries associated with the specified profile Id.
	 * @param \PDO $pdo a PDO connection object
	 * @param int $profileId a valid profile Id
	 * @param int $plantId a valid plant id
	 * @return Garden garden found
	 * @throws \RangeException when $gardenProfileId is not positive
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when parameters are not the correct data type
	 */
	public static function getGardenByProfileIdAndPlantId(\PDO $pdo, int $profileId, int $plantId){
		// could return many values (an array of garden entries
		// sanatize the profile id before searching
		if($profileId <=0){
			throw(new \RangeException("Garden profile id must be positive."));
		}
		if($plantId <=0){
			throw(new \RangeException("Garden plant id must be positive."));
		}

		// create query template
		$query = "SELECT gardenProfileId, gardenDatePlanted, gardenPlantId FROM garden WHERE gardenProfileId = :profileId AND gardenPlantId = :plantId";
		$statement = $pdo->prepare($query);

		// bind the garden profile id to place holder in the template
		$parameters = ["profileId" => $profileId, "plantId" => $plantId];
		$statement->execute($parameters);

		// grab the profile from mySQL
		try {
			$garden = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$dateTime = new \DateTime($row['gardenDatePlanted']);
				$garden = new Garden($row["gardenProfileId"], $dateTime, $row["gardenPlantId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($garden);
	}

	/**
	 * Get all Garden objects.
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray of Garden objects found or null if none found.
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type.
	 */
	public static function getAllGardens(\PDO $pdo){
		//create query template
		$query = "SELECT gardenProfileId, gardenDatePlanted, gardenPlantId FROM garden ";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of garden entries
		$gardens = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row=$statement->fetch())!== false){
			try {
				$dateTime = new \DateTime($row['gardenDatePlanted']);
				$garden = new Garden($row["gardenProfileId"], $dateTime , $row["gardenPlantId"]);
				$gardens[$gardens->key()] = $garden;
				$gardens->next();
			} catch(\Exception $exception){
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return $gardens;
	}


public static function deleteByGardenPlantAndProfileId(\PDO $pdo, int $gardenProfileId, int $gardenPlantId){
	$query = "DELETE FROM garden WHERE gardenProfileId= :gardenProfileId AND gardenPlantId =:gardenPlantId";
	$parameters = [ "gardenProfileId"=>$gardenProfileId, "gardenPlantId"=>$gardenPlantId];
	$statement = $pdo->prepare($query);
	$statement->execute($parameters);
}
	/**
	 * formats the state variables for JSON serialization
	 * @return array an array containing the serialized state variables.
	 */
	public function jsonSerialize(){
		$fields = get_object_vars($this);
		$fields["gardenDatePlanted"]=$this->gardenDatePlanted->getTimestamp()*1000;
		return($fields);
	}

}