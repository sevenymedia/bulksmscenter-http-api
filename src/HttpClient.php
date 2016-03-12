<?php namespace BulkSmsCenter;

use BulkSmsCenter\Exceptions\HttpClientException;

class HttpClient
{
    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var array
     */
    protected $hosts = ['api.ek-media.nl',];

    /**
     * @var int
     */
    protected $port = 443;

    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var string
     */
    protected $rawResponse;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $apiResponse;

    /**
     * @var string
     */
    protected $userAgent;

    /**
     * @var int
     */
    protected $version = 1;

    public function auth()
    {
        return $this->auth;
    }

    /**
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
     * @return array
     */
    protected function hosts()
    {
        return $this->hosts;
    }

    /**
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
     * @return int
     */
    protected function port()
    {
        return $this->port === null ? $this->port = 443 : $this->port;
    }

    protected function protocol()
    {
        return $this->protocol === null ? $this->protocol = 'http'.($this->ssl() ? 's' : '') : $this->protocol;
    }

    protected function ssl()
    {
        return $this->port() === 443;
    }

    protected function version()
    {
        return $this->version;
    }

    protected function setRawResponse($rawResponse)
    {
        $this->rawResponse = $rawResponse;
    }

    protected function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    public function __construct(Auth $auth = null)
    {
        if ($auth !== null) {
            $this->setAuth($auth);
        }
    }

    /**
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

    public function runCommand($command,$data = [])
    {
        $data = array_merge($this->defaultPostParams(),[
            'command' => $command,
        ],$data);
        foreach ($this->hosts() as $host) {
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
            if ($response->getStatusCode() !== 200) {
                throw new HttpClientException("Did not receive '200 OK' from {$host}");
            }
            $this->setRawResponse($response->getBody()->getContents());
            return true;
        }
        return false;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    public function getApiResponse()
    {
        return $this->apiResponse ?: $this->apiResponse = $this->parseRawResponse();
    }
}
