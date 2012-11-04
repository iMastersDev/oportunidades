<?php
namespace Ophportunidades\Route;

class AllPositionsTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $this->assertTrue(
            interface_exists('Respect\Rest\Routable'),
            'Respect\Rest not installed.'
        );
        $this->assertTrue(
            class_exists($className = 'Ophportunidades\DataAccess\PDODataAccess'),
            'Expected class to exist: '.$className
        );
        $this->assertTrue(
            class_exists($className = 'Ophportunidades\Route\AllPositions'),
            'Expected class to exist: '.$className
        );
    }

    /**
     * @cover Ophportunidades\Route\AllPositions::__construct
     */
    public function testInstantiation()
    {
        $this->assertClassHasAttribute(
            $attributeName = 'dataAccess',
            'Ophportunidades\Route\AllPositions',
            'Missin attribute: '.$attributeName
        );
        $dataAccess = $this->getMockBuilder('Ophportunidades\DataAccess\PDODataAccess')
                           ->disableOriginalConstructor()
                           ->getMock();
        $instance = new AllPositions($dataAccess);
        $this->assertInstanceOf(
            'Respect\Rest\Routable',
            $instance
        );
        $this->assertAttributeEquals(
            $dataAccess,
            $attributeName,
            $instance
        );
    }

    /**
     * @depends testInstantiation
     * @cover   Ophportunidades\Route\AllPositions::__construct
     */
    public function testHasGetMethod()
    {
        $reflection = new \ReflectionClass('Ophportunidades\Route\AllPositions');
        $this->assertTrue(
            $reflection->hasMethod($methodName = 'get'),
            'Expected method to exist: '.$methodName
        );
    }

    /**
     * @depends testHasGetMethod
     * @cover   Ophportunidades\Route\AllPositions::get
     */
    public function testGet()
    {
        
        $dataAccess = $this->getMockBuilder('Ophportunidades\DataAccess\PDODataAccess')
                           ->disableOriginalConstructor()
                           ->setMethods(array('getAll'))
                           ->getMock();
        $dataAccess->expects($this->once())
                   ->method('getAll')
                   ->will($this->returnValue($expected = array()));
        $instance = new AllPositions($dataAccess);
        $this->assertEquals(
            $expected,
            $instance->get()
        );
    }
}