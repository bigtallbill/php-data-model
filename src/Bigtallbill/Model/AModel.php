<?php
/**
 * Created by PhpStorm.
 * User: bigtallbill
 * Date: 24/12/14
 * Time: 14:04
 */

namespace Bigtallbill\Model;


use Bigtallbill\Model\DbWrapper\DbWrapper;

abstract class AModel
{
    /** @var DbWrapper */
    protected $client;

    protected $databaseName;
    protected $collectionName;

    protected $config = array();

    /** @var array Stores all the key => values */
    protected $values = array();

    protected $modified = array();

    protected $allowUnknownProperties = false;

    /**
     * @param DbWrapper $client
     * @param string $databaseName
     * @param string $collectionName
     * @param array $config
     * @param bool $allowUnknownProperties
     */
    function __construct(
        DbWrapper $client = null,
        $databaseName = '',
        $collectionName = '',
        array $config = array(),
        $allowUnknownProperties = false
    ) {
        $this->client = $client;
        $this->databaseName = $databaseName;
        $this->collectionName = $collectionName;
        $this->config = $config;
        $this->allowUnknownProperties = $allowUnknownProperties;

        $this->addProp('id');
    }

    public function addProp($name, $options = array())
    {
        $this->config[$name] = $options;
    }

    public function getPropConfig()
    {
        return $this->config;
    }

    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->config) && !$this->allowUnknownProperties) {
            throw new \RuntimeException("$name is not a valid property");
        }

        if (isset($this->config[$name]['types'])) {
            $type = gettype($value);
            if ($type === 'object') {
                $type = get_class($value);
            }

            if (!in_array($type, $this->config[$name]['types'])) {
                throw new \RuntimeException("$name was not of type " . implode(',', $this->config[$name]['types']));
            }
        }

        // store any unique modified values to allow building a query later
        if (isset($this->values[$name]) && $this->{$name} !== $value) {

            // id fields cannot be modified after they are set
            if ($name === 'id' && $value != null) {
                return;
            }
            $this->modified[$name] = $value;
        }

        $this->values[$name] = $value;
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->config) && !$this->allowUnknownProperties) {
            throw new \RuntimeException("$name is not a valid property");
        }

        if (!isset($this->values[$name])) {
            return null;
        }

        return $this->values[$name];
    }

    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Recursively converts this model to an associative array
     * If a Model instance is encountered as a value, the result of it's toArray method is used as its value instead
     *
     * @param bool $modified If true, will only return modified values
     * @return array
     */
    public function toArray($modified = false)
    {
        $arr = array();

        $values = $modified ? $this->modified : $this->values;
        foreach ($values as $name => $value) {

            if ($name === 'id') {
                $name = $this->getIdKeyName();
            }

            if ($value instanceof AModel) {
                $arr[$name] = $value->toArray();
            } else {
                $arr[$name] = $value;
            }
        }

        return $arr;
    }

    /**
     * @param array $array Loads an array into this object
     */
    public function fromArray(array $array)
    {
        foreach ($array as $name => $value) {
            if ($name === $this->getIdKeyName()) {
                $this->id = $array[$this->getIdKeyName()];
                continue;
            }

            if (isset($this->config[$name]) && isset($this->config[$name]['types'])) {

                // if this value should be Model type then convert it to a model
                foreach ($this->config[$name]['types'] as $type) {
                    if (is_subclass_of($type, 'Bigtallbill\Model\AModel') || $type === 'Bigtallbill\Model\AModel') {
                        $valueObject = new $type(null, '', '', array(), true);
                        $valueObject->fromArray($value);
                        $value = $valueObject;
                        break;
                    }
                }
            }

            $this->{$name} = $value;
        }
    }

    public function isLoaded()
    {
        return !is_null($this->id);
    }


    //--------------------------------------
    // DB INTERFACE
    //--------------------------------------

    abstract public function loadById($id);

    abstract public function getIdKeyName();

    abstract public function update();

    abstract public function insert();

    abstract public function remove();

    abstract public function getNewId();
}
