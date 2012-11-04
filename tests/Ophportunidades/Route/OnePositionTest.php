<?php
namespace Ophportunidades\Route;

class OnePositionTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $this->assertTrue(
            interface_exists('Respect\Rest\Routable'),
            'Respect\Rest not installed.'
        );
        $this->assertTrue(
            class_exists($className = 'Ophportunidades\Ophportunidades'),
            'Expected class to exist: '.$className
        );
        $this->assertTrue(
            class_exists($className = 'Ophportunidades\Route\OnePosition'),
            'Expected class to exist: '.$className
        );
        $this->assertTrue(
            class_exists($className = 'Ophportunidades\Route\AllPositions'),
            'Expected class to exist: '.$className
        );
    }

    public function setUp()
    {
        global $header;
        $header = array();
    }

    /**
     * @cover Ophportunidades\Route\OnePosition::__construct
     */
    public function testInstantiation()
    {
        $this->assertClassHasAttribute(
            $attributeDataAccess = 'dataAccess',
            'Ophportunidades\Route\OnePosition',
            'Missing attribute: '.$attributeDataAccess
        );
        $this->assertClassHasAttribute(
            $attributeBusinessClass = 'business',
            'Ophportunidades\Route\OnePosition',
            'Missing attribute: '.$attributeBusinessClass
        );
        $dataAccess = $this->getMockBuilder('Ophportunidades\DataAccess\PDODataAccess')
                           ->disableOriginalConstructor()
                           ->getMock();
        $businessClass = $this->getMockBuilder('Ophportunidades\Ophportunidades')
                           ->disableOriginalConstructor()
                           ->getMock();
        $instance = new OnePosition($dataAccess, $businessClass);
        $this->assertAttributeEquals(
            $dataAccess,
            $attributeDataAccess,
            $instance
        );
        $this->assertAttributeEquals(
            $businessClass,
            $attributeBusinessClass,
            $instance
        );
    }

    /**
     * @depends testInstantiation
     * @cover   Ophportunidades\Route\OnePosition::get
     */
    public function testHasGetMethod()
    {
        $reflection = new \ReflectionClass('Ophportunidades\Route\OnePosition');
        $this->assertTrue(
            $reflection->hasMethod($methodName = 'get'),
            'Expected method to exist: '.$methodName
        );
    }

    /**
     * @depends testHasGetMethod
     * @cover   Ophportunidades\Route\OnePosition::get
     */
    public function testGet()
    {
        $dataAccess = $this->getMockBuilder('Ophportunidades\DataAccess\PDODataAccess')
                           ->disableOriginalConstructor()
                           ->setMethods(array('getById'))
                           ->getMock();
        $businessClass = $this->getMockBuilder('Ophportunidades\Ophportunidades')
                           ->disableOriginalConstructor()
                           ->getMock();
        $dataAccess->expects($this->once())
                   ->method('getById')
                   ->will($this->returnValue($expected = array()));
        $instance = new OnePosition($dataAccess, $businessClass);
        $this->assertEquals(
            $expected,
            $instance->get($whatever = 1)
        );
    }

    /**
     * @depends testInstantiation
     * @cover   Ophportunidades\Route\OnePosition::post
     */
    public function testHasPostMethod()
    {
        $reflection = new \ReflectionClass('Ophportunidades\Route\OnePosition');
        $this->assertTrue(
            $reflection->hasMethod($methodName = 'post'),
            'Expected method to exist: '.$methodName
        );
    }

    /**
     * @depends testHasPostMethod
     * @cover   Ophportunidades\Route\OnePosition::post
     */
    public function testPostWithValidDataShouldForwardToAllPositionsRoute()
    {
        global $header;
        $dataAccess = $this->getMockBuilder('Ophportunidades\DataAccess\PDODataAccess')
                           ->disableOriginalConstructor()
                           ->getMock();
        $businessClass = $this->getMockBuilder('Ophportunidades\Ophportunidades')
                           ->disableOriginalConstructor()
                           ->setMethods(array('acceptFromUserInput'))
                           ->getMock();
        $businessClass->expects($this->once())
                      ->method('acceptFromUserInput')
                      ->will($this->returnValue($expected = true));
        $instance = new OnePosition($dataAccess, $businessClass);
        $this->assertInstanceOf(
            $expectedInstanceForForward = 'Ophportunidades\Route\AllPositions',
            $instance->post(),
            'The result from post to create a new position does not forwards to another route.' 
        );
        $this->assertInternalType(
            'array',
            $header
        );
        $this->assertContains(
            OnePosition::HTTP_CREATED,
            $headerMessage = array_shift($header)
        );
        $this->assertContains(
            OnePosition::MSG_CREATED,
            $headerMessage
        );
    }

    /**
     * @depends testPostWithValidDataShouldForwardToAllPositionsRoute
     * @cover   Ophportunidades\Route\OnePosition::post
     */
    public function testPostWithInvalidDataShouldReturnAnString()
    {
        global $header;
        $dataAccess = $this->getMockBuilder('Ophportunidades\DataAccess\PDODataAccess')
                           ->disableOriginalConstructor()
                           ->getMock();
        $businessClass = $this->getMockBuilder('Ophportunidades\Ophportunidades')
                           ->disableOriginalConstructor()
                           ->setMethods(array('acceptFromUserInput'))
                           ->getMock();
        $businessClass->expects($this->once())
                      ->method('acceptFromUserInput')
                      ->will($this->returnValue($expected = false));
        $instance = new OnePosition($dataAccess, $businessClass);
        $this->assertEquals(
            $expectedMessage = OnePosition::MSG_NOT_CREATED,
            $instance->post(),
            'The result from post is not a message saing the insetion failed.' 
        );
        $this->assertInternalType(
            'array',
            $header
        );
        $this->assertContains(
            OnePosition::HTTP_ERROR,
            $headerMessage = array_shift($header)
        );
        $this->assertContains(
            OnePosition::MSG_NOT_CREATED,
            $headerMessage
        );
    }
}

$header=array();
if (!function_exists(__NAMESPACE__.'\\header')) {
    function header($string, $replace=true, $http_response_code=200)
        {
            global $header;
            if (!$replace && isset($header))
                return;

            $header[$string] = $string;
        }
}