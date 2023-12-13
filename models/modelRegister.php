<?php

namespace models;

use Core\DB;

class modelRegister
{
    static public function processAdd($attributes)
    {
        if (isset($attributes['POST']))
            extract($attributes['POST']);

        if (modelUser::check_registration($email) === false) {
            $data = [
                'email' => $email,
                'pass' => MD5($password),
                'fio' => $fio,
                'age' => $age,
                'phone' => $phone,
                'plz' => $plz,
                'city' => $city,
                'addr' => $addr
            ];
            modelUser::addNewUser($data);
            self::sendMail($email, 'Your accout successful created', 'Your account successful created');
            redirect('home', ['withSuccess' => ['Пользователь успешно зарегистирован', 'Вы можете войти в систему используя свои логин и пароль']]);
        } else {
            redirect('register', ['withErrors' => ['Пользователь с Email ' . $email . ' уже существует']]);
        }
    }

    static public function processUpdate($attributes)
    {
        modelUser::checkLoginUser();

        if (isset($attributes['FILES']))
            modelUser::updateImages($attributes['FILES']);

        if (isset($attributes['POST']))
            extract($attributes['POST']);

        $data = [
            'fio' => $fio,
            'age' => $age,
            'phone' => $phone,
            'plz' => $plz,
            'city' => $city,
            'addr' => $addr
        ];
        modelUser::updateUser($data);

        $_SESSION['logged_user'] = modelUser::get_user_by_id($_SESSION['logged_user']->id);

        redirect('profile', ['withSuccess' => ['Пользователь успешно обновлен']]);
    }

    static public function processLogin($attributes)
    {
        if (isset($attributes['POST']))
            extract($attributes['POST']);

        if (modelUser::check_login($email, MD5($password)) !== false) {

            $_SESSION['logged_user'] = modelUser::check_login($email, MD5($password));

            redirect('profile');

        } else {
            redirect('home', ['withErrors' => ['Email или пароль не корректен!']]);
        }
    }

    static public function sendMail($to, $subject, $message)
    {
        if ((empty($to) || empty($subject) || empty($message)))
            throw new \Exception('Empty required vars');

        $headers = 'From: info@anira-web.ru' . "\r\n" .
            'Reply-To: info@anira-web.ru' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

}
