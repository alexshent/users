<?php

namespace alexshent\webapp\application\controllers;

use alexshent\webapp\application\Config;
use alexshent\webapp\core\View;

class MainController extends \alexshent\webapp\core\Controller {
    
    public function usersAction() {        
        $view = new View("main");
        $content = $view->render("users", [], true);
        $view->render("template", [
            'bootstrap' => Config::Bootstrap,
            'title' => 'Users',
            'bodyContent' => $content
            ]);
    }
    
}
