<?php

namespace Ophportunidades\Validation;

use Respect\Validation\Validator as RespectTheOriginalValidator;
use ReflectionClass;
use ReflectionException;
use UnexpectedValueException;
use InvalidArgumentException;

class Validator extends RespectTheOriginalValidator
{
    protected static $namespaces = array('Ophportunidades\Validation\Rules',
                                         'Respect\\Validation\\Rules');

    protected static function getReflectedRule($ruleSufixName)
    {
        foreach (self::$namespaces as $namespace) {
            $ruleFqn = $namespace.'\\'.$ruleSufixName;
            if (false === class_exists($ruleFqn, true)) {
                continue;
            }

            return new ReflectionClass($ruleFqn);
        }

        $msgBase = 'Rule sufix "%s" not found in namespaces: %s';
        $msg = sprintf($msgBase, $ruleSufixName, implode(', ', self::$namespaces));
        throw new InvalidArgumentException($msg);
    }

    public static function buildRule($ruleSpec, $arguments = array())
    {
        if ($ruleSpec instanceof Validatable) {
            return $ruleSpec;
        }

        try {
            $validatorClass = self::getReflectedRule($ruleSpec);
            $validatorInstance = $validatorClass->newInstanceArgs(
                $arguments
            );
            return $validatorInstance;
        } catch (InvalidArgumentException $e) {
            $msg = 'Could not find rule on any namespace: '.$ruleSpec;
            throw new UnexpectedValueException($msg, 0, $e);
        }
    }
}
