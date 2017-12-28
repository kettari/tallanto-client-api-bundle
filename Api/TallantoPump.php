<?php

namespace Tallanto\ClientApiBundle\Api;


use Tallanto\ClientApiBundle\Api\Method\PageableTallantoMethodInterface;
use Tallanto\ClientApiBundle\Api\Method\TallantoMethodInterface;
use Tallanto\ClientApiBundle\Exception\ResponseDecodeException;

class TallantoPump
{
  const MAX_PAGE_SIZE = 1000;

  /**
   * @var \Tallanto\ClientApiBundle\Api\TallantoApiClient
   */
  private $api;

  /**
   * @var \Tallanto\ClientApiBundle\Api\Method\TallantoMethodInterface
   */
  private $endpoint;

  /**
   * TallantoPump constructor.
   *
   * @param \Tallanto\ClientApiBundle\Api\TallantoApiClient $api
   * @param \Tallanto\ClientApiBundle\Api\Method\TallantoMethodInterface $endpoint
   */
  public function __construct(
    TallantoApiClient $api,
    TallantoMethodInterface $endpoint
  ) {
    $this->api = $api;
    $this->endpoint = $endpoint;
  }

  /**
   *  Retrieves all items from the server for this endpoint.
   *
   * @return array
   * @throws \Exception
   */
  public function suck()
  {
    if ($this->endpoint instanceof PageableTallantoMethodInterface) {
      $this->endpoint->setPageNumber(1)
        ->setPageSize(self::MAX_PAGE_SIZE);
    } else {
      throw new \Exception(
        'Tallanto pump works only with PageableTallantoMethodInterface endpoints.'
      );
    }

    // Initialize variable for return
    $totalResult = [];

    // Sucking cycle
    do {
      $suck = false;

      // Execute API and get the result
      $this->api->execute($this->endpoint);
      $result = $this->endpoint->getResult();

      if (is_array($result)) {
        // Merge result
        $totalResult = array_merge($totalResult, $result);
        if ($this->endpoint instanceof PageableTallantoMethodInterface) {

          // Decide if sucking complete
          $suck = (count($totalResult) !=
              $this->endpoint->getTotalItemsCount()) &&
            ($this->endpoint->getTotalItemsCount() > 0);
          if ($suck) {
            $this->endpoint->setPageNumber(
              $this->endpoint->getPageNumber() + 1
            );
          }

        }
      } else {
        throw new ResponseDecodeException(
          'Expected array, got '.gettype($result)
        );
      }
    } while ($suck);

    return $totalResult;
  }

}