<?php

namespace Tallanto\ClientApiBundle\Api\Method;


interface PageableTallantoMethodInterface
{
  /**
   * @return integer
   */
  public function getPageNumber();

  /**
   * @param integer $number
   * @return mixed
   */
  public function setPageNumber($number);

  /**
   * @return integer
   */
  public function getPageSize();

  /**
   * @param integer $size
   * @return mixed
   */
  public function setPageSize($size);

  /**
   * @var integer
   */
  public function getTotalItemsCount();
}