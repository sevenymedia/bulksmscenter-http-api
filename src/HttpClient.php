<?php namespace BulkSmsCenter;

use BulkSmsCenter\Exceptions\HttpClientException;

/**
 * Class HttpClient
 *
 * @package sevenymedia/bulksmscenter-http-api
 */
class HttpClient
{
    /**
     * Will contain an instance of Auth which will be used to authenticate to the API
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Contains one or more API hosts
     *
     * @var array
     */
    protected $hosts = ['api.ek-media.nl',];

    /**
     * Contains the port which will be used to connect to the API
     *
     * @var int
     */
    protected $port = 443;

    /**
     * Will contain the protocol (http/https) which will be used to connect to the API
     *
     * @var string
     */
    protected $protocol;

    /**
     * Will contain the plain API response after a request has been executed
     *
     * @var string
     */
    protected $rawResponse;

    /**
     * Will contain an instance of Guzzle response
     *
     * @var Response
     */
    protected $response;

    /**
     * Will contain parsed API response
     *
     * @var array
     */
    protected $apiResponse;

    /**
     * Will contain the user agent string which will be send when connecting to the API
     *
     * @var string
     */
    protected $userAgent;

    /**
     * Contains the API version
     *
     * @var int
     */
    protected $version = 1;

    /**
     * Returns the Auth instance
     *
     * @return Auth
     */
    public function auth()
    {
        return $this->auth;
    }

    /**
     * Returns an array containing some post data required in all API requests
     *
     * @return array
     */
    protected function defaultPostParams()
    {
        return [
            'password' => $this->auth()->getPassword(),
            'username' => $this->auth()->getUsername(),
            'version' => $this->version(),
        ];
    }

    /**
     * Parse the raw API response
     *
     * @param string|null $rawResponse
     *
     * @return array
     */
    protected function parseRawResponse($rawResponse = null)
    {
        $response = [];
        foreach (explode("\n",$rawResponse !== null ? $rawResponse : $this->getRawResponse()) as $line) {
            list($name,$value) = explode('=',$line);
            switch ($name = trim($name)) {
                case 'APIsmsID':
                    break;
                default:
                    $value = (is_numeric($value = trim($value)) ? $value += 0 : $value);
                    break;
            }
            $response[$name] = $value;
        }
        return $response;
    }

    /**
     * Returns the port to use to connect to the API
     *
     * @return int
     */
    protected function port()
    {
        return $this->port === null ? $this->port = 443 : $this->port;
    }

    /**
     * Returns the protocol to use to connect to the API
     *
     * @return string
     */
    protected function protocol()
    {
        return $this->protocol === null ? $this->protocol = 'http'.($this->ssl() ? 's' : '') : $this->protocol;
    }

    /**
     * Returns if SSL should be used
     *
     * @return bool
     */
    protected function ssl()
    {
        return $this->port() === 443;
    }

    /**
     * Returns the API version to use in requests
     *
     * @return int
     */
    protected function version()
    {
        return $this->version;
    }

    /**
     * Save API raw response
     *
     * @param $rawResponse
     */
    protected function setRawResponse($rawResponse)
    {
        $this->rawResponse = $rawResponse;
    }

    /**
     * Save parsed API response
     *
     * @param $response
     *
     * @return $this
     */
    protected function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * HttpClient constructor.
     *
     * @param Auth|null $auth
     */
    public function __construct(Auth $auth = null)
    {
        if ($auth !== null) {
            $this->setAuth($auth);
        }
    }

    /**
     * Set Auth object to use for requests
     *
     * @param Auth $auth
     *
     * @return $this
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * Returns the API hosts
     *
     * @return array
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * Save API hosts to use for requests
     *
     * @param $hosts
     *
     * @return $this
     */
    public function setHosts($hosts)
    {
        $this->hosts = $hosts;
        return $this;
    }

    /**
     * Add a host (or multiple hosts) to API hosts
     *
     * @param $hosts
     *
     * @return $this
     */
    public function addHosts($hosts)
    {
        if (!is_array($hosts)) {
            $hosts = [$hosts,];
        }
        $this->hosts = array_merge($this->hosts,$hosts);
        return $this;
    }

    /**
     * Set user agent to use in requests
     *
     * @param string|array $userAgent
     *
     * @return $this
     */
    public function setUserAgent($userAgent)
    {
        if (is_array($userAgent)) {
            $userAgent = implode(' ',$userAgent);
        }
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * Execute a request
     *
     * @param $command
     * @param array $data
     *
     * @return bool
     * @throws HttpClientException
     */
    public function runCommand($command,$data = [])
    {
        $data = array_merge($this->defaultPostParams(),[
            'command' => $command,
        ],$data);
        foreach ($this->getHosts() as $host) {
            $client = new \GuzzleHttp\Client();

            if (method_exists($client,'request')) {
                // Guzzle 6
                $response = $client->request('GET',"{$this->protocol()}://{$host}",[
                    'query' => $data,
                    'verify' => false,
                ]);
            } else {
                // Guzzle 5
                $response = $client->send($client->createRequest('GET',"{$this->protocol()}://{$host}",[
                    'query' => $data,
                    'verify' => false,
                ]));
            }

            $response = $this->setResponse($response)->getResponse();
            if (($code = $response->getStatusCode()) !== 200) {
                throw new HttpClientException(
                    sprintf(HttpClientException::MESSAGE__NO_OK_RECEIVED,$code,$host),
                    HttpClientException::CODE__NO_OK_RECEIVED
                );
            }
            $this->setRawResponse($response->getBody()->getContents());
            return true;
        }
        return false;
    }

    /**
     * Returns Guzzle response object
     *
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Returns raw API response
     *
     * @return string
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * Returns parsed API response
     *
     * @return array
     */
    public function getApiResponse()
    {
        return $this->apiResponse ?: $this->apiResponse = $this->parseRawResponse();
    }
}
