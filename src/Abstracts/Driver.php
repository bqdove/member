<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-06 03:31
 */
namespace Notadd\Member\Abstracts;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Container\Container;
use Notadd\Member\Exceptions\AuthorizeFailedException;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Driver.
 */
abstract class Driver
{
    /**
     * @var array
     */
    protected $configuration;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $scopes = [];

    /**
     * Driver constructor.
     *
     * @param array                                $configuration
     * @param \Illuminate\Container\Container|null $container
     */
    public function __construct(array $configuration, Container $container = null)
    {
        $this->configuration = $configuration;
        if (is_null($container)) {
            $this->container = Container::getInstance();
        } else {
            $this->container = $container;
        }
    }

    /**
     * @param $code
     *
     * @return mixed
     */
    public function getAccessToken($code)
    {
        $type = (version_compare(ClientInterface::VERSION, '6') === 1) ? 'form_params' : 'body';
        $response = (new Client(['http_errors' => false]))->post($this->getTokenUrl(), [
            'headers' => ['Accept' => 'application/json'],
            $type     => $this->getTokenFields($code),
        ]);

        return $this->parseAccessToken($response->getBody());
    }

    /**
     * @return string
     */
    abstract public function getTokenUrl();

    /**
     * @param $code
     *
     * @return array
     */
    protected function getTokenFields($code)
    {
        return [
            'client_id'     => $this->configuration['client_id'],
            'client_secret' => $this->configuration['client_secret'],
            'code'          => $code,
            'redirect_uri'  => $this->configuration['redirect_url'],
        ];
    }

    /**
     * @param $body
     *
     * @return mixed
     */
    protected function parseAccessToken($body)
    {
        if (!is_array($body)) {
            $body = json_decode($body, true);
        }

        if (empty($body['access_token'])) {
            throw new AuthorizeFailedException('Authorize Failed: ' . json_encode($body, JSON_UNESCAPED_UNICODE), $body);
        }

        return $body['access_token'];
    }

    /**
     * @param null $redirectUrl
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect($redirectUrl = null)
    {
        $state = null;
        if (!is_null($redirectUrl)) {
            $this->configuration['redirect_url'] = $redirectUrl;
        }
        if (!$this->configuration['stateless']) {
            $state = '';
        }

        return new RedirectResponse($this->getAuthUrl($state));
    }

    /**
     * @param $state
     *
     * @return string
     */
    abstract public function getAuthUrl($state);

    /**
     * @param string $clientId
     *
     * @return $this
     */
    public function withClientId(string $clientId)
    {
        $this->configuration['client_id'] = $clientId;

        return $this;
    }

    /**
     * @param string $clientSecret
     *
     * @return $this
     */
    public function withClientSecret(string $clientSecret)
    {
        $this->configuration['client_secret'] = $clientSecret;

        return $this;
    }

    /**
     * @param array $configuration
     *
     * @return $this
     */
    public function withConfiguration(array $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @param int $encodingType
     *
     * @return $this
     */
    public function withEncodingType(int $encodingType)
    {
        $this->configuration['encoding_type'] = $encodingType;

        return $this;
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function withParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $parameters;
    }

    /**
     * @param string $redirectUrl
     *
     * @return $this
     */
    public function withRedirectUrl(string $redirectUrl)
    {
        $this->configuration['redirect_url'] = $redirectUrl;

        return $this;
    }

    /**
     * @param array $scopes
     *
     * @return $this
     */
    public function withScopes(array $scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * @param string $separator
     *
     * @return $this
     */
    public function withScopeSeparator(string $separator)
    {
        $this->configuration['scope_separator'] = $separator;

        return $this;
    }

    /**
     * @param bool $state
     *
     * @return $this
     */
    public function withState(bool $state)
    {
        $this->configuration['stateless'] = !$state;

        return $this;
    }

    protected function buildAuthUrlFromBase($url, $state)
    {
        return $url . '?' . http_build_query($this->getCodeFields($state), '', '&', $this->configuration['encoding_type']);
    }

    /**
     * @param null $state
     *
     * @return array
     */
    protected function getCodeFields($state = null)
    {
        $fields = array_merge([
            'client_id'     => $this->configuration['client_id'],
            'redirect_uri'  => $this->configuration['redirect_url'],
            'scope'         => $this->formatScopes($this->scopes, $this->configuration['scope_separator']),
            'response_type' => 'code',
        ], $this->parameters);
        if (!$this->configuration['stateless']) {
            $fields['state'] = $state;
        }

        return $fields;
    }

    /**
     * @param array $scopes
     * @param       $scopeSeparator
     *
     * @return string
     */
    protected function formatScopes(array $scopes, $scopeSeparator)
    {
        return implode($scopeSeparator, $scopes);
    }
}
