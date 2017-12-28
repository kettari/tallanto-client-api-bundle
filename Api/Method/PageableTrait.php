<?php

namespace Tallanto\ClientApiBundle\Api\Method;


trait PageableTrait
{
  /**
   * @var int
   */
  private $pageNumber = 1;

  /**
   * @var int
   */
  private $pageSize = 20;

  /**
   * @var int
   */
  private $totalPageCount = 0;

  /**
   * @var bool
   */
  private $retrieveAllPages = false;

  /**
   * @return integer
   */
  public function getPageNumber()
  {
    return $this->pageNumber;
  }

  /**
   * @param integer $number
   * @return mixed
   */
  public function setPageNumber($number)
  {
    $this->pageNumber = $number;

    return $this;
  }

  /**
   * @return integer
   */
  public function getPageSize()
  {
    return $this->pageSize;
  }

  /**
   * @param integer $size
   * @return mixed
   */
  public function setPageSize($size)
  {
    $this->pageSize = $size;

    return $this;
  }
}