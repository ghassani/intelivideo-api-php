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


trait MockDataTrait {

    public static $mockFirstNames = array(
        'John',
        'Joseph',
        'Mary',
        'Mark'
    );

    public static $mockLastNames = array(
        'Thompson',
        'Johnson',
        'McDoodleson',
        'McGruber'
    );


    public static $mockPhoneNumbers = array(
        '6191231234',
        '7601231234',
        '8581231234',
    );

    public static $mockEmailAddresses = array(
        'test@test.com',
        'bar@foo.com',
        'foo@baz.com'
    );

    public static $mockPrices = array(
        9.99, 19.99, 29.99, 39.99
    );

    public static $mockAddresses = array(
        array('address' => '123 Test St', 'address2' => '', 'city' => 'San Diego', 'state' => 'CA', 'zip' => '92009', 'country' => 'US'),
        array('address' => '456 Test St', 'address2' => 'Apt 1', 'city' => 'San Fransisco', 'state' => 'CA', 'zip' => '92010', 'country' => 'US'),
        array('address' => '789 Test St', 'address2' => 'Apt C', 'city' => 'San Juan Capistrano', 'state' => 'CA', 'zip' => '92011', 'country' => 'US'),
        array('address' => '811 Test St', 'address2' => 'Apt H', 'city' => 'Santa Barbara', 'state' => 'CA', 'zip' => '92012', 'country' => 'US'),
    );

    public static $mockItems = array(20000074, 20000152, 20000018);

    /**
     * createMockOrder
     *
     * Creates an array of randomly generated data from static variables declared above
     *
     * @return array
     */
    public static function createMockOrder()
    {
        $shippingSameAsBilling = rand(0,1);
        $hasUser = rand(0,1);
        $useLineItems = rand(0,1);
        $useDateTime = rand(0,1);

        $return = array(
            'fname' => static::$mockFirstNames[array_rand(static::$mockFirstNames)],
            'lname' => static::$mockLastNames[array_rand(static::$mockLastNames)],
            'phone_number' => static::$mockPhoneNumbers[array_rand(static::$mockPhoneNumbers)],
            'email' => static::$mockEmailAddresses[array_rand(static::$mockEmailAddresses)],
            'order_id' => rand(1000,10000),
            'user_id' => $hasUser ? rand(500,8000) : null,
            'billing_address' => static::$mockAddresses[array_rand(static::$mockAddresses)],
            'timestamp' => $useDateTime ? new \DateTime('now') : time()
        );

        if(!$shippingSameAsBilling) {
            $return['shipping_address'] = static::$mockAddresses[array_rand(static::$mockAddresses)];
        }

        $return[$useLineItems ? 'line_items' : 'products'] = array();

        foreach (static::$mockItems as $mockItem) {
            if ($useLineItems) {
                $return['line_items'][] = array('sku' => $mockItem, 'price' => static::$mockPrices[array_rand(static::$mockPrices)]);
            } else {
                $return['products'][] = $mockItem;
            }
        }


        return $return;
    }

} 