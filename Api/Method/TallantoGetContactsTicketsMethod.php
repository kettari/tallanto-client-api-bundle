<?php
/**
 * Created by PhpStorm.
 * User: ant
 * Date: 07.09.2017
 * Time: 21:06
 */

namespace Tallanto\ClientApiBundle\Api\Method;

use Tallanto\Api\Entity\Ticket;

class TallantoGetContactsTicketsMethod extends AbstractCollectionTallantoMethod
{
  /**
   * @var string
   */
  private $contactId;

  /**
   * TallantoGetContactsTicketsMethod constructor.
   *
   * @param string $contactId
   */
  public function __construct(string $contactId)
  {
    $this->contactId = $contactId;
  }

  /**
   * Returns URI of the method.
   *
   * @return string
   */
  public function getUri()
  {
    return sprintf('/api/v1/contacts/%s/tickets', $this->getContactId());
  }

  /**
   * @return string
   */
  public function getContactId()
  {
    return $this->contactId;
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
   * Returns array of tickets.
   *
   * @param array $items
   * @return array
   */
  public function getTickets($items)
  {
    if (!count($items)) {
      return [];
    }

    $result = [];
    foreach ($items as $item) {
      $result[] = new Ticket($item);
    }

    return $result;
  }
}