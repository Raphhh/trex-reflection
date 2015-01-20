<?php
namespace TRex\Reflection;

use TRex\Reflection\resources\Callback;

class CallableReflectionTest extends \PHPUnit_Framework_TestCase
{

    public function testGetCallable()
    {
        $callable = $this->getInvokedObject();
        $reflectedCallable = new CallableReflection($callable);
        $this->assertSame($callable, $reflectedCallable->getCallable());
    }

    public function testgetReflectorForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $reflection = $reflectedCallable->getReflector();
        $this->assertInstanceOf('\ReflectionFunction', $reflection);
        $this->assertSame($this->getFunction(), $reflection->getName());
    }

    public function testgetReflectorForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $reflection = $reflectedCallable->getReflector();
        $this->assertInstanceOf('\ReflectionFunction', $reflection);
        $this->assertSame('TRex\Reflection\{closure}', $reflection->getName());
    }

    public function testgetReflectorForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $reflection = $reflectedCallable->getReflector();
        $this->assertInstanceOf('\ReflectionMethod', $reflection);
        $this->assertSame('foo', $reflection->getName());
    }

    public function testgetReflectorForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $reflection = $reflectedCallable->getReflector();
        $this->assertInstanceOf('\ReflectionMethod', $reflection);
        $this->assertSame('bar', $reflection->getName());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $reflection = $reflectedCallable->getReflector();
        $this->assertInstanceOf('\ReflectionMethod', $reflection);
        $this->assertSame('bar', $reflection->getName());
    }

    public function testgetReflectorForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $reflection = $reflectedCallable->getReflector();
        $this->assertInstanceOf('\ReflectionMethod', $reflection);
        $this->assertSame('__invoke', $reflection->getName());
    }

    public function testInvokeForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertTrue($reflectedCallable->invoke('foo'));
    }

    public function testInvokeForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame(array(1, 2), $reflectedCallable->invoke(1, 2));
    }

    public function testInvokeForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(array(1, 2), $reflectedCallable->invoke(1, 2));
    }

    public function testInvokeForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame(array(1, 2), $reflectedCallable->invoke(1, 2));

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame(array(1, 2), $reflectedCallable->invoke(1, 2));
    }

    public function testInvokeForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame(array(1, 2), $reflectedCallable->invoke(1, 2));
    }

    public function testInvokeArgsForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertTrue($reflectedCallable->invokeArgs(array('foo')));
    }

    public function testInvokeArgsForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgs(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeArgsForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgs(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeArgsForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgs(array('b' => 1, 'a' => 2)));

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgs(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeArgsForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgs(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertTrue($reflectedCallable->invokeA(array('var' => 'foo')));
    }

    public function testInvokeAForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeA(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeA(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeA(array('b' => 1, 'a' => 2)));

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeA(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeA(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAWithOptionalParameter()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(array(2, 1, 3), $reflectedCallable->invokeA(array('b' => 1, 'a' => 2, 'c' => 3)));
    }

    public function testInvokeAWithUndeclaredParameter()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeA(array('b' => 1, 'a' => 2, 'd' => 4)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Missing key "a" for the 0th params of foo
     */
    public function testInvokeAWithMissingParameter()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $reflectedCallable->invokeA(array());
    }

    public function testInvokeStaticForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertTrue($reflectedCallable->invokeStatic('foo'));
    }

    public function testInvokeStaticForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeStatic(1, 2));
    }

    public function testInvokeStaticForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeStatic(1, 2));
    }

    public function testInvokeStaticForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeStatic(1, 2));

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeStatic(1, 2));
    }

    public function testInvokeStaticForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeStatic(1, 2));
    }

    public function testInvokeArgsStaticForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertTrue($reflectedCallable->invokeArgsStatic(array('foo')));
    }

    public function testInvokeArgsStaticForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgsStatic(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeArgsStaticForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgsStatic(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeArgsStaticForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgsStatic(array('b' => 1, 'a' => 2)));

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgsStatic(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeArgsStaticForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame(array(1, 2), $reflectedCallable->invokeArgsStatic(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAStaticForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertTrue($reflectedCallable->invokeAStatic(array('var' => 'foo')));
    }

    public function testInvokeAStaticForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeAStatic(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAStaticForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeAStatic(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAStaticForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeAStatic(array('b' => 1, 'a' => 2)));

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeAStatic(array('b' => 1, 'a' => 2)));
    }

    public function testInvokeAStaticForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame(array(2, 1), $reflectedCallable->invokeAStatic(array('b' => 1, 'a' => 2)));
    }

    public function testGetTypeForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertSame(CallableReflection::FUNCTION_TYPE, $reflectedCallable->getType());
    }

    public function testGetTypeForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame(CallableReflection::CLOSURE_TYPE, $reflectedCallable->getType());
    }

    public function testGetTypeForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame(CallableReflection::INSTANCE_METHOD_TYPE, $reflectedCallable->getType());
    }

    public function testGetTypeForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame(CallableReflection::STATIC_METHOD_TYPE, $reflectedCallable->getType());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame(CallableReflection::STATIC_METHOD_TYPE, $reflectedCallable->getType());
    }

    public function testGetTypeForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame(CallableReflection::INVOKED_OBJECT_TYPE, $reflectedCallable->getType());
    }

    public function testIsFunctionForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertTrue($reflectedCallable->isFunction());
    }

    public function testIsFunctionForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertFalse($reflectedCallable->isFunction());
    }

    public function testIsFunctionForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertFalse($reflectedCallable->isFunction());
    }

    public function testIsFunctionForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertFalse($reflectedCallable->isFunction());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertFalse($reflectedCallable->isFunction());
    }

    public function testIsFunctionForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertFalse($reflectedCallable->isFunction());
    }

    public function testIsClosureForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertFalse($reflectedCallable->isClosure());
    }

    public function testIsClosureForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertTrue($reflectedCallable->isClosure());
    }

    public function testIsClosureForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertFalse($reflectedCallable->isClosure());
    }

    public function testIsClosureForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertFalse($reflectedCallable->isClosure());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertFalse($reflectedCallable->isClosure());
    }

    public function testIsClosureForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertFalse($reflectedCallable->isClosure());
    }

    public function testIsInstanceMethodForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertFalse($reflectedCallable->isInstanceMethod());
    }

    public function testIsInstanceMethodForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertFalse($reflectedCallable->isInstanceMethod());
    }

    public function testIsInstanceMethodForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertTrue($reflectedCallable->isInstanceMethod());
    }

    public function testIsInstanceMethodForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertFalse($reflectedCallable->isInstanceMethod());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertFalse($reflectedCallable->isInstanceMethod());
    }

    public function testIsInstanceMethodForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertFalse($reflectedCallable->isInstanceMethod());
    }

    public function testIsStaticMethodForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertFalse($reflectedCallable->isStaticMethod());
    }

    public function testIsStaticMethodForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertFalse($reflectedCallable->isStaticMethod());
    }

    public function testIsStaticMethodForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertFalse($reflectedCallable->isStaticMethod());
    }

    public function testIsStaticMethodForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertTrue($reflectedCallable->isStaticMethod());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertTrue($reflectedCallable->isStaticMethod());
    }

    public function testIsStaticMethodForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertFalse($reflectedCallable->isStaticMethod());
    }

    public function testIsInvokedObjectForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertFalse($reflectedCallable->isInvokedObject());
    }

    public function testIsInvokedObjectForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertFalse($reflectedCallable->isInvokedObject());
    }

    public function testIsInvokedObjectForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertFalse($reflectedCallable->isInvokedObject());
    }

    public function testIsInvokedObjectForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertFalse($reflectedCallable->isInvokedObject());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertFalse($reflectedCallable->isInvokedObject());
    }

    public function testIsInvokedObjectForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertTrue($reflectedCallable->isInvokedObject());
    }

    public function testGetFunctionNameForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertSame($this->getFunction(), $reflectedCallable->getFunctionName());
    }

    public function testGetFunctionNameForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame('', $reflectedCallable->getFunctionName());
    }

    public function testGetFunctionNameForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame('', $reflectedCallable->getFunctionName());
    }

    public function testGetFunctionNameForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame('', $reflectedCallable->getFunctionName());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame('', $reflectedCallable->getFunctionName());
    }

    public function testGetFunctionNameForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame('', $reflectedCallable->getFunctionName());
    }

    public function testGetClosureForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertNull($reflectedCallable->getClosure());
    }

    public function testGetClosureForClosure()
    {
        $closure = $this->getClosure();
        $reflectedCallable = new CallableReflection($closure);
        $this->assertSame($closure, $reflectedCallable->getClosure());
    }

    public function testGetClosureForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertNull($reflectedCallable->getClosure());
    }

    public function testGetClosureForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertNull($reflectedCallable->getClosure());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertNull($reflectedCallable->getClosure());
    }

    public function testGetClosureForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertNull($reflectedCallable->getClosure());
    }

    public function testGetMethodNameForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertSame('', $reflectedCallable->getMethodName());
    }

    public function testGetMethodNameForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame('', $reflectedCallable->getMethodName());
    }

    public function testGetMethodNameForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame('foo', $reflectedCallable->getMethodName());
    }

    public function testGetMethodNameForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame('bar', $reflectedCallable->getMethodName());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame('bar', $reflectedCallable->getMethodName());
    }

    public function testGetMethodNameForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame('', $reflectedCallable->getMethodName());
    }

    public function testGetClassNameForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertSame('', $reflectedCallable->getClassName());
    }

    public function testGetClassNameForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertSame('', $reflectedCallable->getClassName());
    }

    public function testGetClassNameForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertSame('TRex\Reflection\resources\Callback', $reflectedCallable->getClassName());
    }

    public function testGetClassNameForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertSame('TRex\Reflection\resources\Callback', $reflectedCallable->getClassName());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertSame('TRex\Reflection\resources\Callback', $reflectedCallable->getClassName());
    }

    public function testGetClassNameForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertSame('TRex\Reflection\resources\Callback', $reflectedCallable->getClassName());
    }

    public function testGetObjectForFunction()
    {
        $reflectedCallable = new CallableReflection($this->getFunction());
        $this->assertNull($reflectedCallable->getObject());
    }

    public function testGetObjectForClosure()
    {
        $reflectedCallable = new CallableReflection($this->getClosure());
        $this->assertNull($reflectedCallable->getObject());
    }

    public function testGetObjectForInstanceMethod()
    {
        $reflectedCallable = new CallableReflection($this->getInstanceMethod());
        $this->assertInstanceOf('TRex\Reflection\resources\Callback', $reflectedCallable->getObject());
    }

    public function testGetObjectForStaticMethod()
    {
        $reflectedCallable = new CallableReflection($this->getStaticMethod1());
        $this->assertNull($reflectedCallable->getObject());

        $reflectedCallable = new CallableReflection($this->getStaticMethod2());
        $this->assertNull($reflectedCallable->getObject());
    }

    public function testGetObjectForInvokedObject()
    {
        $reflectedCallable = new CallableReflection($this->getInvokedObject());
        $this->assertInstanceOf('TRex\Reflection\resources\Callback', $reflectedCallable->getObject());
    }

    /**
     * @return callable
     */
    private function getFunction()
    {
        return 'is_string';
    }

    /**
     * @return callable
     */
    private function getClosure()
    {
        return function ($a, $b, $c = 3) {
            return func_get_args();
        };
    }

    /**
     * @return callable
     */
    private function getInstanceMethod()
    {
        $callback = new Callback();
        return array($callback, 'foo');
    }

    /**
     * @return callable
     */
    private function getStaticMethod1()
    {
        return array('TRex\Reflection\resources\Callback', 'bar');
    }

    /**
     * @return callable
     */
    private function getStaticMethod2()
    {
        return 'TRex\Reflection\resources\Callback::bar';
    }

    /**
     * @return callable
     */
    private function getInvokedObject()
    {
        return new Callback();
    }
}
