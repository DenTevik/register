<?php

use models\Statistic;
use models\User;

class Home extends Controller
{

    public function index($data = [], $attributes = [])
    {
        echo $this->render->view('home', []);

    }

}
