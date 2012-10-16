<?php
namespace Ophportunidades\DataAccess\Entity;

use \InvalidArgumentException as Argument;

class Position
{
    protected $title;
    protected $description;
    protected $place;

    public function setTitle($string)
    {
        if (empty($string)) {
            throw new Argument('Empty title not allowed');
        }
        $this->title = $string;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        if (!is_string($description)) {
            $message = sprintf('"%s"is not a valid description', print_r($description, true));
            throw new Argument($message);
        }
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setPlace($place = null)
    {
        if (is_string($place)) {
            $this->place = $place;

            return $this;
        }

        $message = sprintf('"%s" is not a valid place.', print_r($place, true));
        throw new Argument($message);
    }

    public function getPlace()
    {
        return $this->place;
    }
}