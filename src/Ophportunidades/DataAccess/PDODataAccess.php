<?php
namespace Ophportunidades\DataAccess;

use \PDO;
use \RuntimeException           as Runtime;
use Ophportunidades\DataAccess\Entity\Position;
use Ophportunidades\Validation\Validator as v;

class PDODataAccess implements DataAccess
{
    const SQL_INSERT = 'INSERT INTO position( title, description, place ) VALUES (:title, :description, :place)';
    const SQL_BY_ID = 'SELECT title, description, place FROM position WHERE id=:id';
    const SQL_SELECT_ALL = 'SELECT title, description, place FROM position';
    /**
     *
     * @var \PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Position $position)
    {
        $stm = $this->pdo->prepare(self::SQL_INSERT);
        $stm->bindValue(':title', $position->getTitle(), PDO::PARAM_STR);
        $stm->bindValue(':description', $position->getDescription(), PDO::PARAM_STR);
        $stm->bindValue(':place', $position->getPlace(), PDO::PARAM_STR);

        if ($stm->execute()) {
            return (int) $this->pdo->lastInsertId();
        }

        throw new Runtime('Fail to insert some data');
    }

    /**
     * @throws InvalidArgumentException For invalid id.
     * @throws RuntimeException         For not found position.
     * @param  integer  $id
     * @return Ophportunidades\DataAccess\Entity\Position
     */
    public function getById($id)
    {
        v::id()->assert($id);

        $position       = null;
        $stm            = $this->pdo->prepare(self::SQL_BY_ID);
        $fetchIntoClass = 'Ophportunidades\DataAccess\Entity\Position';
        $stm->setFetchMode(PDO::FETCH_CLASS, $fetchIntoClass);
        $stm->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stm->execute()) {
            $position = $stm->fetch();
            $stm->closeCursor();
        }

        if (!$position instanceof Position) {
            throw new Runtime('Fail to retrieve the position');
        }

        return $position;
    }

    /**
     *
     * @throws RuntimeException
     */
    public function getAll()
    {
        $stm            = $this->pdo->prepare(self::SQL_SELECT_ALL);
        $fetchIntoClass = 'Ophportunidades\DataAccess\Entity\Position';
        $stm->setFetchMode(PDO::FETCH_CLASS, $fetchIntoClass);
        if ($stm->execute()) {
            return $stm->fetchAll();
        }

        throw new Runtime('Fail to retrieve the positions');
    }
}
