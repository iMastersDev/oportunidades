<?php
namespace Ophportunidades;

use Ophportunidades\DataAccess\Entity\Position;
use Ophportunidades\DataAccess\PDODataAccess;
use Ophportunidades\DataAccess\AbstractDataAccessTest;

class OphportunidadesTest extends AbstractDataAccessTest
{

    protected function setUp()
    {
        parent::setUp();

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['title'] = 'Job title';
        $_POST['description'] = 'Job description';
        $_POST['place'] = 'Somewhere over the rainbow';
    }

    public function testAcceptFromUserInputWithFakePOSTData()
    {
        $dataAccess = new PDODataAccess($this->pdo);
        $ophportunidades = new Ophportunidades($dataAccess);

        $id = $ophportunidades->acceptFromUserInput();

        $this->assertInternalType('int', $id);
        $this->assertGreaterThanOrEqual(1, $id);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testAcceptFromUserInputWithInvalidPOSTData()
    {
        $_POST['title'] = '';

        $dataAccess = new PDODataAccess($this->pdo);
        $ophportunidades = new Ophportunidades($dataAccess);

        $ophportunidades->acceptFromUserInput();
    }

    public function testCreateWithSampleData()
    {
        $position = new Position();
        $position->setTitle('job title');
        $position->setDescription('job description');
        $position->setPlace('somewhere in time');

        $dataAccess = new PDODataAccess($this->pdo);
        $ophportunidades = new Ophportunidades($dataAccess);

        $id = $ophportunidades->create($position);

        $this->assertInternalType('int', $id);
        $this->assertGreaterThanOrEqual(1, $id);
    }
}