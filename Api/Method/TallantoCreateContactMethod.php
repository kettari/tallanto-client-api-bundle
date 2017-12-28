<?php

namespace Tallanto\ClientApiBundle\Api\Method;

use Tallanto\Api\Entity\Contact;
use Tallanto\ClientApiBundle\Exception\ResponseDecodeException;

class TallantoCreateContactMethod extends AbstractSecuredTallantoMethod
{
  /**
   * @var Contact
   */
  private $contact;

  /**
   * TallantoCreateContactMethod constructor.
   *
   * @param Contact $ticket
   */
  public function __construct($ticket)
  {
    $this->contact = $ticket;
  }

  /**
   * Returns URI of the method.
   *
   * @return string
   */
  public function getUri()
  {
    return '/api/v1/contacts';
  }

  /**
   * Returns method of this endpoint.
   *
   * @return string
   */
  public function getMethod()
  {
    return 'POST';
  }

  /**
   * Returns array data to be sent in the body of the request as JSON.
   *
   * @return array|null
   */
  public function getJsonData()
  {
    return $this->contact->toArray();
  }

  /**
   * Returns useful result of operation.
   *
   * @return \Tallanto\Api\Entity\Contact
   * @throws \Tallanto\ClientApiBundle\Exception\ResponseDecodeException
   */
  public function getResult()
  {
    $arrayData = $this->decode(
      $this->getResponse()
        ->getBody()
        ->getContents()
    );
    if (is_array($arrayData) && count($arrayData)) {
      $singleItem = reset($arrayData);
    } else {
      throw new ResponseDecodeException('Response has bad format.');
    }

    return new Contact($singleItem);
  }

  /**
   * Parses and validates request parameters.
   *
   * @param $json
   * @return array
   * @throws \Tallanto\ClientApiBundle\Exception\ResponseDecodeException
   */
  private function decode($json)
  {
    $decodedResult = json_decode($json, true);
    if (JSON_ERROR_NONE != json_last_error()) {
      throw new ResponseDecodeException('JSON error: '.json_last_error_msg());
    }

    return $decodedResult;
  }
}