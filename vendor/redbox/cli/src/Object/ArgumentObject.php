<?php
namespace Redbox\Cli\Object;

class ArgumentObject {

    /**
     * @var array
     */
    protected $modelData = [];

    /**
     * Construct this magic object. Give it a array amd
     * it will turn into an object. Its a hydration.
     *
     * Object constructor.
     * @param $array
     */
    public function __construct($array = array())
    {
        $this->mapTypes($array);
    }

    /**
     * Convert a string to camelCase
     *
     * @param  string $value
     * @return string
     */
    public static function camelCase($value)
    {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));
        $value = str_replace(' ', '', $value);
        $value[0] = strtolower($value[0]);
        return $value;
    }

    /**
     * Initialize this object's properties from an array.
     *
     * @param array $array Used to seed this object's properties.
     * @return void
     */
    protected function mapTypes($array)
    {
        foreach ($array as $key => $val) {
            if (!property_exists($this, $this->keyType($key)) &&
                property_exists($this, $key)) {
                $this->$key = $val;
                unset($array[$key]);
            } elseif (property_exists($this, $camelKey = self::camelCase($key))) {
                $this->$camelKey = $val;
            }
        }
        $this->modelData = $array;
    }

    /**
     * Return the keyType for a given key.
     *
     * @param $key
     * @return string
     */
    protected function keyType($key)
    {
        return $key."Type";
    }

    /**
     * Return the dataType for a key.
     *
     * @param $key
     * @return string
     */
    protected function dataType($key)
    {
        return $key."DataType";
    }

    /**
     * Check to see if a given key is set or not.
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->modelData[$key]);
    }

    /**
     * Unset a given key.
     *
     * @param $key
     */
    public function __unset($key)
    {
        unset($this->modelData[$key]);
    }
}
