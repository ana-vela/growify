<?php
namespace Edu\Cnm\Growify;
use Edu\Cnm\Growify\Test\GrowifyTest;

require_once(dirname(__DIR__).'/test/GrowifyTest.php');
require_once(dirname(__DIR__).'/classes/Location.php');
// get the class under scrutiny
require_once(dirname(__DIR__)."/classes/autoload.php");

class LocationTest extends GrowifyTest {
	protected $VALID_ZIPCODE = '87002';

	protected $VALID_LATITUDE = 34.606524;

	protected $VALID_LONGITUDE = -106.659036;

	protected $INVALID_ZIPCODE = '3232323';

	public final function setUp() {
		parent::setUp();
	}

	/**
	 * Test inserting a valid location zipcode and corresponding latitude/longitude. This also tests getLocationByZipCode() and the accessors and mutators.
	 */
	public function testInsertValidLocation(){
		$numRows = $this->getConnection()->getRowCount("location");
		$location = new Location($this->VALID_ZIPCODE, $this->VALID_LATITUDE, $this->VALID_LONGITUDE);

		$location->insert($this->getPDO());
		$pdoLocation = Location::getLocationByZipCode($this->getPDO(), $location->getLocationZipCode());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("location"));
		$this->assertEquals($pdoLocation->getLocationZipCode(), $this->VALID_ZIPCODE);
		/* can't test equality for floats:
				  latitude and longitude */

	}

	/**
	 * Test inserting an invalid location entry and watch it fail!
	 * @expectedException \OutOfBoundsException
	 */
	public function testInsertInvalidLocation(){
		$location = new Location($this->INVALID_ZIPCODE, $this->VALID_LATITUDE, $this->VALID_LONGITUDE);
		$location->insert($this->getPDO());
	}



}

