<?php 
class Controller {

    protected Render $render;

    public function __construct(){
        $this->render = new Render();
    }
}
