<?php

namespace Tallanto\ClientApiBundle\Api\Method;


interface TallantoMethodInterface
{
  /**
   * Returns URI of the method.
   *
   * @return string
   */
  public function getUri();

  /**
   * Returns method of this endpoint.
   *
   * @return string
   */
  public function getMethod();

  /**
   * Returns query parameters.
   *
   * @return array
   */
  public function getQueryParameters();

  /**
   * Returns array data to be sent in the body of the request as JSON.
   *
   * @return array|null
   */
  public function getJsonData();

  /**
   * Set raw response.
   *
   * @param \GuzzleHttp\Psr7\Response
   * @return mixed
   */
  public function setResponse($response);

  /**
   * Returns raw response.
   *
   * @return \GuzzleHttp\Psr7\Response
   */
  public function getResponse();

  /**
   * Returns useful result of operation.
   *
   * @return mixed
   */
  public function getResult();

  /**
   * Returns array of request headers.
   *
   * @return array|null
   */
  public function getRequestHeaders();
}