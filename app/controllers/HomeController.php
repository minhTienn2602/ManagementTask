<?php
class HomeController extends BaseController
{
    public $model_home;
    //public $view_home;
    public function __contruct(){
        $this->model_home=$this->loadModel('HomeModel');
    }
    public function index(){
        $this->loadView('home/index');
        
    }
    public function details($id='', $slug='')
    {
        echo 'id san pham:'.$id.'<br/>';
        echo 'slug'.$slug;
    }
}
?>