<?php
/*
* This file is part of the Spliced IntelliVideo PHP API package.
*
* (c) Spliced Media <http://www.splicedmedia.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Spliced\IntelliVideo\Tests\Request\SaleRequest;

use Spliced\IntelliVideo\Client;
use Spliced\IntelliVideo\Model\Address;
use Spliced\IntelliVideo\Model\Product;
use Spliced\IntelliVideo\Model\LineItem;
use Spliced\IntelliVideo\Request\SaleRequest;
use Spliced\IntelliVideo\Tests\CredentialsTrait;
use Spliced\IntelliVideo\Tests\MockDataTrait;


class SaleRequestTest extends \PHPUnit_Framework_TestCase
{

    use CredentialsTrait;
    use MockDataTrait;

    /**
     *
     */
    public function testFunctionality()
    {
        $request = new SaleRequest();

        // make sure object returns itself on sets
        $this->assertInstanceOf('Spliced\IntelliVideo\Request\SaleRequest', $request->setFname('fname')
                ->setLname('lname')
                ->setEmail('email')
                ->setPhoneNumber('phone_number')
                ->setUserId('user_id')
                ->setOrderId('order_id')
                ->setTimestamp('timestamp')
        );

        $this->assertEquals($request->getFname(), 'fname');
        $this->assertEquals($request->getLname(), 'lname');
        $this->assertEquals($request->getEmail(), 'email');
        $this->assertEquals($request->getPhoneNumber(), 'phone_number');
        $this->assertEquals($request->getUserId(), 'user_id');
        $this->assertEquals($request->getOrderId(), 'order_id');
        $this->assertEquals($request->getTimestamp(), 'timestamp');

        $request->addLineItem(new LineItem('bar', 29.99));

        $this->assertEquals(count($request->getLineItems()), 1);

        foreach($request->getLineItems() as $lineItem) {
            $this->assertInstanceOf('Spliced\IntelliVideo\Model\LineItem', $lineItem);
        }

        $request->addProduct(new Product('bar'));

        $this->assertEquals(count($request->getProducts()), 1);

        foreach($request->getProducts() as $product) {
            $this->assertInstanceOf('Spliced\IntelliVideo\Model\Product', $product);
        }
    }

    /**
     *
     */
    public function testClientFactory()
    {
        $client = new Client($this->clientId, $this->secretKey);

        $request = $client->createRequest('SaleRequest');

        $this->assertInstanceOf('Spliced\IntelliVideo\Request\SaleRequest', $request);

        $request = $client->createRequest('Sale');

        $this->assertInstanceOf('Spliced\IntelliVideo\Request\SaleRequest', $request);


        // make sure object returns itself on sets
        $this->assertInstanceOf('Spliced\IntelliVideo\Request\SaleRequest', $request->setFname('fname')
            ->setLname('lname')
            ->setEmail('email')
            ->setPhoneNumber('phone_number')
            ->setUserId('user_id')
            ->setOrderId('order_id')
            ->setTimestamp('timestamp')
        );


        $this->assertEquals($request->getFname(), 'fname');
        $this->assertEquals($request->getLname(), 'lname');
        $this->assertEquals($request->getEmail(), 'email');
        $this->assertEquals($request->getPhoneNumber(), 'phone_number');
        $this->assertEquals($request->getUserId(), 'user_id');
        $this->assertEquals($request->getOrderId(), 'order_id');
        $this->assertEquals($request->getTimestamp(), 'timestamp');

        $request->addLineItem(new LineItem('bar', 29.99));

        $this->assertEquals(count($request->getLineItems()), 1);

        foreach($request->getLineItems() as $lineItem) {
            $this->assertInstanceOf('Spliced\IntelliVideo\Model\LineItem', $lineItem);
        }

        $request->addProduct(new Product('bar'));

        $this->assertEquals(count($request->getProducts()), 1);

        foreach($request->getProducts() as $product) {
            $this->assertInstanceOf('Spliced\IntelliVideo\Model\Product', $product);
        }
    }

    /**
     *
     */
    public function testRequest()
    {
        // test a sale request with a randomly generated request
        $client = new Client($this->clientId, $this->secretKey);

        $request = $client->createRequest('SaleRequest');

        // mock order
        $mockOrder = static::createMockOrder();

        $request->setFname($mockOrder['fname'])
            ->setLname($mockOrder['lname'])
            ->setEmail($mockOrder['email'])
            ->setPhoneNumber($mockOrder['phone_number'])
            ->setUserId($mockOrder['user_id'])
            ->setOrderId($mockOrder['order_id'])
            ->setTimestamp($mockOrder['timestamp']);

        $billingAddress = new Address(
            $mockOrder['billing_address']['address'],
            $mockOrder['billing_address']['address2'],
            $mockOrder['billing_address']['city'],
            $mockOrder['billing_address']['state'],
            $mockOrder['billing_address']['zip'],
            $mockOrder['billing_address']['country']
        );

        $request->setBillingAddress($billingAddress);

        if(isset($mockOrder['shipping_address']) && count($mockOrder['shipping_address'])) {
            $shippingAddress = new Address(
                $mockOrder['shipping_address']['address'],
                $mockOrder['shipping_address']['address2'],
                $mockOrder['shipping_address']['city'],
                $mockOrder['shipping_address']['state'],
                $mockOrder['shipping_address']['zip'],
                $mockOrder['shipping_address']['country']
            );

            $request->setShippingAddress($shippingAddress);
        }

        if(isset($mockOrder['products']) && count($mockOrder['products'])) {
            foreach($mockOrder['products'] as $sku) {
                $request->addProduct(new Product($sku));
            }
        }

        if(isset($mockOrder['line_items']) && count($mockOrder['line_items'])) {
            foreach($mockOrder['line_items'] as $lineItem) {
                $request->addLineItem(new LineItem($lineItem['sku'], $lineItem['price']));
            }
        }

        $response = $client->doRequest($request);

        $this->assertTrue($response->isSuccess());

    }

}
 