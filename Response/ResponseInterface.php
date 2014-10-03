<?php
/*
* This file is part of the Spliced IntelliVideo PHP API package.
*
* (c) Spliced Media <http://www.splicedmedia.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Spliced\IntelliVideo\Response;


interface ResponseInterface
{
    public function isSuccess();

    public function isError();

    public function getMessage();

    public function getStatusCode();

    public function getResponse();
}