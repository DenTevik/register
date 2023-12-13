<?php

use models\Statistic;
use models\modelUser;

class Profile extends Controller
{
  public function index($data = [], $attributes = [])
  {
    modelUser::checkLoginUser();

    echo $this->render->view('profile', $_SESSION['logged_user']);

  }

}
