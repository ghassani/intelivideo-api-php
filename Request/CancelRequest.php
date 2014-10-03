<?php
/*
* This file is part of the Spliced IntelliVideo PHP API package.
*
* (c) Spliced Media <http://www.splicedmedia.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Spliced\IntelliVideo\Request;

use Spliced\IntelliVideo\Model;

class CancelRequest implements RequestInterface
{

    const EVENT = 'cancel';

    protected $orderId;

    protected $timestamp;

    protected $products = array();

    protected $lineItems = array();

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        if (!$this->getOrderId()) {
            return 'Order ID must be provided';
        }

        if (!$this->getTimestamp()) {
            return 'Order Timestamp must be provided as Unix Time or DateTime Object';
        }

        if (!$this->getProducts() && !$this->getLineItems()) {
            return 'Either Products or Line Items must be provided';
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        $jsonArray = array(
            'event' => $this->getEvent(),
            'order_id' => $this->getOrderId()
        );

        if ($this->getTimestamp() instanceof \DateTime) {
            $jsonArray['timestamp'] = $this->getTimestamp()->getTimestamp();
        } else {
            $jsonArray['timestamp'] = $this->getTimestamp();
        }


        if ($this->getLineItems()) {

            $jsonArray['line_items'] = array();

            foreach ($this->getLineItems() as $lineItem) {
                $jsonArray['line_items'][] = $lineItem->toArray();
            }

        } elseif ($this->getProducts()) {
            $jsonArray['products'] = array();

            foreach ($this->getProducts() as $product) {
                $jsonArray['products'][] = $product->getSku();
            }
        }

        return $jsonArray;
    }

    /**
     * {@inheritDoc}
     */
    public function getEvent()
    {
        return static::EVENT;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }


    /**
     * @return array
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * @param array $lineItems
     */
    public function setLineItems(array $lineItems)
    {
        foreach($lineItems as $lineItem) {
            if (!$lineItem instanceof Model\LineItem) {
                throw new \InvalidArgumentException(sprintf('setLineItems requires an array of LineItem, %s given',
                    is_object($lineItem) ? get_class($lineItem) : gettype($lineItem)
                ));
            }
        }
        $this->lineItems = $lineItems;
        return $this;
    }

    /**
     * @param Model\LineItem $lineItem
     * @return $this
     */
    public function addLineItem(Model\LineItem $lineItem)
    {
        $this->lineItems[] = $lineItem;
        return $this;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }

    public function addProduct(Model\Product $product)
    {
        $this->products[] = $product;
        return $this;
    }

}