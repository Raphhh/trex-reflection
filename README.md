# TRex Reflection

[![Latest Stable Version](https://poser.pugx.org/raphhh/trex-reflection/v/stable.svg)](https://packagist.org/packages/raphhh/trex-reflection)
[![Build Status](https://travis-ci.org/Raphhh/trex-reflection.png)](https://travis-ci.org/Raphhh/trex-reflection)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/trex-reflection/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/trex-reflection/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/trex-reflection/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/trex-reflection/)
[![Dependency Status](https://www.versioneye.com/user/projects/54062eb9c4c187ff6100006f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54062eb9c4c187ff6100006f)
[![Total Downloads](https://poser.pugx.org/raphhh/trex-reflection/downloads.svg)](https://packagist.org/packages/raphhh/trex-reflection)
[![Reference Status](https://www.versioneye.com/php/raphhh:trex-reflection/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:trex-reflection/references)
[![License](https://poser.pugx.org/raphhh/trex-reflection/license.svg)](https://packagist.org/packages/raphhh/trex-reflection)



## Installation


Use composer command:

```
$ composer require raphhh/trex-reflection
```

## Documentation

 - [CallableReflection](#callablereflection)
 - [TypeReflection](typereflection)
 
### CallableReflection

You can use CallableReflection to inspect and call a callable, like a callback or a Closure for example.

#### All kind of callable

You can know which kind of callable is given.

##### Closure
```php
$reflect = new CallableReflection(function(){});
$reflect->isClosure(); //true
```

##### Function
```php
$reflect = CallableReflection('in_array')
$reflect->isFunction(); //true
```

##### Static method
```php
$reflect = new CallableReflection('\DateTime::createFromFormat');
$reflect->isMethod(); //true
$reflect->isStaticMethod(); //true
```

```php
$reflect = new CallableReflection(array('\DateTime', 'createFromFormat'));
$reflect->isMethod(); //true
$reflect->isStaticMethod(); //true
```

##### Instance method
```php
$reflect = new CallableReflection(array(new \DateTime(), 'modify'));
$reflect->isMethod(); //true
$reflect->isInvokedObject(); //true
```

##### Invoked object
```php
class Bar{
    function __invoke(){}
}

$reflect = new CallableReflection(new Bar());
$reflect->isInstanceMethod(); //true
```

#### Retrieve contexts

You can retrieve the callable, like the object or the method name for example.

##### Closure
```php
$reflect = new CallableReflection(function(){});
$reflect->getClosure(); //closure
```

##### Function
```php
$reflect = new CallableReflection('in_array')
$reflect->getFunctionName(); //'in_array'
```

##### Static method
```php
$reflect = new CallableReflection('\DateTime::createFromFormat');
$reflect->getClassName(); //'DateTime'
$reflect->getMethodName(); //'createFromFormat'
```

```php
$reflect = new CallableReflection(array('\DateTime', 'createFromFormat'));
$reflect->getClassName(); //'DateTime'
$reflect->getMethodName(); //'createFromFormat'
```

##### Instance method
```php
$reflect = new CallableReflection(array(new \DateTime(), 'modify'));
$reflect->getClassName(); //'DateTime'
$reflect->getObject(); //DateTime instance
$reflect->getMethodName(); //'modify'
```

##### Invoked object
```php
class Bar{
    function __invoke(){}
}

$reflect = new CallableReflection(new Bar());
$reflect->getClassName(); //'Bar'
$reflect->getObject(); //Bar instance
```


#### Invoke callable

You can invoke every kind of callable in a same way.

#### With a list of args

This method calls the method and give to it all its args.

```php
$reflect = new CallableReflection('in_array')
$reflect->invoke(1, [0, 1]); //true
```

#### With an array of args

This method allows to map each value of an array with every params of a function. Useful to use dynamic args with func_get_args().

```php
$reflect = new CallableReflection('in_array')
$reflect->invoke([1, [0, 1]]); //true
```

#### With a map of args

This method allows to map the keys of an array with the name of the params of a function. So, the order of the args has no importance.

```php

$closure = function($arg1, $arg2){
    return [$arg1, $arg2];
}

$reflect = new CallableReflection($closure)
$reflect->invokeA(['arg2' => 'arg2', 'arg1' => 'arg1'])); //['arg1', 'arg2']
```


### TypeReflection

Reflection on the type of a variable or function. 

#### What is a type?

A type is a string returned by [gettype](http://php.net/manual/en/function.gettype.php) function. 

```php
$var = 'I am a string'
gettype($var); //"string"
```

We can also found it in the PHP doc comment. 

```php
/**
 * @var int
 */
 public $var;
 
 ```

Note the `TypeReflection` is case insensitive.

#### Standardized types

`TypeReflection` standardizes types with following values:

 - `void`
 - `mixed`
 - `null`
 - `boolean`
 - `string`
 - `integer`
 - `float`
 - `number`
 - `scalar`
 - `array`
 - `object`
 - `resource`
 - `unknown type`

#### Valid any type

##### Recognition

```php
$typeReflection = new TypeReflection('string');
$typeReflection->isValid(); //true
```

```php
$typeReflection = new TypeReflection('foo');
$typeReflection->isValid(); //false
```

##### boolean

```php
$typeReflection = new TypeReflection('bool');
$typeReflection->isBoolean(); //true
```

```php
$typeReflection = new TypeReflection('boolean');
$typeReflection->isBoolean(); //true
```

##### string

```php
$typeReflection = new TypeReflection('string');
$typeReflection->isString(); //true
```

##### integer

```php
$typeReflection = new TypeReflection('int');
$typeReflection->isInteger(); //true
```

```php
$typeReflection = new TypeReflection('integer');
$typeReflection->isInteger(); //true
```

```php
$typeReflection = new TypeReflection('long');
$typeReflection->isInteger(); //true
```

##### float

```php
$typeReflection = new TypeReflection('float');
$typeReflection->isFloat(); //true
```

```php
$typeReflection = new TypeReflection('double');
$typeReflection->isFloat(); //true
```

```php
$typeReflection = new TypeReflection('real');
$typeReflection->isFloat(); //true
```

##### number

Any integer or float value.

##### scalar

Any boolean, string or number value.

##### array

```php
$typeReflection = new TypeReflection('array');
$typeReflection->isArray(); //true
```

```php
$typeReflection = new TypeReflection('int[]');
$typeReflection->isArray(); //true
```

##### object

```php
$typeReflection = new TypeReflection('object');
$typeReflection->isObject(); //true
```

```php
$typeReflection = new TypeReflection('Datetime');
$typeReflection->isObject(); //true
```

##### resource

```php
$typeReflection = new TypeReflection('resource');
$typeReflection->isResource(); //true
```

##### void

```php
$typeReflection = new TypeReflection('void');
$typeReflection->isVoid(); //true
```

##### null

```php
$typeReflection = new TypeReflection('null');
$typeReflection->isNull(); //true
```

##### mixed

```php
$typeReflection = new TypeReflection('mixed');
$typeReflection->isMixed(); //true
```


#### Retrieve a standard notation

```php
$typeReflection = new TypeReflection('bool');
$typeReflection->getStandardizedType(); //boolean
```

```php
$typeReflection = new TypeReflection('int');
$typeReflection->getStandardizedType(); //integer
```

```php
$typeReflection = new TypeReflection('real');
$typeReflection->getStandardizedType(); //float
```

```php
$typeReflection = new TypeReflection('int[]');
$typeReflection->getStandardizedType(); //array
```

```php
$typeReflection = new TypeReflection('Datetime');
$typeReflection->getStandardizedType(); //object
```
