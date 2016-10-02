<?php
/**
 * Class AuthorizationService
 *
 * @author Diego Wagner <diegowagner4@gmail.com>
 * http://www.discoverytecnologia.com.br
 */
namespace Dsc\MercadoLivre\Requests\Authorization;

use Dsc\MercadoLivre\BaseService;
use Dsc\MercadoLivre\Handler\OAuth2ClientHandler;
use Dsc\MercadoLivre\MeliException;
use Psr\Http\Message\StreamInterface;

/**
 * @author Diego Wagner <diegowagner4@gmail.com>
 */
class AuthorizationService extends BaseService
{
    /**
     * @param $region
     * @param null $redirectUri
     * @return StreamInterface
     */
    public function getAuthorizationCode($redirectUri = null)
    {
        $meli = $this->getMeli();
        $uri  = $meli->getEnvironment()->getWsAuth();
        $params = [
            'grant_type'   => 'code',
            'client_id'    => $meli->getClientId(),
            'redirect_uri' => $redirectUri
        ];

        $builder = new AuthorizationResponseBuilder(
            $this->get($uri, $params),
            $this->getSerializer()
        );
        return $builder->getResponse();
    }

    /**
     * @param string $code
     * @param null $redirectUrl
     * @return string
     * @throws MeliException
     */
    public function authorize($code, $redirectUri = null)
    {
        $meli = $this->getMeli();
        $uri  = $meli->getEnvironment()->getOAuthUri();
        $data = [
            'grant_type'    => 'authorization_code',
            'client_id'     => $meli->getClientId(),
            'client_secret' => $meli->getClientSecret(),
            'code'          => $code,
            'redirect_uri'  => $redirectUri
        ];

        $builder = new AuthorizationResponseBuilder(
            $this->post($uri, $data),
            $this->getSerializer()
        );

        $authorization = $builder->getResponse();

        $cache = $this->getMeli()->getEnvironment()->getConfiguration()->getCache();
        $cache->save(OAuth2ClientHandler::ACCESS_TOKEN, $authorization->getAccessToken());
        $cache->save(OAuth2ClientHandler::REFRESH_TOKEN, $authorization->getRefreshToken());
        $cache->save(OAuth2ClientHandler::EXPIRE_IN, time() + $authorization->getExpiresIn());

        return $authorization->getAccessToken();
    }
}