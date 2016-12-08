<?php
namespace Edu\Cnm\Growify\Test;

use Edu\Cnm\Growify\Plant;
use Edu\Cnm\Growify\CombativePlant;

// grab the project test parameters
require_once("GrowifyTest.php");

// grab the class under scrutiny

require_once(dirname(__DIR__)."/classes/autoload.php");
//require_once("CombativePlant.php");

/**
 * Full PHPUnit test for the CombativePlant class.
 *
 * This is a complete PHPUnit test fo the CombativePlant class because
 * all mySQL/PDO enabled methods are tested for valid AND invalid inputs.
 *
 * @see CombativePlant
 * @author Rebecca Dicharry <rdicharry@cnm.edu>
 *
 */
class CombativePlantTest extends GrowifyTest {

	/**
	 * Foreign key relationship to Plant.
	 * @var Plant combativePlant1Name
	 */
	protected $combativePlant1 = null;
	/**
	 * Foreign key relationship to Plant.
	 * @var Plant combativePlant2Name
	 */
	protected $combativePlant2 = null;

	/**
	 * Create objects necessary for test (dependencies).
	 */
	public final function setUp(){
		// run default setUp() method
		parent::setUp();

		// created parameters needed

		// create and insert a Plant to go into the garden
		$this->combativePlant1 = new Plant(null, "truffula tree", "this is a latin name", "green", "Primary food source for Brown Barbaloots", "tree", 5, 100, 5, 32, 99, "d" );
		$this->combativePlant1->insert($this->getPDO());

		// create and insert a second Plant to go into the garden
		// for tests that need two plants
		$this->combativePlant2 = new Plant(null, "Audrey", "this is a latin name too", "custom", "companion", "vine",  1000, 100, 10, 32, 99, "h");
		$this->combativePlant2->insert($this->getPDO());

	}

	/**
	 * insert a combative plant entry and verify that the
	 * mySQL entry data matches.
	 * Note: we should be able to get combative plant entries regardless of whether the plantName is found in the first or second entry.
	 * Note: this should return an array of values (possible more than one entry for a given combative plant.)
	 *
	 *
	 */
	public function testInsertValidCombativePlantEntry(){
		// store number of rows for later
		$numRows = $this->getConnection()->getRowCount("combativePlant");

		// create a new combative plant entry and insert it into mySQL
		$combativePlant = new CombativePlant($this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$combativePlant->insert($this->getPDO());

		// grab data from mySQL and enforce fields match
		// e.g. all returned entries have the expected name
		// as either 1st or 2nd field.
		$results = CombativePlant::getAllCombativePlantsByPlantName($this->getPDO(), $combativePlant->getCombativePlant1Name(), $combativePlant->getCombativePlant2Name(), $combativePlant->getCombativePlant1LatinName(), $combativePlant->getCombativePlant2LatinName());
		// first check array parameters
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("combativePlant"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Growify\\CombativePlant", $results);

		// get result from the array and validate it.
		$pdoCombativePlant = $results[0]; // only one entry in this test
		$this->assertTrue(($pdoCombativePlant->getCombativePlant1Name() === $this->combativePlant1->getPlantName() )|| ($pdoCombativePlant->getCombativePlant2Name() === $this->combativePlant2->getPlantName()));
	}

	/**
	 * Ensure the existsCombativePlantEntry() works as expected - returns true
	 * if the combative plant has been entered.
	 */
	public function testExistsCombativePlantEntry(){
		// create a new combative plant entry and insert it into mySQL
		$combativePlant = new CombativePlant($this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$combativePlant->insert($this->getPDO());

		$this->assertTrue( CombativePlant::existsCombativePlantEntry($this->getPDO(), $this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName()));
	}

	/**
	 * Ensure the existsCombativePlantEntry() works as expected - returns false
	 * if the combative plant has not been entered.
	 */
	public function testExistsCombativePlantEntryNoEntry(){
		// ask if the entry exists for an entry that shouldn't

		$this->assertFalse( CombativePlant::existsCombativePlantEntry($this->getPDO(), $this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName()));
	}

	/**
	 * do we get expected behavior when attempting to create a duplicate entry
	 * in other words, we expect NOT to be able to insert an identical entry
	 *
	 *
	 */
	public function testInsertDuplicateValidCombativePlantEntry(){

		$testCombativePlant1 = new CombativePlant($this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$testCombativePlant1->insert($this->getPDO());
		try {
			$testCombativePlant2 = new CombativePlant($this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
			$testCombativePlant2->insert($this->getPDO());
		} catch (\PDOException $pdoException){
			$this->assertTrue(true); // caught expected exception
		}

		// chech that no rows affected.
		$results = CombativePlant::getCombativePlantsByPlantName($this->getPDO(), $this->combativePlant1->getPlantName());
		$this->assertCount(1, $results);
	}

	/**
	 * attempt to insert a combative plant entry that already exists
	 * (with order of plantNames reversed)
	 *
	 * e.g. (CombativePlant1Name = 1, CombativePlant2Name = 2) and
	 *      (CombativePlant1Name = 2, CombativePlant1Name = 1)
	 * are really the same entry, and we neither require nor do we want to have BOTH
	 * @expectedException \PDOException
	 */
	public function testInsertDuplicateValidCombativePlantEntrySwapNames(){
		$testCombativePlant1 = new CombativePlant($this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(),$this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$testCombativePlant1->insert($this->getPDO());

		$testCombativePlant2 = new CombativePlant($this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantName(),$this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$testCombativePlant2->insert($this->getPDO());
	}

	/**
	 * test deleting a valid plant entry
	 */
	public function testDeleteValidCombativePlantEntry(){
		// count the number of rows and save to compare
		$numRows = $this->getConnection()->getRowCount("combativePlant");

		// create a new CombativePlant and insert into mySQL
		$combativePlant = new CombativePlant($this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$combativePlant->insert($this->getPDO());

		// delete that combativePlant
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("combativePlant"));
		$combativePlant->delete($this->getPDO());

		// get data from mySQL and enforce the entry was deleted.


		$pdoCombativePlants = CombativePlant::getCombativePlantsByPlantName($this->getPDO(), $this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName());
		$this->assertCount(0, $pdoCombativePlants);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("combativePlant"));

	}

	/**
	 * Insert combative plant object into mySQL as combativePlant1Name, combativePlant2Name, check that doing delete on combativePlant2Name, combativePlant1Name removes that object.
	 */
	public function testDeleteValidCombativePlantEntryOrderInsensitive(){
		// count the number of rows and save to compare
		$numRows = $this->getConnection()->getRowCount("combativePlant");

		// create a new CombativePlant and insert into mySQL
		$combativePlant1 = new CombativePlant($this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$combativePlant1->insert($this->getPDO());

		// delete a combativePlant created with reversed indices
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("combativePlant"));
		$combativePlant2 = new CombativePlant($this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$combativePlant2->delete($this->getPDO());

		// get data from mySQL and enforce the entry was deleted.
		$pdoCombativePlant = CombativePlant::getCombativePlantsByPlantName($this->getPDO(), $this->combativePlant1->getPlantName(), $this->combativePlant1->getPlantLatinName());
		//$this->assertEmpty($pdoCombativePlant);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("combativePlant"));
	}

	/**
	 * test deleting a Combative plant entry that does not exist
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidCombativePlantEntry(){
		// create a CombativePlant and try to delete without actually inserting it
		$combativePlant = new CombativePlant($this->combativePlant1->getPlantName(),$this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$combativePlant->delete($this->getPDO());
	}

	/**
	 * Test ability to retrieve the CombativePlant record by the second Plant entry (combativePlant2)
	 */
	public function testGetValidCombativePlantEntryByPlantName(){

		// we shouldn't know what order the plants will be inside the DB
		// so need to test against either one (two plant names)

		// a query for a particular combative plant should return all
		// valid plants that it is paired with - so we might need to use
		// more than one Plant entry to test against. e.g. should be able to retrieve the entries with the plantName as either combativePlant1Name or combativePlant2Name
		// count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("combativePlant");

		// create a new Combative plant and insert it into mySQL
		$combativePlant = new CombativePlant($this->combativePlant1->getPlantName(),$this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$combativePlant->insert($this->getPDO());

		// grab the data and enforce fields match expectations
		$results = CombativePlant::getCombativePlantsByPlantName($this->getPDO(), $this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("combativePlant"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Growify\\CombativePlant", $results);

		// get result from the array and validate it.
		$pdoCombativePlant = $results[0];
		$this->assertEquals($pdoCombativePlant->getCombativePlant1Name(), $this->combativePlant1->getPlantName(), $this->combativePlant1->getPlantLatinName());
		$this->assertEquals($pdoCombativePlant->getCombativePlant2Name(), $this->combativePlant2->getPlantName(), $this->combativePlant2->getPlantLatinName());

	}

	/**
	 * Attempt to get a plant for which no entry exists.
	 */
	public function testGetInvalidCombativePlantEntryByPlantName(){

		// get a combativeplant entry by searching for a plant that does not exist
		$combativePlants = CombativePlant::getCombativePlantsByPlantName($this->getPDO(),  $this->combativePlant2->getPlantName(), $this->companionPlant2->getPlantLatinName());

		$this->assertCount(0, $combativePlants);
	}

	/**
	 * test getting a list of ALL combative plant entries
	 */
	public function testGetAllValidCombativePlants(){
		// count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("combativePlant");

		// create a new Combative plant and insert it into mySQL
		$combativePlant = new CombativePlant($this->combativePlant1->getPlantName(), $this->combativePlant2->getPlantName(), $this->combativePlant1->getPlantLatinName(), $this->combativePlant2->getPlantLatinName());
		$combativePlant->insert($this->getPDO());

		// grab the data and enforce fields match expectations
		$results = CombativePlant::getAllCombativePlants($this->getPDO());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("combativePlant"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Growify\\CombativePlant", $results);

		// get result from the array and validate it.
		$pdoCombativePlant = $results[0];
		$this->assertEquals($pdoCombativePlant->getCombativePlant1Name(), $this->combativePlant1->getPlantName(), $this->combativePlant1->getPlantLatinName());
		$this->assertEquals($pdoCombativePlant->getCombativePlant2Name(), $this->combativePlant2->getPlantName(), $this->combativePlant2->getPlantLatinName());
	}
}