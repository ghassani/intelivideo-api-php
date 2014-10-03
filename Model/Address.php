<?php

namespace IntelliVideo\Model;

class Address implements RequestObject
{
    protected $address;
    
    protected $address2;
    
    protected $city;
    
    protected $state;
    
    protected $zip;
    
    protected $country;

    /**
     * Constructor
     *
     * @param string|null $address
     * @param string|null $address2
     * @param string|null $city
     * @param string|null $state
     * @param string|null $zipcode
     * @param string|null $country*
     */
    public function __construct($address = null, $address2 = null, $city = null, $state = null, $zip = null, $country = null)
    {
        $this->address = $address;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->country = $country;
    }
    
    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return array(
            'address1' => $this->getAddress(),
            'address2' => $this->getAddress2(),
            'city' => $this->getCity(),
            'state' => $this->getState(),
            'zip' => $this->getZip(),
            'country' => $this->getCountry()
        );
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }
    
    
}
