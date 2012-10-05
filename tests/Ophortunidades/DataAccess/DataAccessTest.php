<?php
namespace Ophortunidades\DataAccess;

use \PDO;
use Ophportunidades\Entity\Position;
use Ophportunidades\DataAccess\DataAccess;

class DataAccessTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \PDO
	 */
	public $pdo;
	
	public function assertPreConditions()
	{
		$this->assertTrue(
				class_exists($class = 'Ophportunidades\DataAccess\DataAccess'),
				'Class not found: '.$class
		);
	}
	
	protected function setUp()
	{
		$this->pdo = new PDO('sqlite:memory:');
		$this->pdo->exec('
			CREATE TABLE IF NOT EXISTS position (
				id INTEGER PRIMARY KEY,
				title TEXT,
				description TEXT,
				place TEXT
			);
		');
	}
	
	protected function tearDown()
	{
		$this->pdo->exec('DROP TABLE position');
	}
	
	public function testInsertPosition()
	{
		$position2Insert = new Position();
		$position2Insert->setTitle('The job');
		$position2Insert->setDescription('job description');
		$position2Insert->setPlace('Rua dos bobos, 0');
		
		$dataAccess = new DataAccess($this->pdo);
		$id = $dataAccess->insert($position2Insert);
		
		$this->assertEquals(1, $id);
		
		$insertedPosition = $dataAccess->getById($id);
		
		$this->assertInstanceOf('Ophportunidades\Entity\Position', $insertedPosition);
		$this->assertEquals($position2Insert->getTitle(), $insertedPosition->getTitle());
		$this->assertEquals($position2Insert->getDescription(), $insertedPosition->getDescription());
		$this->assertEquals($position2Insert->getPlace(), $insertedPosition->getPlace());
	}
}