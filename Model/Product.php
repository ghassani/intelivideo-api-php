<?php

namespace IntelliVideo\Model;


class Product implements RequestObject
{
    protected $sku;

    public function __construct($sku)
    {
        $this->sku = $sku;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return array('sku' => $this->getSku());
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }


} 