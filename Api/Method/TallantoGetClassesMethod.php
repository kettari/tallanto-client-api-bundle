<?php
/**
 * Created by PhpStorm.
 * User: ant
 * Date: 07.09.2017
 * Time: 21:06
 */

namespace Tallanto\ClientApiBundle\Api\Method;

use Tallanto\Api\Entity\ClassEntity;

class TallantoGetClassesMethod extends AbstractCollectionTallantoMethod implements TallantoExpandableInterface
{
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
   */
  public function __construct()
  {
  }

  /**
   * Returns URI of the method.
   *
   * @return string
   */
  public function getUri()
  {
    return '/api/v1/classes';
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
   * @return \Tallanto\ClientApiBundle\Api\Method\TallantoGetClassesMethod
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
   * Returns array of contacts.
   *
   * @param array $items
   * @return array
   */
  public function getClasses($items)
  {
    $result = [];
    foreach ($items as $item) {
      $result[] = new ClassEntity($item);
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
   * @return TallantoGetClassesMethod
   */
  public function setModifiedSince(\DateTime $modifiedSince
  ): TallantoGetClassesMethod {
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