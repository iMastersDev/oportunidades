<?php

namespace Ophportunidades\Entity;

use \InvalidArgumentException as Argument;

class Position
{

    protected $title;

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

}