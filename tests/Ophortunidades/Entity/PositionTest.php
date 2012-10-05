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
    
    public function testShouldDefineAndRetrieveTheTitle()
    {
        $title      = 'oPHPortunidades';
        $instance = new Position();
        $instance->setTitle($title);

        $this->assertTrue(
            method_exists($instance, 'getTitle'),
            'There is no method getTitle on object'
        );
        $this->assertEquals($title, $instance->getTitle());
    }

    /**
     * @depends testShouldDefineAndRetrieveTheTitle
     */
    public function testShouldExistsSetterForDescription()
    {
        $instance    = new Position();
        $description = 'Descrição da oferta de emprego';
        $return      = $instance->setDescription($description);
        $this->assertEquals(
            $instance,
            $return,
            'Rerturned value should be the same instance for fluent interface'
        );
        $this->assertAttributeEquals(
            $description,
            'description',
            $instance,
            'Attribute was not correctly set'
        );
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowsAnExceptionWhenSettingAInvalidDescription()
    {
        $instance = new Position();
        $instance->setDescription(new \stdClass());
    }
    
    public function testShouldRetrieveADefinedDescription()
    {
        $description = 'This is my description';

        $instance = new Position();
        $instance->setDescription($description);
        
        $this->assertTrue(
            method_exists($instance, 'getDescription'),
            'There is no method getDescription on object'
        );
        $this->assertEquals($description, $instance->getDescription());
    }
    
    
    
    
}