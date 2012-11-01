<?php
namespace Ophportunidades;

use Ophportunidades\DataAccess\Entity\Position;
use Ophportunidades\DataAccess\PDODataAccess;
use Ophportunidades\DataAccess\AbstractDataAccessTest;

class OphportunidadesTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['title'] = 'Job title';
        $_POST['description'] = 'Job description';
        $_POST['place'] = 'Somewhere over the rainbow';
    }

    /**
     * @cover Ophportunidades\Ophportunidades::__construct
     */
    public function testInstantiation()
    {
        $mockClassname  = 'Ophportunidades\DataAccess\PDODataAccess';
        $mockDataAccess = $this->getMockBuilder($mockClassname)
                               ->disableOriginalConstructor()
                               ->getMock();
        $this->assertInstanceOf(
            $expected = 'Ophportunidades\Ophportunidades',
            $result   = new Ophportunidades($mockDataAccess)
        );
        return $mockDataAccess;
    }

    /**
     * @depends testInstantiation
     * @cover   Ophportunidades\Ophportunidades::acceptFromUserInput
     */
    public function testAcceptFromUserInputWithoutPostData($mockDataAccess)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $ophportunidades           = new Ophportunidades($mockDataAccess);

        $ophportunidades->acceptFromUserInput();
        return $mockDataAccess;
    }

    /**
     * @depends testAcceptFromUserInputWithoutPostData
     * @cover   Ophportunidades\Ophportunidades::acceptFromUserInput
     * @expectedException UnexpectedValueException
     */
    public function testAcceptFromUserInputWithInvalidPostData($mockDataAccess)
    {
        $_POST['title']  = '';
        $ophportunidades = new Ophportunidades($mockDataAccess);

        $ophportunidades->acceptFromUserInput();
        return $mockDataAccess;
    }

    /**
     * @depends testAcceptFromUserInputWithInvalidPostData
     * @cover   Ophportunidades\Ophportunidades::acceptFromUserInput
     */
    public function testAcceptFromUserInputWithValidPostData($mockClassname)
    {
        $mockClassname  = 'Ophportunidades\DataAccess\PDODataAccess';
        $mockMethods    = array('insert');
        $mockDataAccess = $this->getMockBuilder($mockClassname)
                               ->setMethods($mockMethods)
                               ->disableOriginalConstructor()
                               ->getMock();
        $mockDataAccess->expects($this->once())
                       ->method('insert')
                       ->will($this->returnValue($expected = 1));
        $ophportunidades = new Ophportunidades($mockDataAccess);

        $id = $ophportunidades->acceptFromUserInput();

        $this->assertInternalType('int', $id);
        $this->assertGreaterThanOrEqual($expected, $id);
    }

    /**
     * @depends testInstantiation
     * @cover   Ophportunidades\Ophportunidades::create
     */
    public function testCreateWithSampleData($mockDataAccess)
    {
        $position = new Position();
        $position->setTitle('job title');
        $position->setDescription('job description');
        $position->setPlace('somewhere in time');

        $mockClassname  = 'Ophportunidades\DataAccess\PDODataAccess';
        $mockMethods    = array('insert');
        $mockDataAccess = $this->getMockBuilder($mockClassname)
                               ->setMethods($mockMethods)
                               ->disableOriginalConstructor()
                               ->getMock();
        $mockDataAccess->expects($this->once())
                       ->method('insert')
                       ->will($this->returnValue($expected = 1));
        $ophportunidades = new Ophportunidades($mockDataAccess);

        $id = $ophportunidades->create($position);

        $this->assertInternalType('int', $id);
        $this->assertGreaterThanOrEqual($expected, $id);
    }
}