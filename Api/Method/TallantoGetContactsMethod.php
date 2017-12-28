<?php
/**
 * Created by PhpStorm.
 * User: ant
 * Date: 07.09.2017
 * Time: 21:06
 */

namespace Tallanto\ClientApiBundle\Api\Method;

use Tallanto\Api\Entity\Contact;

class TallantoGetContactsMethod extends AbstractCollectionTallantoMethod
{
  /**
   * @var string
   */
  private $query;

  /**
   * TallantoGetContactsMethod constructor.
   *
   * @param string $query
   */
  public function __construct($query = null)
  {
    $this->query = $query;
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
   * @return array
   */
  public function getQueryParameters()
  {
    $params = ['expand' => 'true'];
    if (!is_null($this->getQuery())) {
      $params['q'] = $this->getQuery();
    }

    return $params;
  }

  /**
   * @return string
   */
  public function getQuery()
  {
    return $this->query;
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
  public function getContacts($items)
  {
    $result = [];
    foreach ($items as $item) {
      $result[] = new Contact($item);
    }

    return $result;
  }
}