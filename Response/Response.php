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

class Response implements ResponseInterface
{
    protected $response;

    protected $responseContent;

    public function __construct($httpResponse)
    {
        $this->response = $httpResponse;

        $this->responseContent = $httpResponse->getBody()->getContents();
    }

    public function isSuccess()
    {
        return $this->response->getStatusCode() == 200;
    }

    public function isError()
    {
        return $this->response->getStatusCode() != 200;
    }

    public function getMessage()
    {
        return $this->responseContent;
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseContent()
    {
        return $this->responseContent;
    }

} 