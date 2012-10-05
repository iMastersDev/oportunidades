<?php

namespace Ophportunidades\Entity;

use \InvalidArgumentException as Argument;

class Position
{

    protected $title;
    protected $description;

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
            throw new \InvalidArgumentException($message);
        }
        $this->description = $description;

        return $this;
    }
    
    public function getDescription()
    {
        return $this->description;
    }


    

}