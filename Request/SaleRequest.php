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

class SaleRequest implements RequestInterface
{

    const EVENT = 'sale';

    protected $fname;

    protected $lname;

    protected $email;

    protected $phoneNumber;

    protected $userId;

    protected $orderId;

    protected $timestamp;

    protected $billingAddress;

    protected $shippingAddress;

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

        if (!$this->getEmail()) {
            return 'Email Address is Required';
        }

        if($this->getUserId() && !is_numeric($this->getUserId())) {
            return 'If User ID is provided, it must be an integer.';
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
            'fname' => $this->getFname(),
            'lname' => $this->getLname(),
            'email' => $this->getEmail(),
            'phone_number' => $this->getPhoneNumber(),
            'order_id' => $this->getOrderId()
        );

        if ($this->getTimestamp() instanceof \DateTime) {
            $jsonArray['timestamp'] = $this->getTimestamp()->getTimestamp();
        } else {
            $jsonArray['timestamp'] = $this->getTimestamp();
        }

        if ($this->getUserId()) {
            $jsonArray['user_id'] = $this->getUserId();
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

        if ($this->getBillingAddress()) {
            $jsonArray['billing_address'] = $this->getBillingAddress()->toArray();
        }

        if ($this->getShippingAddress()) {
            $jsonArray['shipping_address'] = $this->getShippingAddress()->toArray();
        } else {
            $jsonArray['shipping_address_same_as_billing'] = true;
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
     * @return Model\Address | null
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param mixed $billingAddress
     */
    public function setBillingAddress(Model\Address $billingAddress = null)
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * @param mixed $fname
     */
    public function setFname($fname)
    {
        $this->fname = $fname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * @param mixed $lname
     */
    public function setLname($lname)
    {
        $this->lname = $lname;
        return $this;
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
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param mixed $shippingAddress
     */
    public function setShippingAddress(Model\Address $shippingAddress = null)
    {
        $this->shippingAddress = $shippingAddress;
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
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
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