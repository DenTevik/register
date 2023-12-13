<?php

use models\modelRegister;
use models\modelUser;

class Register extends Controller
{

    public function index($data = [], $attributes = [])
    {
        echo $this->render->view('register', []);

    }

    public function add($data = [], $attributes = [])
    {
        modelRegister::processAdd($attributes);
    }

    public function login($data = [], $attributes = [])
    {
        modelRegister::processLogin($attributes);
    }

    public function logout($data = [], $attributes = [])
    {   
        unset($_SESSION['logged_user']);
        redirect('home', ['withSuccess' => ['Вы успешно вышли из системы']]);
    }

    
    public function update($data = [], $attributes = [])
    {   
        modelRegister::processUpdate($attributes);
    }
    public function delete($data = [], $attributes = [])
    {   
        modelUser::deleteUser();
    }

    public function deleteimg($data = [], $attributes = [])
    {   
        modelUser::deleteUserImage();
    }

}
