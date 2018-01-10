<?php

namespace Tallanto\ClientApiBundle\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Tallanto\ClientApiBundle\Api\Method\AbstractSecuredTallantoMethod;
use Tallanto\ClientApiBundle\Api\Method\PageableTallantoMethodInterface;
use Tallanto\ClientApiBundle\Api\Method\TallantoMethodInterface;
use Tallanto\ClientApiBundle\Exception\TransportTallantoException;

class TallantoApiClient
{
  /**
   * @var Client
   */
  private $client;

  /**
   * @var LoggerInterface
   */
  private $logger;

  /**
   * TallantoApiClient constructor.
   *
   * @param \GuzzleHttp\Client $client
   * @param \Psr\Log\LoggerInterface|null $logger
   */
  public function __construct(Client $client, LoggerInterface $logger = null)
  {
    $this->client = $client;
    $this->logger = is_null($logger) ? new NullLogger() : $logger;
  }

  /**
   * Executes API method.
   *
   * @param \Tallanto\ClientApiBundle\Api\Method\TallantoMethodInterface $method
   * @throws \Tallanto\ClientApiBundle\Exception\TransportTallantoException
   */
  public function execute(TallantoMethodInterface $method)
  {
    // Build options
    $options = [];
    // Is endpoint secured?
    if ($method instanceof AbstractSecuredTallantoMethod) {
      if ($method->isSecured()) {
        $options['auth'] = [$method->getLogin(), $method->getPassword()];
      }
    }
    // Should we supply JSON data in the body?
    if (!is_null($jsonData = $method->getJsonData())) {
      $options['json'] = $jsonData;
    }
    // Get query parameters
    $options['query'] = $method->getQueryParameters();
    // Get request headers
    $options['headers'] = $method->getRequestHeaders();

    // Does endpoint pageable?
    if ($method instanceof PageableTallantoMethodInterface) {
      $options['query']['total_count'] = 'true';
      $options['query']['page_size'] = $method->getPageSize();
      $options['query']['page_number'] = $method->getPageNumber();
    }

    $this->logger->debug(
      'Performing Guzzle {method} request to {uri}',
      [
        'method'  => $method->getMethod(),
        'uri'     => $method->getUri(),
        'options' => $options,
      ]
    );

    // Make request
    try {
      $response = $this->getClient()
        ->request(
          $method->getMethod(),
          $method->getUri(),
          $options
        );
    } catch (RequestException $e) {
      throw new TransportTallantoException(
        'Guzzle request failed: '.$e->getResponse()
          ->getBody()
          ->getContents(), 0, $e
      );
    } catch (\Exception $e) {
      throw new TransportTallantoException('Guzzle request failed.', 0, $e);
    }
    // Assign response
    $method->setResponse($response);
  }

  /**
   * @return Client
   */
  public function getClient(): Client
  {
    return $this->client;
  }

}