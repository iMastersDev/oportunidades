<?php

namespace Ophportunidades\Validation;

use Ophportunidades\Validation\Validator as v;

/**
 * @covers Ophportunidades\Validation\Validator
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
	const SUBJECT_CLASS = 'Ophportunidades\Validation\Validator';
	const CUSTOM_RULE_CLASS = 'Ophportunidades\Validation\Rules\Id';
	const CUSTOM_VALID_VALUE_FOR_RULE = 1;

	public function testDependencies()
	{
		$this->assertTrue(
			class_exists($name = 'Respect\Validation\Validator'),
			'Expected class to exist '.$name.'. Please, install Composer dependencies.'
		);

		$this->assertTrue(
			class_exists($name = self::SUBJECT_CLASS),
			'Expected class to exist: '.$name
		);
	}

	/**
	 * @depends testDependencies
	 */
	public function testRespectValidationRule()
	{
		$this->assertTrue(
			v::int()->validate(1),
			'Using a exiting Respect\Validation rule should work.'
		);
	}

	/**
	 * @depends testDependencies
	 * @expectedException UnexpectedValueException
	 * @expectedExceptionMessage Could not find rule on any namespace:
	 */
	public function testNonExistantRuleThrowsException()
	{
		v::awesomeRuleThatDontExist();
	}

	/**
	 * @depends testDependencies
	 */
	public function testCustomNamespaceRule()
	{
		$this->assertTrue(
			class_exists($className = self::CUSTOM_RULE_CLASS),
			'Expected rule to exist: '.$className
		);

		$this->assertTrue(
			v::id()->validate(self::CUSTOM_VALID_VALUE_FOR_RULE),
			'Custom rule validation should work, check the rule and value used.'
		);
	}
}