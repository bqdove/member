<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-08 10:45
 */
namespace Notadd\Member;

use ArrayAccess;
use InvalidArgumentException;
use JsonSerializable;
use Notadd\Member\Contracts\AccessToken as AccessTokenContract;

/**
 * Class AccessToken.
 */
class AccessToken implements AccessTokenContract, ArrayAccess, JsonSerializable
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * AccessToken constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        if (empty($attributes['access_token'])) {
            throw new InvalidArgumentException('The key "access_token" could not be empty.');
        }

        $this->attributes = $attributes;
    }

    /**
     * Map the given array onto the user's properties.
     *
     * @param array $attributes
     *
     * @return $this
     */
    public function merge(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * Return the extra attribute.
     *
     * @param string $name
     * @param string $default
     *
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * Set extra attributes.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function __get($property)
    {
        return $this->getAttribute($property);
    }

    /**
     * Return array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getAttributes();
    }

    /**
     * Return the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Return JSON.
     *
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this->getAttributes(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->getAttribute('access_token', ''));
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getToken();
    }

    /**
     * Return the access token string.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->getAttribute('access_token');
    }
}
