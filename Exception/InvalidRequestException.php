<?php
/*
/*
* This file is part of the Spliced IntelliVideo PHP API package.
*
* (c) Spliced Media <http://www.splicedmedia.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Spliced\IntelliVideo\Exception;

use Spliced\IntelliVideo\Request\RequestInterface;

/**
 * Class InvalidRequestException
 *
 * @package IntelliVideo
 */
class InvalidRequestException extends \Exception
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param null $message
     * @param RequestInterface $request
     */
    public function __construct ($message = null, RequestInterface $request = null )
    {
        $this->request = $request;
        parent::__construct($message);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     * @return $this
     */
    public function setRequest(RequestInterface $request = null)
    {
        $this->request = $request;
        return $this;
    }

}