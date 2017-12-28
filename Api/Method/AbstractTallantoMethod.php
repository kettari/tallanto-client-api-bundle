<?php

namespace Tallanto\ClientApiBundle\Api\Method;


use GuzzleHttp\Psr7\Response;

abstract class AbstractTallantoMethod implements TallantoMethodInterface
{
  /**
   * @var boolean
   */
  protected $secured = false;

  /**
   * @var Response
   */
  protected $response;

  /**
   * @return bool
   */
  public function isSecured(): bool
  {
    return $this->secured;
  }

  /**
   * @return Response
   */
  public function getResponse()
  {
    return $this->response;
  }

  /**
   * @param Response $response
   * @return AbstractTallantoMethod
   */
  public function setResponse($response)
  {
    $this->response = $response;

    return $this;
  }

  /**
   * Returns array data to be sent in the body of the request as JSON.
   *
   * @return array|null
   */
  public function getJsonData()
  {
    return null;
  }

  /**
   * Returns query parameters.
   *
   * @return array
   */
  public function getQueryParameters()
  {
    return [];
  }

}