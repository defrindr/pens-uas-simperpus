<?php

class Url {
    public static function getBaseUrl()
    {
        if(App::$local==true){
            $scriptname = $_SERVER['SCRIPT_NAME'];
            $scriptname = str_replace("index.php", "", $scriptname);
            return $scriptname;
        }
        $protocol = "{$_SERVER['REQUEST_SCHEME']}://";
        $host = $_SERVER['HTTP_HOST'];
        return "{$protocol}{$host}/";
    }
    
    public static function to($uri, $params=[])
    {
        $url = static::getBaseUrl();
        $url .= $uri;
        if($params){
            $url .= "?";
            foreach($params as $k=>$p){
                $url .= "$k=$p&";
            }
            $url = str_split($url,strlen($url)-1)[0];
        }
        return $url;
    }

    public static function redirect($to, $params=[]){
        header("location: ". static::to($to, $params));
    } 
}