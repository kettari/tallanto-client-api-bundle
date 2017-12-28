<?php

namespace Tallanto\ClientApiBundle\Api\Method;


use Symfony\Component\HttpFoundation\Response;
use Tallanto\ClientApiBundle\Exception\ResponseDecodeException;

abstract class AbstractCollectionTallantoMethod extends AbstractSecuredTallantoMethod implements PageableTallantoMethodInterface
{
  use PageableTrait;

  /**
   * Returns items.
   *
   * @return array
   * @throws \Tallanto\ClientApiBundle\Exception\ResponseDecodeException
   */
  public function getResult()
  {
    // HTTP 204
    if (Response::HTTP_NO_CONTENT == $this->getResponse()
        ->getStatusCode()) {
      return [];
    }

    // Get content
    $contents = $this->getResponse()
      ->getBody()
      ->getContents();
    if (empty($contents)) {
      throw new ResponseDecodeException(
        'Body contents is empty with HTTP code '.$this->getResponse()
          ->getStatusCode()
      );
    }

    // Decode to JSON
    $items = json_decode($contents, true);
    if (JSON_ERROR_NONE != json_last_error()) {
      throw new ResponseDecodeException('JSON error: '.json_last_error_msg());
    }

    return $items;
  }

  /**
   * @var integer
   * @return int
   */
  public function getTotalItemsCount()
  {
    if ($this->getResponse()) {
      $headers = $this->getResponse()
        ->getHeader('X-Total-Count');
      return $headers[0] ?? 0;
    } else {
      return 0;
    }
  }


}