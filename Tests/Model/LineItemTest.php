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

use Spliced\IntelliVideo\Model\LineItem;

class LineItemTest extends \PHPUnit_Framework_TestCase
{

    public function testFunctionality()
    {
        $lineItem = new LineItem('foo', 29.99);

        $this->assertEquals($lineItem->getSku(), 'foo');
        $this->assertEquals($lineItem->getPrice(), 29.99);

        // test object returns itself on sets
        $this->assertInstanceOf('Spliced\IntelliVideo\Model\LineItem',$lineItem->setSku('bar')->setPrice(19.99));

        // test sets are successful
        $this->assertEquals($lineItem->getSku(), 'bar');
        $this->assertEquals($lineItem->getPrice(), 19.99);

    }
}
 