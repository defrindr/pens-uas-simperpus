<?php

function dd($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die;
}

function fileRenderer($files){
    $template="";
    if(isset($files['css'])):
        foreach($files['css'] as $link):
                $template .= "<link href='$link'>\n";
        endforeach;
    endif;

    if(isset($files['js'])):
        foreach($files['js'] as $link):
                $template .= "\t\t<script src='$link'></script>\n";
        endforeach;
    endif;

    echo $template;
}

function getRootDir() {
    $root_dir = $_SERVER['DOCUMENT_ROOT'];
    $script_filename = $_SERVER['SCRIPT_FILENAME'];
    $script_filename = str_replace($root_dir, "", $script_filename);
    $script_filename = str_replace("/index.php", "", "$script_filename");
    return $root_dir.$script_filename;
}

function getBaseUrl() {
    $root_dir = $_SERVER['DOCUMENT_ROOT'];
    $script_filename = $_SERVER['SCRIPT_FILENAME'];
    $script_filename = str_replace($root_dir, "", $script_filename);
    $script_filename = str_replace("/index.php", "", "$script_filename");
    return "/$script_filename";
}

function buildOption($lists, $selected){
    $template = "";

    foreach($lists as $key => $val){
        $is_select = "";
        if($key == $selected) $is_select = "selected";
        $template .= "<option value='$key' $is_select>$val</option>\n";
    }

    return $template;
}