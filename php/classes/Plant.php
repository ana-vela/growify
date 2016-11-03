<?php
/**
 * Plant Information Class
 *
 * This Plant will access and store data. This can be extended to include further attributes that may be needed.
 *
 * @author Greg Bloom <gbloomdev@gmail.com>
 * @version 0.1.0
 **/
class Plant{
	/**
	 * id for this plant; this is the primary key
	 * @var int $plantId
	 **/
	private $plantId;
	/**
	 * name of this plant
	 * @var string $plantName
	 **/
	private $plantName;
	/**
	 * variety of this plant
	 * @var string $plantVariety
	 **/
	private $plantVariety;
	/**
	 * description of this plant
	 * @var string $plantDescription
	 **/
	private $plantDescription;
	/**
	 * type of plant
	 * @var string $plantType
	 **/
	private $plantType;
	/**
	 * planting distance between this plant and others (in feet)
	 * @var float $plantSpread
	 **/
	private $plantSpread;
	/**
	 * amount of days before this plant should be harvested
	 * @var int plantDaysToHarvest
	 **/
	private $plantDaysToHarvest;
	/**
	 * average mature height for this plant
	 * @var float plantHeight
	 **/
	private $plantHeight;
	/**
	 * minimum growing temperature for this plant
	 * @var int plantMinTemp
	 **/
	private $plantMinTemp;
	/**
	 * maximum growing temperature for this plant
	 * @var int plantMaxTemp
	 **/
	private $plantMaxTemp;
	/**
	 * soil moisture needs for this plant
	 * @var string plantSoilMoisture
	 **/
	private $plantSoilMoisture;

	/**
	 * @param int|null $newPlantId
	 * @param string $newPlantName
	 * @param string $newPlantVariety
	 * @param string $newPlantDescription
	 * @param string$newPlantType
	 * @param float $newPlantSpread
	 * @param int $newPlantDaysToHarvest
	 * @param float $newPlantHeight
	 * @param int $newPlantMinTemp
	 * @param int $newPlantMaxTemp
	 * @param string $newPlantSoilMoisture
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type
	 * @throws \Exception for other exceptions
	 **/
	public function _construct($newPlantId, $newPlantName, $newPlantVariety, $newPlantDescription, $newPlantType, $newPlantSpread, $newPlantDaysToHarvest, $newPlantHeight,$newPlantMinTemp,$newPlantMaxTemp, $newPlantSoilMoisture){
		try{
			$this->setPlantId($newPlantId);
			$this->setPlantName($newPlantName);
			$this->setPlantVariety($newPlantVariety);
			$this->setPlantDescription($newPlantDescription);
			$this->setPlantType($newPlantType);
			$this->setPlantSpread($newPlantSpread);
			$this->setPlantDaysToHarvest($newPlantDaysToHarvest);
			$this->setPlantHeight($newPlantHeight);
			$this->setPlantMinTemp($newPlantMinTemp);
			$this->setPlantMaxTemp($newPlantMaxTemp);
			$this->setPlantSoilMoisture($newPlantSoilMoisture);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for plantId
	 * @return int
	 */
	public function getPlantId() {
		return $this->plantId;
	}

	/**
	 * accessor method for plantName
	 * @return string
	 */
	public function getPlantName() {
		return $this->plantName;
	}

	/**
	 * accessor method for plantVariety
	 * @return string
	 */
	public function getPlantVariety() {
		return $this->plantVariety;
	}

	/**
	 * accessor method for plantDescription
	 * @return string
	 */
	public function getPlantDescription() {
		return $this->plantDescription;
	}

	/**
	 * accessor method for plantType
	 * @return string
	 */
	public function getPlantType() {
		return $this->plantType;
	}

	/**
	 * accessor method for plantSpread
	 * @return float
	 */
	public function getPlantSpread() {
		return $this->plantSpread;
	}

	/**
	 * accessor method for plantDaysToHarvest
	 * @return int
	 */
	public function getPlantDaysToHarvest() {
		return $this->plantDaysToHarvest;
	}

	/**
	 * accessor method for plantHeight
	 * @return float
	 */
	public function getPlantHeight() {
		return $this->plantHeight;
	}

	/**
	 * accessor method for plantMinTemp
	 * @return int
	 */
	public function getPlantMinTemp() {
		return $this->plantMinTemp;
	}

	/**
	 * accessor method for plantMaxTemp
	 * @return int
	 */
	public function getPlantMaxTemp() {
		return $this->plantMaxTemp;
	}

	/**
	 * accessor method for plantSoilMoisture
	 * @return string
	 */
	public function getPlantSoilMoisture() {
		return $this->plantSoilMoisture;
	}

	/**
	 * mutator method for plantId
	 * @param int|null $newPlantId new value of plant id
	 * @throws \RangeException if $newPlantId is negative
	 * @throws \TypeError if $newPlantId is not an integer
	 */
	public function setPlantId(int $newPlantId = null) {
		// if the plant id is null, this is a new plant without an id from mySQL
		if($newPlantId === null) {
			$this->plantId = null;
			return;
		}
		// verify that plant id is positive
		if($newPlantId <= 0) {
			throw (new \RangeException("plant id is not positive"));
		}
		$this->plantId = $newPlantId;
	}

	/**
	 * mutator method for plantName
	 * @param string $newPlantName new value of plant name
	 * @throws \UnexpectedValueException if $newPlantName is not a string
	 */
	public function setPlantName(string $newPlantName) {
		$newPlantName = filter_var($newPlantName,FILTER_SANITIZE_STRING);
		if($newPlantName === false){
			throw (new \UnexpectedValueException("name is not a valid string"));
		}
		$this->plantName = $newPlantName;
	}

	/**
	 * mutator method for plantVariety
	 * @param string $newPlantVariety  new value of plant variety
	 * @throws \UnexpectedValueException if $newPlantVariety is not a string
	 */
	public function setPlantVariety($newPlantVariety) {
		$newPlantVariety = filter_var($newPlantVariety,FILTER_SANITIZE_STRING);
		if($newPlantVariety === false){
			throw (new \UnexpectedValueException("variety is not a valid string"));
		}
		$this->plantVariety = $newPlantVariety;
	}

	/**
	 * mutator method for plantDescription
	 * @param string $newPlantDescription new value of plant description
	 * @throws \UnexpectedValueException if $newPlantDescription is not a string
	 */
	public function setPlantDescription($newPlantDescription) {
		$newPlantDescription = filter_var($newPlantDescription,FILTER_SANITIZE_STRING);
		if($newPlantDescription === false){
			throw (new \UnexpectedValueException("description is not a valid string"));
		}
		$this->plantDescription = $newPlantDescription;
	}

	/**
	 * mutator method for plantType
	 * @param string $newPlantType new value of plant type
	 * @throws \UnexpectedValueException if $newPlantType is not a string
	 */
	public function setPlantType($newPlantType) {
		$newPlantType = filter_var($newPlantType,FILTER_SANITIZE_STRING);
		if($newPlantType === false){
			throw (new \UnexpectedValueException("type is not a valid string"));
		}
		$this->plantType = $newPlantType;
	}

	/**
	 * mutator method for plantSpread
	 * @param float $newPlantSpread new value of plant spread
	 * @throws \UnexpectedValueException if $newPlantSpread is not a float
	 */
	public function setPlantSpread($newPlantSpread) {
		$newPlantSpread = filter_var($newPlantSpread,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
		if($newPlantSpread === false){
			throw (new \UnexpectedValueException("spread is not a valid float"));
		}
		$this->plantSpread = $newPlantSpread;
	}

	/**
	 * mutator method for plantDaysToHarvest
	 * @param int $newPlantDaysToHarvest new value of plant days to harvest
	 * @throws \UnexpectedValueException if $newPlantDaysToHarvest is not an int
	 */
	public function setPlantDaysToHarvest($newPlantDaysToHarvest) {
		$newPlantDaysToHarvest = filter_var($newPlantDaysToHarvest,FILTER_VALIDATE_INT);
		if($newPlantDaysToHarvest === false){
			throw (new \UnexpectedValueException("days to harvest is not a valid int"));
		}
		$this->plantDaysToHarvest = $newPlantDaysToHarvest;
	}

	/**
	 * mutator method for plantHeight
	 * @param float $newPlantHeight new value of plant mature height
	 * @throws \UnexpectedValueException if $newPlantHeight is not a float
	 */
	public function setPlantHeight($newPlantHeight) {
		$newPlantHeight = filter_var($newPlantHeight,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
		if($newPlantHeight === false){
			throw (new \UnexpectedValueException("height is not a valid float"));
		}
		$this->plantHeight = $newPlantHeight;
	}

	/**
	 * mutator method for plantMinTemp
	 * @param int $newPlantMinTemp new value of plant min temp
	 * @throws \UnexpectedValueException if $newPlantMinTemp is not a int
	 */
	public function setPlantMinTemp($newPlantMinTemp) {
		$newPlantMinTemp = filter_var($newPlantMinTemp,FILTER_VALIDATE_INT);
		if($newPlantMinTemp === false){
			throw (new \UnexpectedValueException("min temp is not a valid int"));
		}
		$this->plantMinTemp = $newPlantMinTemp;
	}

	/**
	 * mutator method for plantMaxTemp
	 * @param int $newPlantMaxTemp new value of plant max temp
	 * @throws \UnexpectedValueException if $newPlantMaxTemp is not a int
	 */
	public function setPlantMaxTemp($newPlantMaxTemp) {
		$newPlantMaxTemp = filter_var($newPlantMaxTemp,FILTER_VALIDATE_INT);
		if($newPlantMaxTemp === false){
			throw (new \UnexpectedValueException("max temp is not a valid int"));
		}
		$this->plantMaxTemp = $newPlantMaxTemp;
	}

	/**
	 * mutator method for plantSoilMoisture
	 * @param string $newPlantSoilMoisture new value of plant soil moisture
	 * @throws \UnexpectedValueException if $newPlantSoilMoisture is not a string
	 */
	public function setPlantSoilMoisture($newPlantSoilMoisture) {
		$newPlantSoilMoisture = filter_var($newPlantSoilMoisture,FILTER_SANITIZE_STRING);
		if($newPlantSoilMoisture === false){
			throw (new \UnexpectedValueException("soil moisture is not a valid string"));
		}
		$this->plantSoilMoisture = $newPlantSoilMoisture;
	}
}