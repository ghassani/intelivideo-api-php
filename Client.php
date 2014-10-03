<?php
/*
* This file is part of the Spliced IntelliVideo PHP API package.
*
* (c) Spliced Media <http://www.splicedmedia.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Spliced\IntelliVideo;

use Spliced\IntelliVideo\Exception\InvalidRequestException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ServerException as HttpServerException;
use JWT;

/**
 * 
 */ 
class Client 
{

    /** @var string base url endpoint to construct requests off - sprintf replaced client id*/
	protected $endpoint = 'https://api.intelivideo.com/api/ipn/std-jwt/%s/';

	/** @var string $key */
	protected $key;

    /** @var int $id */
	protected $id;
    
    /** @var HttpClient $httpClient */
    protected $httpClient;

    /** @var array $requestTypes */
    protected $requestTypes = array(
        'SaleRequest', 'Sale',
        'RefundRequest', 'Refund',
        'CancelRequest', 'Cancel'
    );

    /**
     * Constructor
     * 
     * @param int $clientId
     * @param string $secretKey
     */
	public function __construct($clientId, $secretKey, $endpoint = null)
	{
		$this->key = $secretKey;
		$this->id = $clientId;

        if (!is_null($endpoint)) {
            $this->endpoint = $endpoint;
        }

        $this->httpClient = new HttpClient();
	}

    /**
     * getKey
     * 
     * Returns the Client Secret Key
     * 
     * @return string
     */
	public function getKey()
	{
		return $this->key;
	}

    /**
     * getId
     * 
     * Returns the Client ID
     * 
     * @return int
     */
	public function getId()
	{
		return $this->id;
	}
    
    /**
     * getEndpoint
     * 
     * Returns the endpoint for the current client instance
     * 
     * @return string
     */
    public function getEndpoint()
    {
        return sprintf($this->endpoint, $this->getId());
    }

    /**
     * @param string $endpoint
     *
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }
    
    /**
     * createRequest
     * 
     * Helper method to create a request object
     * 
     * @param string $requestType
     */
	public function createRequest($requestType)
	{
        $class = 'Spliced\\IntelliVideo\\Request\\'.preg_replace('/Request$/','', $requestType).'Request';
        
        if (!in_array($requestType, $this->requestTypes)) {
            throw new \InvalidArgumentException(sprintf('Request Type %s Is Not A Valid Request Type', $requestType));
        } else if(!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Request Type %s Class Not Found', $requestType));
        }

        return new $class();
	}

    /**
     * @param Request\RequestInterface $request
     * @return Response\Response
     *
     * @throws \InvalidRequestException
     */
	public function doRequest(Request\RequestInterface $request)
	{
        $valid = $request->validate();

        if (true !== $valid) {
            throw new InvalidRequestException(sprintf('Passed Request Did Not Pass Validation. Error: %s', $valid), $request);
        }

        $httpRequest = $this->httpClient->createRequest('GET', $this->getEndpoint(), array());

        $httpRequest->getQuery()->set('payload', JWT::encode($request->toArray(), $this->getKey()));

        // Guzzle 4.x
        if ($this->httpClient instanceof \GuzzleHttp\Client) {
            try {
                $response = $this->httpClient->send($httpRequest);
            } catch (HttpServerException $e) {
                $response = $e->getResponse();
            }
        } else {
            $response = $httpRequest->send();
        }

        return new Response\Response($response);
    }
}