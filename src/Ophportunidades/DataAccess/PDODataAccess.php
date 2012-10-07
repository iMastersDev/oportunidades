<?php
namespace Ophportunidades\DataAccess;

use \PDO;
use Ophportunidades\DataAccess\Entity\Position;

class PDODataAccess implements DataAccess
{
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
        $stm = $this->pdo->prepare('
            INSERT INTO position(
                title,
                description,
                place
            ) VALUES (
                :title,
                :description,
                :place
            );
        ');

        $stm->bindValue(':title', $position->getTitle(), PDO::PARAM_STR);
        $stm->bindValue(':description', $position->getDescription(), PDO::PARAM_STR);
        $stm->bindValue(':place', $position->getPlace(), PDO::PARAM_STR);

        if ($stm->execute()) {
            return (int) $this->pdo->lastInsertId();
        }

        throw new \RuntimeException('Fail to insert some data');
    }

    public function getById($id)
    {
        if (is_int($id)) {
            $position = null;
            $stm = $this->pdo->prepare('
                SELECT
                    title,
                    description,
                    place
                FROM
                    position
                WHERE
                    id=:id;
            ');

            $stm->setFetchMode(PDO::FETCH_CLASS, 'Ophportunidades\DataAccess\Entity\Position');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);

            if ($stm->execute()) {
                $position = $stm->fetch();

                $stm->closeCursor();
            }

            if (!$position instanceof Position) {
                throw new \RuntimeException('Fail to retrieve the position');
            }

            return $position;
        }

        throw new \InvalidArgumentException(print_r($id, true) . ' is an invalid id');
    }

    /**
     *
     * @throws \RuntimeException
     */
    public function getAll()
    {
        $stm = $this->pdo->prepare('
                SELECT
                    title,
                    description,
                    place
                FROM
                    position;
            ');

        $stm->setFetchMode(PDO::FETCH_CLASS, 'Ophportunidades\Entity\Position');

        if ($stm->execute()) {
            return $stm->fetchAll();
        }

        throw new \RuntimeException('Fail to retrieve the positions');
    }
}