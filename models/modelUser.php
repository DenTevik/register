<?php

namespace models;

use Core\DB;

class modelUser
{
    static public function addNewUser(array $data)
    {
        extract($data);
        return DB::use()->insert("INSERT INTO users (email, pass, fio, age, phone, plz, city, addr, create_time) VALUES (:email, :pass, :fio, :age, :phone, :plz, :city, :addr, NOW())",
            ['email' => $email,
                'pass' => $pass,
                'fio' => $fio,
                'age' => $age,
                'phone' => $phone,
                'plz' => $plz,
                'city' => $city,
                'addr' => $addr
            ]);
    }

    static public function updateUser(array $data)
    {
        extract($data);
        return DB::use()->update("UPDATE users SET fio=:fio, age=:age, phone=:phone, plz=:plz, city=:city, addr=:addr WHERE id=:id",
            ['fio' => $fio,
                'age' => $age,
                'phone' => $phone,
                'plz' => $plz,
                'city' => $city,
                'addr' => $addr,
                'id' => $_SESSION['logged_user']->id
            ]);
    }

    static public function check_login(string $email, string $pass)
    {
        if (empty($email))
            throw new \Exception('Email can not be empty');

        if (empty($pass))
            throw new \Exception('Password can not be empty');

        return DB::use()->query('SELECT * FROM users WHERE email = :email AND pass = :pass LIMIT 1', ['email' => $email, 'pass' => $pass])->find();

    }

    static public function get_user_by_id(int $id)
    {
        if (empty($id))
            throw new \Exception('$id can not be empty');

        return DB::use()->query('SELECT * FROM users WHERE id = :id ', ['id' => $id])->find();

    }

    static public function check_registration(string $email): bool
    {
        if (empty($email))
            throw new \Exception('Email can not be empty');

        if (!empty(DB::use()->query('SELECT * FROM users WHERE email = :email LIMIT 1', ['email' => $email])->find()))
            return true;
        else
            return false;

    }

    static public function checkLoginUser()
    {
        if (empty($_SESSION['logged_user']))
            redirect('home');
    }

    static public function deleteUser()
    {
        self::checkLoginUser();
        self::deleteUserImage(true);
        $logged_user = $_SESSION['logged_user'];
        unset($_SESSION['logged_user']);
        DB::use()->query('DELETE FROM users WHERE id = :id', ['id' => $logged_user->id]);
        redirect('home', ['withSuccess' => ['Профиль успешно удален']]);
    }

    static public function updateImages($data)
    {
        self::checkLoginUser();

        $userdir = self::getUserImageDir();

        if (!file_exists($userdir))
            mkdir($userdir, 0777);

        move_uploaded_file($data['fileToUpload']['tmp_name'], $userdir . $data['fileToUpload']['name']);

        DB::use()->update("UPDATE users SET image=:image WHERE id=:id",
            [
                'image' => $data['fileToUpload']['name'],
                'id' => $_SESSION['logged_user']->id
            ]);

    }

    static public function deleteUserImage($force = false)
    {
        self::checkLoginUser();

        $userdir = self::getUserImageDir();

        if (file_exists($userdir . $_SESSION['logged_user']->image))
            unlink($userdir . $_SESSION['logged_user']->image);

        if (file_exists($userdir))
            rmdir($userdir);
        
        if ($force !== true) {
            DB::use()->update("UPDATE users SET image=:image WHERE id=:id",
                [
                    'image' => '',
                    'id' => $_SESSION['logged_user']->id
                ]);

            $_SESSION['logged_user'] = self::get_user_by_id($_SESSION['logged_user']->id);

            redirect('profile', ['withSuccess' => ['Картинка успешно удалена']]);
        }
    }

    static public function getUserImageDir()
    {
        return BASE_PATH . "uploads/" . $_SESSION['logged_user']->id . "/";
    }


}