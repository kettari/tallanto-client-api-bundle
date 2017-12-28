<?php

namespace Tallanto\ClientApiBundle\Api\Method;


abstract class AbstractSecuredTallantoMethod extends AbstractTallantoMethod
{
  /**
   * @var bool
   */
  protected $secured = true;

  /**
   * @var string
   */
  private $login;
  /**
   * @var string
   */
  private $password;

  /**
   * @return string
   */
  public function getLogin()
  {
    return $this->login;
  }

  /**
   * @param string $login
   * @return AbstractSecuredTallantoMethod
   */
  public function setLogin(string $login): AbstractSecuredTallantoMethod
  {
    $this->login = $login;

    return $this;
  }

  /**
   * @return string
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * @param string $password
   * @return AbstractSecuredTallantoMethod
   */
  public function setPassword(string $password): AbstractSecuredTallantoMethod
  {
    $this->password = $password;

    return $this;
  }
}