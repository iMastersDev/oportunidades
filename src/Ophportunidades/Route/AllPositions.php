<?php
namespace Ophportunidades\Route;

use Respect\Rest\Routable;
use Ophportunidades\DataAccess\PDODataAccess;

class AllPositions implements Routable
{
    /**
     * @var Ophportunidades\DataAccess\PDODataAccess
     */
    protected $dataAccess;

    public function __construct(PDODataAccess $data)
    {
        $this->dataAccess = $data;
    }

    public function get()
    {
        return $this->dataAccess->getAll();
    }
}