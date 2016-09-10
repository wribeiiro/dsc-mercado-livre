<?php
namespace Dsc\MercadoLivre;

use Psr\Http\Message\StreamInterface;

/**
 * @author Diego Wagner <diegowagner4@gmail.com>
 */
abstract class Service
{
    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Credentials $credentials
     * @param Client $client
     */
    public function __construct(Credentials $credentials, Client $client = null)
    {
        $this->credentials = $credentials;
        $this->client      = $client ?: new Client();
    }

    /**
     * @return Credentials
     */
    protected function getCredential()
    {
        return $this->credentials;
    }

    /**
     * @return Environment
     */
    protected function getEnvironment()
    {
        return $this->credentials->getEnvironment();
    }

    /**
     * @param $url
     * @param array $params
     * @throws MeliException
     */
    protected function get($url, array $params = [])
    {
        try {
            $response = $this->client->get($url, $params);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            }
        } catch(MeliException $me) {
            throw $me;
        }
    }

    /**
     * @param string $url
     * @param array $params
     * @return StreamInterface
     * @throws MeliException
     */
    protected function post($url, array $params)
    {
        try {
            $response = $this->client->post($url, $params);
            if($response->getStatusCode() == 200) {
                return $response->getBody();
            }
        } catch(MeliException $me) {
            throw $me;
        }
    }

    /**
     * @param $url
     * @param array $params
     */
    protected function put($url, array $params)
    {
        // TODO: Implement put() method.
    }

    /**
     * @param $url
     * @param array $params
     */
    protected function delete($url, array $params)
    {
        // TODO: Implement delete() method.
    }
}