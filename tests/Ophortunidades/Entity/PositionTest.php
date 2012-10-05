<?php
namespace Ophportunidades\Entity;

class PositionTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'Ophportunidades\Entity\Position'),
            'Class not found: '.$class
        );
    }

    public function testInstantiationWithoutArgumentsShouldWork()
    {
        $instance = new Position();
        $this->assertInstanceOf(
            'Ophportunidades\Entity\Position',
            $instance
        );
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testSetTitleWithValidDataShouldWork()
    {
        $instance = new Position();
        $title    = 'Titulo da oferta de emprego';
        $return   = $instance->setTitle($title);
        $this->assertEquals(
            $instance,
            $return,
            'Rerturned value should be the same instance for fluent interface'
        );
        $this->assertAttributeEquals(
            $title,
            'title',
            $instance,
            'Attribute was not correctly set'
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExpcetionMessage Empty title not allowed
     */
    public function testSetTitleWithInvalidDataShouldThrownAnException()
    {
        $invalidTitle = '';
        $instance = new Position();
        $instance->setTitle($invalidTitle);
    }
}