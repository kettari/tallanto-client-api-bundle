<?php
/**
 * Created by PhpStorm.
 * User: ant
 * Date: 07.09.2017
 * Time: 21:06
 */

namespace Tallanto\ClientApiBundle\Api\Method;

use Tallanto\Api\Entity\Contact;

class TallantoGetContactsMethod extends AbstractCollectionTallantoMethod implements TallantoExpandableInterface
{
  /**
   * @var \DateTime
   */
  private $modifiedSince;

  /**
   * @var string
   */
  private $query;

  /**
   * @var boolean
   */
  private $expand = false;

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
    $params = ['expand' => $this->isExpand() ? 'true' : 'false'];
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
   * Returns array of contacts.
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

  /**
   * @return bool
   */
  public function isExpand(): bool
  {
    return $this->expand;
  }

  /**
   * @param bool $expand
   * @return TallantoGetContactsMethod
   */
  public function setExpand(bool $expand)
  {
    $this->expand = $expand;

    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getModifiedSince()
  {
    return $this->modifiedSince;
  }

  /**
   * @param \DateTime $modifiedSince
   * @return TallantoGetContactsMethod
   */
  public function setModifiedSince(\DateTime $modifiedSince
  ): TallantoGetContactsMethod {
    $this->modifiedSince = $modifiedSince;

    return $this;
  }

  /**
   * Returns array of request headers.
   *
   * @return array|null
   */
  public function getRequestHeaders()
  {
    $headers = parent::getRequestHeaders();
    if (!is_null($this->modifiedSince)) {
      $headers['If-Modified-Since'] = $this->modifiedSince->format('r');
    }

    return $headers;
  }
}