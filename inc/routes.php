<?php 

class Routes {

    public function __construct($parameters, $attributes){
        $params = explode("/", trim($parameters, "/"),3);

        $controller = !empty($params[0]) ? $params[0] : 'Home';
        $instance =  !empty($params[1]) ? $params[1] : 'index';
        $args = isset($params[2]) ? explode("/", trim($params[2], "/")) : []; 

        $controller = ucwords($controller);

        if(file_exists("controllers/$controller.php")){
            require_once "controllers/$controller.php";
        }else{
            $controller = "NotFoundController";
            $instance = 'notFound';
            require_once "controllers/NotFoundController.php";
        }

        if(class_exists($controller)){
            $controller_class = new $controller();
            if(method_exists($controller_class, $instance)){
                $controller_class->$instance($args, $attributes);
            }else{
                die("Undefined $instance Method in $controller Controller");
            }
        }
    }
}
