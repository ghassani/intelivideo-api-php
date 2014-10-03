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


interface RequestInterface
{
    /**
     * validate
     *
     * Validates the request before building and processing the request.
     *
     * Returns true on valid state, string on error with error message
     *
     * @return bool|string
     */
	public function validate();

    /**
     * toArray
     *
     * @return array
     */
    public function toArray();

    /**
     * getEvent
     *
     * Returns the event name to send to the IntelliVideo API, i.e. sale, refund, cancel
     * @return string
     */
    public function getEvent();

}