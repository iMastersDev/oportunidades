<?php

namespace Ophportunidades\Validation\Rules;

use Ophportunidades\Validation\Validator as v;

/**
 * @covers Ophportunidades\Validation\Rules\Id
 * @covers Ophportunidades\Validation\Exceptions\IdException
 */
class IdTest extends \PHPUnit_Framework_TestCase
{
	const SUBJECT_CLASS = 'Ophportunidades\Validation\Rules\Id';
	const EXCEPTION_CLASS = 'Ophportunidades\Validation\Exceptions\IdException';

	public function testDependencies()
	{
		$this->assertTrue(
			class_exists($name = 'Respect\Validation\Validator'),
			'Expected class to exist '.$name.'. Please, install Composer dependencies.'
		);

		$this->assertTrue(
			class_exists($name = 'Ophportunidades\Validation\Validator'),
			'Expected class to exist '.$name.'. Please, install Composer dependencies.'
		);

		$this->assertTrue(
			class_exists($name = self::SUBJECT_CLASS),
			'Expected class to exist: '.$name
		);
	}

	/**
	 * @depends testDependencies
	 * @dataProvider provideValidId
	 */
	public function testValidId($id)
	{
		$rule = v::id();
		$this->assertTrue(
			$rule->validate($id),
			sprintf('"%s" should be a VALID ID.', $id)
		);
	}

	public static function provideValidId()
	{
		return [
			[1],
			[20],
			[100],
			[\PHP_INT_MAX]
		];
	}

	/**
	 * @depends testDependencies
	 * @dataProvider provideInvalidId
	 */
	public function testInvalidId($id)
	{
		$rule = v::id();
		$this->assertFalse(
			$rule->validate($id),
			sprintf('"%s" should be a INVALID ID.', $id)
		);
	}

	public function provideInvalidId()
	{
		return [
			[0],
			[-1],
			[1.0],
			[''],
			[null],
			['HA HA']
		];
	}

	/**
	 * @depends testDependencies
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidRuleExceptionMessage()
	{
		$this->assertTrue(
			class_exists($className = self::EXCEPTION_CLASS),
			'Expected exception for rule to exist: '.$className
		);

		$invalidId = '';
		v::id()->assert($invalidId);
	}
}