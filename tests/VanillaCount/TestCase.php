<?php

namespace Rentalhost\VanillaCount\Test;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * Class TestCase
 * @package Rentalhost\VanillaCount\Test
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Call protected/private method of a class.
     *
     * @param object     $object     Instantiated object that we will run method on.
     * @param string     $methodName Method name to call
     * @param array|null $parameters Array of parameters to pass into method.
     *
     * @link https://jtreminio.com/
     *
     * @return mixed
     */
    public static function invokeMethod($object, $methodName, $parameters = null)
    {
        $objectReflection = new ReflectionClass($object);

        $methodReflection = $objectReflection->getMethod($methodName);
        $methodReflection->setAccessible(true);

        return $methodReflection->invokeArgs($object, $parameters ?: [ ]);
    }

    /**
     * Write protected/private attribute on an object.
     *
     * @param object $object    Object instance.
     * @param string $attribute Attribute to write on.
     * @param mixed  $value     The new attribute value.
     */
    public static function writeAttribute($object, $attribute, $value)
    {
        $objectReflection = new ReflectionClass($object);

        $propertyReflection = $objectReflection->getProperty($attribute);
        $propertyReflection->setAccessible(true);
        $propertyReflection->setValue($object, $value);
    }
}
