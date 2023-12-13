<?php

class Render {
    public function view($view_filename, $data = [])
    {
        extract((array)$data);
        include_once("views/{$view_filename}.php");
    }
}
