<?php
namespace TRex\Reflection;


/**
 * TypeReflection reflect the types.
 *
 * @package TRex\Reflection
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @transient
 */
class TypeReflection
{

    const VOID_TYPE = 'void';
    const MIXED_TYPE = 'mixed';
    const NULL_TYPE = 'null';
    const BOOLEAN_TYPE = 'boolean';
    const STRING_TYPE = 'string';
    const INTEGER_TYPE = 'integer';
    const FLOAT_TYPE = 'float';
    const NUMBER_TYPE = 'number';
    const SCALAR_TYPE = 'scalar';
    const ARRAY_TYPE = 'array';
    const OBJECT_TYPE = 'object';
    const RESOURCE_TYPE = 'resource';
    const UNKNOWN_TYPE = 'unknown type';

    /**
     * @var array
     */
    private $typeMappingList = array(
        self::VOID_TYPE => array(
            'void',
        ),
        self::MIXED_TYPE => array(
            'mixed',
        ),
        self::NULL_TYPE => array(
            'null',
        ),
        self::BOOLEAN_TYPE => array(
            'bool',
            'boolean',
        ),
        self::STRING_TYPE => array(
            'string',
        ),
        self::INTEGER_TYPE => array(
            'int',
            'integer',
            'long',
        ),
        self::FLOAT_TYPE => array(
            'float',
            'double',
            'real',
        ),
        self::NUMBER_TYPE => array(
            'int',
            'integer',
            'long',
            'float',
            'double',
            'real',
        ),
        self::SCALAR_TYPE => array(
            'bool',
            'boolean',
            'string',
            'int',
            'integer',
            'long',
            'float',
            'double',
            'real',
        ),
        self::ARRAY_TYPE => array(
            'array',
        ),
        self::OBJECT_TYPE => array(
            'object',
        ),
        self::RESOURCE_TYPE => array(
            'resource',
        ),
    );

    /**
     * Reflected type or class name
     *
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $enableAutoload;

    /**
     * Constructor.
     *
     * @param string $type Reflected type or class name
     * @param bool $enableAutoload
     */
    public function __construct($type, $enableAutoload = false)
    {
        $this->setType($type);
        $this->enableAutoload = $enableAutoload;
    }

    /**
     * Getter of $enableAutoload
     *
     * @return boolean
     */
    public function isAutoloadEnabled()
    {
        return $this->enableAutoload;
    }

    /**
     * Setter of $enableAutoload
     *
     * @param boolean $enableAutoload
     */
    public function setEnableAutoload($enableAutoload)
    {
        $this->enableAutoload = (boolean)$enableAutoload;
    }

    /**
     * Gets the reflected type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Depending on the type, returns a standardized type, a constant value of XXX_TYPE.
     * Note that if the type is a class name, object type is returned.
     *
     *
     * @return string
     */
    public function getStandardizedType()
    {
        foreach ($this->getStandardizedTypes() as $standardizedType) {
            if ($this->is($standardizedType)) {
                return $standardizedType;
            }
        }
        return self::UNKNOWN_TYPE;
    }

    /**
     * Indicates if the type is recognized.
     *
     * @return bool
     */
    public function isValid()
    {
        return !$this->is(self::UNKNOWN_TYPE);
    }

    /**
     * Indicates whether the reflected type is void.
     * Valid values are:
     *  - void
     *
     * @return bool
     */
    public function isVoid()
    {
        return $this->is(self::VOID_TYPE);
    }

    /**
     * Indicates whether the reflected type is mixed.
     * Valid values are:
     *  - mixed
     *
     * @return bool
     */
    public function isMixed()
    {
        return $this->is(self::MIXED_TYPE);
    }

    /**
     * Indicates whether the reflected type is null.
     * Valid values are:
     *  - null
     *
     * @return bool
     */
    public function isNull()
    {
        return $this->is(self::NULL_TYPE);
    }

    /**
     * Indicates whether the reflected type is boolean.
     * Valid values are:
     *  - bool
     *  - boolean
     *
     * @return bool
     */
    public function isBoolean()
    {
        return $this->is(self::BOOLEAN_TYPE);
    }

    /**
     * Indicates whether the reflected type is string.
     * Valid values are:
     *  - string
     *
     * @return bool
     */
    public function isString()
    {
        return $this->is(self::STRING_TYPE);
    }

    /**
     * Indicates whether the reflected type is integer.
     * Valid values are
     *  - int
     *  - integer
     *  - long
     *
     * @return bool
     */
    public function isInteger()
    {
        return $this->is(self::INTEGER_TYPE);
    }

    /**
     * Indicates whether the reflected type is float.
     * Valid values are
     *  - float
     *  - double
     *  - real
     *
     * @return bool
     */
    public function isFloat()
    {
        return $this->is(self::FLOAT_TYPE);
    }

    /**
     * Indicates whether the reflected type is number.
     * Valid values are:
     *  - every value valid for int
     *  - every value valid for float
     *
     * @return bool
     */
    public function isNumber()
    {
        return $this->is(self::NUMBER_TYPE);
    }

    /**
     * Indicates whether the reflected type is scalar.
     * Valid values are:
     *  - every value valid for boolean
     *  - every value valid for string
     *  - every value valid for int
     *  - every value valid for float
     *
     * @return bool
     */
    public function isScalar()
    {
        return $this->is(self::SCALAR_TYPE);
    }

    /**
     * Indicates whether the reflected type is array.
     * Valid values are:
     *  - array
     *  - xxx[]
     *
     * @return bool
     */
    public function isArray()
    {
        return $this->is(self::ARRAY_TYPE);
    }

    /**
     * Indicates whether the reflected type is object.
     * Valid values are:
     *  - object
     *  - valid class name
     *
     * @return bool
     */
    public function isObject()
    {
        return $this->is(self::OBJECT_TYPE);
    }

    /**
     * Indicates whether the reflected type is resource.
     * Valid values are:
     *  - resource
     *
     * @return bool
     */
    public function isResource()
    {
        return $this->is(self::RESOURCE_TYPE);
    }

    /**
     * Indicates whether the reflected type is $standardizedType.
     *
     * @param string $standardizedType see specific const.
     * @return bool
     */
    public function is($standardizedType)
    {
        if ($standardizedType === self::OBJECT_TYPE && class_exists($this->getType(), $this->isAutoloadEnabled())) {
            return true;
        }
        if ($standardizedType === self::ARRAY_TYPE && stripos($this->getType(), '[]') !== false) {
            return true;
        }
        return $this->isInTypeMapping($standardizedType);
    }

    /**
     * Setter of $type.
     *
     * @param string $type
     */
    private function setType($type)
    {
        $this->type = (string)$type;
    }

    /**
     * Getter of $typeMappingList.
     *
     * @return array
     */
    private function getTypeMappingList()
    {
        return $this->typeMappingList;
    }

    /**
     * Returns a type mapping.
     *
     * @param string $standardizeType
     * @return array
     */
    private function getTypeMapping($standardizeType = '')
    {
        return $this->getTypeMappingList()[$standardizeType];
    }

    /**
     * Indicates whether self::$type is a possible type of $standardizedType.
     *
     * @param string $standardizedType
     * @return bool
     */
    private function isInTypeMapping($standardizedType)
    {
        return in_array(strtolower($this->getType()), $this->getTypeMapping($standardizedType), true);
    }

    /**
     * get the possible types.
     *
     * @return array
     */
    private function getStandardizedTypes()
    {
        return array_keys($this->getTypeMappingList());
    }
}
