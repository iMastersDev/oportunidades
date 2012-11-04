<?php
namespace Ophportunidades\Route;

use Respect\Rest\Routable;
use Ophportunidades\DataAccess\PDODataAccess;
use Ophportunidades\Ophportunidades;

class OnePosition implements Routable
{
    const HTTP_ERROR = 'HTTP/1.1 500';
    const HTTP_CREATED = 'HTTP/1.1 201';
    const MSG_CREATED = 'Posição criada com sucesso.';
    const MSG_NOT_CREATED = 'Não foi possível inserir a posição.';

    /**
     * @var Ophportunidades\DataAccess\PDODataAccess
     */
    protected $dataAccess;
    /**
     * @var Ophportunidades\Ophportunidades
     */
    protected $business;

    public function __construct(PDODataAccess $data, Ophportunidades $business)
    {
        $this->dataAccess = $data;
        $this->business   = $business;
    }

    public function get($positionId)
    {
        return $this->dataAccess->getById($positionId);
    }

    public function post()
    {
        if ($this->business->acceptFromUserInput()) {
            header(self::HTTP_CREATED.' '.self::MSG_CREATED);
            return new AllPositions($this->dataAccess);
        }
        header(self::HTTP_ERROR.' '.self::MSG_NOT_CREATED);
        return self::MSG_NOT_CREATED;
    }
}