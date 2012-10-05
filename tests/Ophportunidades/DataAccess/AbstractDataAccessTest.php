<?php
namespace Ophportunidades\DataAccess;

use \PDO;

abstract class AbstractDataAccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \PDO
     */
    protected $pdo;

    protected function setUp()
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS position (
                id INTEGER PRIMARY KEY,
                title TEXT NOT NULL,
                description TEXT NOT NULL,
                place TEXT NOT NULL
            );
        ');
    }

    protected function tearDown()
    {
        $this->pdo->exec('DROP TABLE position');
    }
}