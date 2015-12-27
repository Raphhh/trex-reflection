<?php
namespace TRex\Reflection;

class TypeReflectionTest extends \PHPUnit_Framework_TestCase
{

    private $types = [
        'void' => 'void',
        'mixed' => 'mixed',
        'null' => 'null',
        'bool' => 'boolean',
        'boolean' => 'boolean',
        'string' => 'string',
        'int' => 'integer',
        'integer' => 'integer',
        'long' => 'integer',
        'float' => 'float',
        'double' => 'float',
        'real' => 'float',
        'array' => 'array',
        'int[]' => 'array',
        'object' => 'object',
        'Datetime' => 'object',
        'resource' => 'resource',
        'invalid' => 'unknown type'

    ];

    public function testGetStandardizedType()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame($standard, $typeReflection->getStandardizedType(), $type);
        }
    }

    public function tesIsValid()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame($type !== 'invalid', $typeReflection->isVoid(), $type);
        }
    }

    public function tesIsVoid()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame($type === 'void', $typeReflection->isVoid(), $type);
        }
    }

    public function tesIsMixed()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame($type === 'mixed', $typeReflection->isMixed(), $type);
        }
    }

    public function tesIsNull()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame($type === 'null', $typeReflection->isNull(), $type);
        }
    }

    public function tesIsBoolean()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame(in_array($type, ['bool', 'boolean']), $typeReflection->isBoolean(), $type);
        }
    }

    public function tesIsString()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame($type === 'string', $typeReflection->isString(), $type);
        }
    }

    public function testIsInteger()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame(in_array($type, ['int', 'integer', 'long']), $typeReflection->isInteger(), $type);
        }
    }

    public function testIsFloat()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame(in_array($type, ['float', 'double', 'real']), $typeReflection->isFloat(), $type);
        }
    }

    public function testIsNumber()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame(
                in_array($type, ['int', 'integer', 'long', 'float', 'double', 'real']),
                $typeReflection->isNumber(),
                $type
            );
        }
    }

    public function testIsScalar()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame(
                in_array($type, ['bool', 'boolean', 'string', 'int', 'integer', 'long', 'float', 'double', 'real']),
                $typeReflection->isScalar(),
                $type
            );
        }
    }

    public function tesIsArray()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame(in_array($type, ['array', 'int[]']), $typeReflection->isArray(), $type);
        }
    }

    public function tesIsObject()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame(in_array($type, ['object', 'Datetime']), $typeReflection->isObject(), $type);
        }
    }

    public function tesIsResource()
    {
        foreach($this->types as $type => $standard){
            $typeReflection = new TypeReflection($type);
            $this->assertSame($type === 'resource', $typeReflection->isResource(), $type);
        }
    }
}
