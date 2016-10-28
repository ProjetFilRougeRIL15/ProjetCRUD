<?php

namespace UserAuthBundle\Services;

class UserAuthService
{
  public function isConnecter()
  {
    return isset($_SESSION['user']);
  }
}