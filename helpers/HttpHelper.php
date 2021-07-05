<?php

class HttpHelper {
    
    private static function request($url, $fields, $headers = [], $method = "GET")
    {

        $valid_header = [];

        foreach ($headers as $key => $val) {
            $valid_header[] = "$key: " . $val;
        }

        if($fields!=[] && $method=="GET"){
            $url .="?";
            foreach ($fields as $key => $val) {
                $url .= "$key=$val";
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $valid_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($method == "POST"):
            curl_setopt($ch, CURLOPT_POST, true);
            if (empty($fields) == false):
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            endif;
        endif;

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    
    public static function get($url, $fields = null, $headers = [])
    {
        $response = static::request($url, $fields, $headers, "GET");

        return $response;
    }

    public static function getApi($url, $fields = null, $headers = [])
    {
        $response = json_decode(static::request($url, $fields, $headers, "GET"));

        return $response;
    }

    public static function postApi($url, $fields = [], $headers = [])
    {
        $response = json_decode(static::request($url, $fields, $headers, "POST"));

        return $response;
    }
}
