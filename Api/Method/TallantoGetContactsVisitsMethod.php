<?php
/**
 * Created by PhpStorm.
 * User: ant
 * Date: 07.09.2017
 * Time: 21:06
 */

namespace Tallanto\ClientApiBundle\Api\Method;

use Tallanto\Api\Entity\Visit;

class TallantoGetContactsVisitsMethod extends AbstractCollectionTallantoMethod implements TallantoExpandableInterface
{
  /**
   * @var string
   */
  private $contactId;

  /**
   * @var \DateTime
   */
  private $modifiedSince;

  /**
   * @var boolean
   */
  private $expand = false;

  /**
   * TallantoGetContactsMethod constructor.
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
    return sprintf('/api/v1/contacts/%s/visits', $this->contactId);
  }

  /**
   * @return array
   */
  public function getQueryParameters()
  {
    $params = ['expand' => $this->isExpand() ? 'true' : 'false'];

    return $params;
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
   * @return \Tallanto\ClientApiBundle\Api\Method\TallantoGetContactsVisitsMethod
   */
  public function setExpand(bool $expand)
  {
    $this->expand = $expand;

    return $this;
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
   * Returns array of visits.
   *
   * @param array $items
   * @return array
   */
  public function getVisits($items)
  {
    $result = [];
    foreach ($items as $item) {
      $result[] = new Visit($item);
    }

    return $result;
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
   * @return \Tallanto\ClientApiBundle\Api\Method\TallantoGetContactsVisitsMethod
   */
  public function setModifiedSince(\DateTime $modifiedSince
  ): TallantoGetContactsVisitsMethod {
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

  /**
   * @return string
   */
  public function getContactId()
  {
    return $this->contactId;
  }


}