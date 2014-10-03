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

use Spliced\IntelliVideo\Model\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{

    public function testFunctionality()
    {
        $address = new Address(
            'address',
            'address2',
            'city',
            'state',
            'zip',
            'country'
        );

        $this->assertEquals($address->getAddress(), 'address');
        $this->assertEquals($address->getAddress2(), 'address2');
        $this->assertEquals($address->getCity(), 'city');
        $this->assertEquals($address->getState(), 'state');
        $this->assertEquals($address->getZip(), 'zip');
        $this->assertEquals($address->getCountry(), 'country');

        // test object returns itself on sets
        $this->assertInstanceOf(
            'Spliced\IntelliVideo\Model\Address',
            $address->setAddress('address_alt')
                ->setAddress2('address2_alt')
                ->setCity('city_alt')
                ->setState('state_alt')
                ->setZip('zip_alt')
                ->setCountry('country_alt')
        );

        // test sets are successful
        $this->assertEquals($address->getAddress(), 'address_alt');
        $this->assertEquals($address->getAddress2(), 'address2_alt');
        $this->assertEquals($address->getCity(), 'city_alt');
        $this->assertEquals($address->getState(), 'state_alt');
        $this->assertEquals($address->getZip(), 'zip_alt');
        $this->assertEquals($address->getCountry(), 'country_alt');

    }
}
 