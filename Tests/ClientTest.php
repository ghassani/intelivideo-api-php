<?php
/*
* This file is part of the Spliced IntelliVideo PHP API package.
*
* (c) Spliced Media <http://www.splicedmedia.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Spliced\IntelliVideo\Tests;

use Spliced\IntelliVideo\Client;

class ClientTest extends \PHPUnit_Framework_TestCase {


    public function testFunctionality()
    {
        $testId = 'ID';
        $testKey = 'KEY';
        $expectedEndpoint = 'https://api.intelivideo.com/api/ipn/std-jwt/'.$testId.'/';

        $client = new Client($testId, $testKey);

        $this->assertEquals($client->getId(), $testId);
        $this->assertEquals($client->getKey(), $testKey);
        $this->assertEquals($client->getEndpoint(), $expectedEndpoint);
    }


}
 