<?php
namespace Ophportunidades\DataAccess;

use Ophportunidades\DataAccess\Entity\Position;

interface DataAccess
{

    /**
     *
     * @param Ophportunidades\DataAccess\Entity\Position $position
     * @return integer
     */
    public function insert(Position $position);

    /**
     *
     * @return array[Ophportunidades\Entity\Position]
     */
    public function getAll();

    /**
     *
     * @param integer $id
     * @return Ophportunidades\DataAccess\Entity\Position
     */
    public function getById($id);
}