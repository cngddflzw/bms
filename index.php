<?php
const BASE_URL = "";
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "baseController.php");
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR . "baseModel.php");

$requestUri = $_SERVER["REQUEST_URI"];

#找到controller的真实路径
$pattern = "@^(/index\.php(?:/|))@";    #去掉index.php前缀
$requestUri = preg_replace($pattern, "", $requestUri);
$pattern = "@(\?.*)$@";    #去掉最后的参数部分
$requestUri = preg_replace($pattern, "", $requestUri);
$pattern = "@(\W)$@";    #去掉最后的特殊符号
$requestUri = preg_replace($pattern, "", $requestUri);
$pattern = "@^(\W)@";    #去掉开头的特殊符号
$requestUri = preg_replace($pattern, "", $requestUri);
$uriArray = explode("/", $requestUri);
$executeFlag = false;

#检查url路径
$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR;
for ($i = 0; $i < count($uriArray); $i++) {
    $val = $uriArray[$i];

    if (is_dir($path . $val)) { #当url路径是文件夹，不全文件夹
        $path .= $val . "/";
        continue;
    } elseif (file_exists($path . $val . ".php")) { #引入url类并执行其内部方法
        $path .= $val . ".php";
        require_once($path);
        if (!class_exists($val)) { #类名和文件名不一致，中止执行
            header("HTTP/1.1 404 Not Found");
        } else {
            $invokeClass = new $val();
            if ($i != count($uriArray) - 1) { #url中定义了执行方法名
                if(!method_exists($invokeClass, $uriArray[$i + 1])) {   #方法不存在
                    header("HTTP/1.1 404 Not Found");
                } else {
                    $invokeClass->$uriArray[$i + 1]();
                }
            } else { #未定义方法名，执行默认方法
                $method = "index";
                $invokeClass->$method();
            }
            $executeFlag = true;
            break;
        }
    }
    #如果该路径既不是文件夹也不是可执行类，跳转到404
    header("HTTP/1.1 404 Not Found");
}

#如果路径拼接完毕后,方法依然没有执行，则执行默认方法
if($executeFlag === false) {
    if(is_dir($path) && is_file($path . "index.php")) {
        $class = "index";
        $method = "index";
        $path .= $class . ".php";
        require_once($path);
        if(class_exists($class)) {
            $obj = new $class();
            if(method_exists($obj, $method)) {
                $obj->$method();
                $executeFlag = true;
            }
        }
        #如果默认类和方法不存在，跳转到404
        if($executeFlag === false) {
            header("HTTP/1.1 404 Not Found");
        }
    } else {
        #如果默认文件不存在，跳转到404
        header("HTTP/1.1 404 Not Found");
    }
}