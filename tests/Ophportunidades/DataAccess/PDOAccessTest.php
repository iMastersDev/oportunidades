<?php
namespace Ophportunidades\DataAccess;

use Ophportunidades\DataAccess\Entity\Position;
use Ophportunidades\DataAccess\DataAccess;

class PDOAccessTest extends \PHPUnit_Framework_TestCase
{

    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'Ophportunidades\DataAccess\Entity\Position'),
            'Class not found: '.$class
        );
        $this->assertTrue(
            interface_exists($class = 'Ophportunidades\DataAccess\DataAccess'),
            'Class not found: '.$class
        );
        $this->assertTrue(
            class_exists($class = 'Ophportunidades\DataAccess\PDODataAccess'),
            'Class not found: '.$class
        );
    }

    /**
     * @cover Ophportunidades\DataAccess\PDODataAccess::__construct
     * @cover Ophportunidades\DataAccess\DataAccess
     */
    public function testInstantiation()
    {
        $pdo = $this->getMockBuilder('PDO')
                    ->setConstructorArgs(array('sqlite::memory:'))
                    ->getMock();
        $instance = new PDODataAccess($pdo);
        $this->assertInstanceOf(
            'Ophportunidades\DataAccess\PDODataAccess',
            $instance
        );
        $this->assertAttributeInstanceOf(
            'PDO',
            'pdo',
            $instance
        );
    }

    /**
     * @depends testInstantiation
     * @cover   Ophportunidades\DataAccess\DataAccess
     * @cover   Ophportunidades\DataAccess\PDODataAccess::insert
     * @expectedException        RuntimeException
     * @expectedExceptionMessage Fail to insert some data
     */
    public function testInsertPositionShouldThrowExceptionWhenExecuteFails()
    {
        $pdo = $this->getMockBuilder('PDO')
                    ->setConstructorArgs(array('sqlite::memory:'))
                    ->setMethods(array('prepare'))
                    ->getMock();
        $stmt = $this->getMockBuilder('PdoStatement')
                     ->setMethods(array('bindValue', 'execute'))
                     ->getMock();
        $pdo->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo(PDODataAccess::SQL_INSERT))
            ->will($this->returnValue($stmt));
        $stmt->expects($this->exactly(3))
             ->method('bindValue');
        $stmt->expects($this->once())
             ->method('execute')
             ->will($this->returnValue(false));

        $newPosition = new Position();
        $dataAccess  = new PDODataAccess($pdo);
        $resultId    = $dataAccess->insert($newPosition);
    }

    /**
     * @depends testInsertPositionShouldThrowExceptionWhenExecuteFails
     * @cover   Ophportunidades\DataAccess\DataAccess
     * @cover   Ophportunidades\DataAccess\PDODataAccess::insert
     */
    public function testInsert()
    {
        $pdo = $this->getMockBuilder('PDO')
                    ->setConstructorArgs(array('sqlite::memory:'))
                    ->setMethods(array('prepare', 'lastInsertId'))
                    ->getMock();
        $stmt = $this->getMockBuilder('PdoStatement')
                     ->setMethods(array('bindValue', 'execute'))
                     ->getMock();
        $pdo->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo(PDODataAccess::SQL_INSERT))
            ->will($this->returnValue($stmt));
        $stmt->expects($this->exactly(3))
             ->method('bindValue');
        $stmt->expects($this->once())
             ->method('execute')
             ->will($this->returnValue(true));
        $pdo->expects($this->once())
            ->method('lastInsertId')
            ->will($this->returnValue($expected = 1));

        $newPosition = new Position();
        $newPosition->setTitle('The job');
        $newPosition->setDescription('job description');
        $newPosition->setPlace('Rua dos bobos, 0');
        $dataAccess = new PDODataAccess($pdo);
        $resultId   = $dataAccess->insert($newPosition);
        $this->assertEquals($expected, $resultId);
    }

    public function invalidIds()
    {
        return array(
            array(null),
            array(0),
            array(-1),
            array('not-an-id'),
            array('Fuck. Fuck, fuck fuck, fuck.')
        );
    }

    /**
     * @depends         testInstantiation
     * @cover           Ophportunidades\DataAccess\DataAccess
     * @cover           Ophportunidades\DataAccess\PDODataAccess::getById
     * @dataProvider    invalidIds
     * @expectedException           InvalidArgumentException
     * @expectedExceptionMessage    is an invalid id
     */
    public function testGetByIdShouldThrowExceptionWithAnInvalid($invalidId)
    {
        $pdo = $this->getMockBuilder('PDO')
                    ->setConstructorArgs(array('sqlite::memory:'))
                    ->setMethods(array())
                    ->getMock();
        $dataAccess = new PDODataAccess($pdo);
        $dataAccess->getById($invalidId);
    }

    /**
     * @depends testGetByIdShouldThrowExceptionWithAnInvalid
     * @cover   Ophportunidades\DataAccess\DataAccess
     * @cover   Ophportunidades\DataAccess\PDODataAccess::getById
     * @expectedException   RuntimeException
     * @expectedExceptionMessage Fail to retrieve the position
     */
    public function testGetByIdShouldThrowExceptionForNotFoundPosition()
    {
        $pdo = $this->getMockBuilder('PDO')
                    ->setConstructorArgs(array('sqlite::memory:'))
                    ->setMethods(array('prepare'))
                    ->getMock();
        $stmMockedMethods = array('bindValue', 'setFetchMode', 'execute');
        $stm = $this->getMockBuilder('PdoStatement')
                    ->setMethods($stmMockedMethods)
                    ->getMock();
        $pdo->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo(PDODataAccess::SQL_BY_ID))
            ->will($this->returnValue($stm));
        $stm->expects($this->once())
            ->method('setFetchMode')
            ->with(\PDO::FETCH_CLASS, $this->equalTo('Ophportunidades\DataAccess\Entity\Position'))
            ->will($this->returnValue(true));
        $stm->expects($this->once())
            ->method('bindValue')
            ->will($this->returnValue(true));
        $stm->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(false));
        $dataAccess = new PDODataAccess($pdo);
        $dataAccess->getById($whatever = 42);
    }

    /**
     * @depends testGetByIdShouldThrowExceptionForNotFoundPosition
     * @cover   Ophportunidades\DataAccess\DataAccess
     * @cover   Ophportunidades\DataAccess\PDODataAccess::getById
     */
    public function testGetById()
    {
        $position = new Entity\Position;
        $pdo = $this->getMockBuilder('PDO')
                    ->setConstructorArgs(array('sqlite::memory:'))
                    ->setMethods(array('prepare'))
                    ->getMock();
        $stmMockedMethods = array('bindValue', 'setFetchMode', 'execute', 'fetch', 'closeCursor');
        $stm = $this->getMockBuilder('PdoStatement')
                    ->setMethods($stmMockedMethods)
                    ->getMock();
        $pdo->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo(PDODataAccess::SQL_BY_ID))
            ->will($this->returnValue($stm));
        $stm->expects($this->once())
            ->method('setFetchMode')
            ->with(\PDO::FETCH_CLASS, $this->equalTo('Ophportunidades\DataAccess\Entity\Position'))
            ->will($this->returnValue(true));
        $stm->expects($this->once())
            ->method('bindValue')
            ->will($this->returnValue(true));
        $stm->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(true));
        $stm->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($position));
        $stm->expects($this->once())
            ->method('closeCursor')
            ->will($this->returnValue(true));
        $dataAccess = new PDODataAccess($pdo);
        $result     = $dataAccess->getById($whatever = 42);
        $this->assertSame(
            $position,
            $result
        );
    }

    /**
     * @depends testInstantiation
     * @cover   Ophportunidades\DataAccess\DataAccess
     * @cover   Ophportunidades\DataAccess\PDODataAccess::getAll
     * @expectedException   RuntimeException
     * @expectedExceptionMessage Fail to retrieve the positions
     */
    public function testGetAllShouldThrowExceptionWhenNothingIsFound()
    {
        $pdo = $this->getMockBuilder('PDO')
                    ->setConstructorArgs(array('sqlite::memory:'))
                    ->setMethods(array('prepare'))
                    ->getMock();
        $stmMockedMethods = array('setFetchMode', 'execute');
        $stm = $this->getMockBuilder('PdoStatement')
                    ->setMethods($stmMockedMethods)
                    ->getMock();
        $pdo->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo(PDODataAccess::SQL_SELECT_ALL))
            ->will($this->returnValue($stm));
        $stm->expects($this->once())
            ->method('setFetchMode')
            ->with(\PDO::FETCH_CLASS, $this->equalTo('Ophportunidades\DataAccess\Entity\Position'))
            ->will($this->returnValue(true));
        $stm->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(false));
        $dataAccess = new PDODataAccess($pdo);
        $dataAccess->getAll();
    }

    /**
     * @depends testGetAllShouldThrowExceptionWhenNothingIsFound
     * @cover   Ophportunidades\DataAccess\DataAccess
     * @cover   Ophportunidades\DataAccess\PDODataAccess::getAll
     */
    public function testGetAll()
    {
        $pdo = $this->getMockBuilder('PDO')
                    ->setConstructorArgs(array('sqlite::memory:'))
                    ->setMethods(array('prepare'))
                    ->getMock();
        $stmMockedMethods = array('setFetchMode', 'execute', 'fetchAll');
        $stm = $this->getMockBuilder('PdoStatement')
                    ->setMethods($stmMockedMethods)
                    ->getMock();
        $pdo->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo(PDODataAccess::SQL_SELECT_ALL))
            ->will($this->returnValue($stm));
        $stm->expects($this->once())
            ->method('setFetchMode')
            ->with(\PDO::FETCH_CLASS, $this->equalTo('Ophportunidades\DataAccess\Entity\Position'))
            ->will($this->returnValue(true));
        $stm->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(true));
        $stm->expects($this->once())
            ->method('fetchAll')
            ->will($this->returnValue($expected = array()));
        $dataAccess = new PDODataAccess($pdo);
        $this->assertEquals(
            $expected,
            $dataAccess->getAll(),
            'Expected something different from getAll().'
        );
    }
}