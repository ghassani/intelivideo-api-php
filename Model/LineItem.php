<?php

namespace IntelliVideo\Model;

/**
 * Class LineItem
 *
 * @package IntelliVideo
 */
class LineItem implements RequestObject
{

    protected $sku;

    protected $price;

    /**
     * @param null $sku
     * @param null $price
     */
    public function __construct($sku = null, $price = null)
    {
        $this->sku = $sku;
        $this->price = $price;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return array(
            'sku' => $this->getSku(),
            'price' => ($this->getPrice() * 100), // in pennies
        );
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
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