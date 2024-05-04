<?php
class App
{
    private $__controller,$__action,$__params;
    function __construct()
    {
        $this->__controller='home';
        $this->__action='index';
        $this->__params=[];
        $this->handleUrl();
    }

    function getUrl()
    {
        if(!empty($_SERVER['PATH_INFO']))
        {
            $url=$_SERVER['PATH_INFO'];
        }
        else
        {
            $url='/';
        }
        return $url;
    }

    public function handleUrl()
    {
        $url=$this->getUrl();
        $urlArr=array_filter(explode('/',$url));
        $urlArr=array_values($urlArr);

        //Xử lý controllers 
        if(!empty($urlArr[0]))
        {
            $this->__controller=ucfirst($urlArr[0]); 
            
        }
        else
        {
            $this->__controller=ucfirst($this->__controller); 
        }
        if(file_exists('app/controllers/'. ucfirst($this->__controller) .'Controller.php'))
        {
                require_once 'app/controllers/'. ucfirst($this->__controller) .'Controller.php';
                $controllerClassName = ucfirst($this->__controller) . 'Controller';
                $this->__controller=new $controllerClassName();
                unset($urlArr[0]);
        }
            
        else
        {
                $this->loadError();
        }
        
        //Xử lý action
        if(!empty($urlArr[1]))
        {
            $this->__action=$urlArr[1];
            unset($urlArr[1]);
        }

        //Xử lý params
        $this->__params=array_values($urlArr);
        
        // Gọi action từ controller
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }
    }

    public function loadError($name='404')
    {
        require_once 'errors/'.$name.'.php';  
    }
    
}
?>