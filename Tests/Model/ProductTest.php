<?php
/*
* This file is part of the Spliced IntelliVideo PHP API package.
*
* (c) Spliced Media <http://www.splicedmedia.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Spliced\IntelliVideo\Test\Model;

use Spliced\IntelliVideo\Model\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{

    public function testFunctionality()
    {
        $product = new Product('foo');

        $this->assertEquals($product->getSku(), 'foo');

        // test object returns itself on sets
        $this->assertInstanceOf('Spliced\IntelliVideo\Model\Product',$product->setSku('bar'));

        // test sets are successful
        $this->assertEquals($product->getSku(), 'bar');

    }
}
 