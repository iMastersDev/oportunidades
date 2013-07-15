<?php

namespace Ophportunidades\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class Id extends AbstractRule
{
    public function validate($input)
    {
        return is_int($input) && $input > 0;
    }
}
