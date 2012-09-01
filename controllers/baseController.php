<?php
#基础控制器
class __BaseController {
    protected $pageData;    #加载到页面的数据

    public function __construct() {
        $this->pageData["header"] = $this->displayView("header", null, true);
        $this->pageData["footer"] = $this->displayView("footer", null, true);
    }

    #加载view
    public function displayView($viewPath, $params = null, $return = false) {
        if(isset($params) && is_array($params)) {
            foreach($params as $key => $val) {
                $$key = $val;
            }
        }

        if($return === false) {
            require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $viewPath . ".php"));
        } else {
            return file_get_contents(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $viewPath . ".php"));
        }
    }

    #加载config数据
    public function loadConfig($configName) {
        require(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "data.php"));
        return $data[$configName];
    }

    #加载Model
    public function loadModel($modelName) {
        require_once(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR . $modelName . ".php"));
        $className = ucfirst(basename($modelName));
        return new $className();
    }
}