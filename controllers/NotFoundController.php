<?php

class NotFoundController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function notFound(): void
    {
        $this->render->view('404');
    }
}
