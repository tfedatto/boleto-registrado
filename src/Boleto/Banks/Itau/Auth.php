<?php
/**
 * Created by PhpStorm.
 * User: tiago_fedatto
 * Date: 02/04/18
 * Time: 15:32
 */

namespace Boleto\Banks\Itau;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Cache\Simple\FilesystemCache;

class Auth
{
    private $token;
    private $url;
    private $client_id;
    private $cliente_secret;
    private $environment;
    private $ttl;

    private $cache;


    public function __construct()
    {
        $this->cache = new FilesystemCache();
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     * @return mixed
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return mixed
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     * @return mixed
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClienteSecret()
    {
        return $this->cliente_secret;
    }

    /**
     * @param mixed $cliente_secret
     * @return mixed
     */
    public function setClienteSecret($cliente_secret)
    {
        $this->cliente_secret = $cliente_secret;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param mixed $environment
     * @return mixed
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param mixed $ttl
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }


    /**
     * @param mixed $config
     * @return mixed
     */
    public function setConfig($config){
        $this->setEnvironment($config['tipo_ambiente'])
            ->setClienteSecret($config['client_secret'])
            ->setClientId($config['client_id']);

        $url = 'https://oauth.itau.com.br/identity/connect/token';

        if($config['tipo_ambiente'] == 2){
            $url = 'https://autorizador-boletos.itau.com.br';
        }

        $this->setUrl($url);

        return $this;
    }

    private function setCache(){
        $this->cache->set('token', self::getToken(), self::getTtl());
        return $this;
    }

    private function getCache(){
        return $this->cache->get('token');
    }

    /**
     * @return array
     */
    public function requestToken(){
        try{

            if(self::getCache()){
                return self::getCache();
            }

            $client = new Client();

            $response = $client->post($this->getUrl(), [
                'form_params' => [
                    'scope' => 'readonly',
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->getClientId(),
                    'client_secret' => $this->getClienteSecret()
                ]
            ]);

            if($response->getStatusCode() != 200){
                throw new Exception('O Token não foi gerado!');
            }

            $response = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
            $this->setToken($response['access_token'])
                ->setTtl($response['expires_in'])
                ->setCache();

            return self::getToken();

        }catch (RequestException $e){
            echo $e->getMessage() . "\n";
            echo $e->getRequest()->getMethod();
        }catch (Exception $e){
            echo $e;
        }
    }
}