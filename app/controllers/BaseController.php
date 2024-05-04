<?php
class BaseController {
    public function loadModel($model) {
        $modelFilePath = 'app/models/' . $model . '.php';
        if (file_exists($modelFilePath)) {
            require_once $modelFilePath;
            $fullModelClassName = ucfirst($model);
            if (class_exists($fullModelClassName)) {
                $modelInstance = new $fullModelClassName();
                return $modelInstance;
            }
        }
        return false;
    }

    public function loadView($view, $data = []) {
        extract($data);
        $viewFilePath = 'app/views/' . $view . '.php';
        if (file_exists($viewFilePath)) {
            require_once $viewFilePath;
        } else {
            echo "View '$view' not found.";
        }
    }

    
}
?>