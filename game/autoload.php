<?php

spl_autoload_register(function ($classname){
    $pathClass = __DIR__.'/'.$classname.'.php';
    $pathClass = str_replace('\\', '/',$pathClass);
    if (file_exists($pathClass)){
      require_once $pathClass;
    }
});
