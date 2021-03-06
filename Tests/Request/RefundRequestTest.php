<?php
/*
* This file is part of the Spliced IntelliVideo PHP API package.
*
* (c) Spliced Media <http://www.splicedmedia.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Spliced\IntelliVideo\Tests\Request;

use Spliced\IntelliVideo\Client;
use Spliced\IntelliVideo\Request\SaleRequest;
use Spliced\IntelliVideo\Request\RefundRequest;
use Spliced\IntelliVideo\Tests\MockDataTrait;
use Spliced\IntelliVideo\Tests\CredentialsTrait;
use Spliced\IntelliVideo\Model\Address;
use Spliced\IntelliVideo\Model\Product;
use Spliced\IntelliVideo\Model\LineItem;

/**
 *
 */
class RefundRequestTest extends \PHPUnit_Framework_TestCase
{
    use MockDataTrait;
    use CredentialsTrait;

    /**
     *
     */
    public function testFunctionality()
    {
        $request = new RefundRequest();

        // make sure object returns itself on sets
        $this->assertInstanceOf('Spliced\IntelliVideo\Request\RefundRequest', $request->setOrderId('order_id')
                ->setTimestamp('timestamp')
        );

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

        $request = $client->createRequest('RefundRequest');

        $this->assertInstanceOf('Spliced\IntelliVideo\Request\RefundRequest', $request);

        $request = $client->createRequest('Refund');

        $this->assertInstanceOf('Spliced\IntelliVideo\Request\RefundRequest', $request);

        // make sure object returns itself on sets
        $this->assertInstanceOf('Spliced\IntelliVideo\Request\RefundRequest', $request ->setOrderId('order_id')
                ->setTimestamp('timestamp')
        );

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
    public function testSaleAndRefund()
    {
        $client = new Client($this->clientId, $this->secretKey);

        $randomOrderId = rand(1000,10000);

        // first lets create a sale
        $saleRequest = $client->createRequest('Sale');

        $saleRequest->setFname('Gassan')
            ->setLname('Idriss')
            ->setEmail('gidriss@mivamerchant.com')
            ->setPhoneNumber('6192920984')
            ->setUserId('455')
            ->setOrderId($randomOrderId)
            ->setTimestamp(new \DateTime('now'));

        $saleRequest->setBillingAddress(new Address(
            '940 W San Marcos Blvd',
            'Std D',
            'San Marcos',
            'CA',
            '92078',
            'US'
        ));

        foreach( $this->testItems as $testItem) {
            $saleRequest->addLineItem(new LineItem($testItem, 29.99));
        }

        $saleResponse = $client->doRequest($saleRequest);

        $this->assertTrue($saleResponse->isSuccess());

        // now refund it
        $refundRequest = $client->createRequest('Refund');

        $refundRequest->setOrderId($randomOrderId)
            ->setTimestamp(new \DateTime('now'));

        foreach( $this->testItems as $testItem) {
            $refundRequest->addLineItem(new LineItem($testItem, 29.99));
        }

        $refundResponse = $client->doRequest($refundRequest);

        $this->assertTrue($refundResponse->isSuccess());
    }
}