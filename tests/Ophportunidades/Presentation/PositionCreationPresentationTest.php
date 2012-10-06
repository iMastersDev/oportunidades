<?php
namespace Ophportunidades\Presentation;

class PositionCreationPresentationTest extends \PHPUnit_Framework_TestCase
{

    public function testGeneratedXML()
    {
        $presentation = new PositionCreationPresentation();
        $drew = $presentation->draw();

        $this->assertTrue($drew->schemaValidate($presentation->getPresentationSchema()));
    }
}