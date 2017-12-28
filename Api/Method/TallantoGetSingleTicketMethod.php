<?php
/**
 * Created by PhpStorm.
 * User: ant
 * Date: 07.09.2017
 * Time: 21:06
 */

namespace Tallanto\ClientApiBundle\Api\Method;

use Tallanto\Api\Entity\Ticket;
use Tallanto\ClientApiBundle\Exception\ResponseDecodeException;

class TallantoGetSingleTicketMethod extends AbstractCollectionTallantoMethod
{
  /**
   * @var string
   */
  private $ticketId;

  /**
   * TallantoGetSingleTicketMethod constructor.
   *
   * @param string $ticketId
   */
  public function __construct($ticketId)
  {
    $this->ticketId = $ticketId;
  }

  /**
   * Returns URI of the method.
   *
   * @return string
   */
  public function getUri()
  {
    return sprintf('/api/v1/tickets/%s', $this->ticketId);
  }

  /**
   * Returns method of this endpoint.
   *
   * @return string
   */
  public function getMethod()
  {
    return 'GET';
  }

  /**
   * Returns useful result of operation.
   *
   * @return \Tallanto\Api\Entity\Ticket
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

    return new Ticket($singleItem);
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