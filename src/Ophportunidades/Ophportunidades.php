<?php
namespace Ophportunidades;

use Ophportunidades\Entity\Position;
use Ophportunidades\DataAccess\DataAccess;

class Ophportunidades
{
    /**
     *
     * @var Ophportunidades\DataAccess\DataAccess
     */
    private $dataAccess;

    public function __construct(DataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function acceptFromUserInput()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postSpec = array(
                    'title' => FILTER_SANITIZE_STRING,
                    'description' => FILTER_SANITIZE_STRING,
                    'place' => FILTER_SANITIZE_STRING
            );

            $post = array_filter(filter_var_array($_POST, $postSpec));

            if (count($_POST) === count($post)) {
                $position = new Position();
                $position->setDescription($post['description']);
                $position->setTitle($post['title']);
                $position->setPlace($post['place']);

                return $this->create($position);
            }

            throw new \UnexpectedValueException('Invalid post data');
        }
    }

    public function create(Position $position)
    {
        return $this->dataAccess->insert($position);
    }
}