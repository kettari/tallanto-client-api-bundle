<?php
/**
 * Created by PhpStorm.
 * User: ant
 * Date: 04.01.2018
 * Time: 22:37
 */

namespace Tallanto\ClientApiBundle\Api\Method;


interface TallantoExpandableInterface
{
  /**
   * Sets expandable flag.
   *
   * @param bool $expand
   * @return mixed
   */
  public function setExpand(bool $expand);

  /**
   * Gets expandable flag.
   *
   * @return bool
   */
  public function isExpand();
}