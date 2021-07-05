<?php
include_once '../helpers/HttpHelper.php';
include_once '../helpers/global_function.php';
include_once '../helpers/connection.php';

define("GCLIENT_ID","793113128601-f5d7ro24m6ktd2sbdue1t44b834f8o27.apps.googleusercontent.com");
define("GCLIENT_SECRET","ASPmtGj_OIfpzZVoyFzEMzV_");

$response = HttpHelper::postApi("https://www.googleapis.com/oauth2/v4/token",[
    "code"=> $_GET['code'],
    "client_id"=> GCLIENT_ID,
    "client_secret"=> GCLIENT_SECRET,
    "redirect_uri"=> 'http://localhost:8085/uts_web/web/authorize.php',
    "grant_type"=> 'authorization_code'
]);

if (isset($response->error)) {
    print_r($response);
    die;
}

$info = HttpHelper::getApi("https://www.googleapis.com/oauth2/v1/userinfo", [
    "access_token" => $response->access_token,
], [
    'Authorization' => "Bearer " . $response->access_token,
]);


if (isset($response->error)) {
    echo "Terjadi kesalahan ketika mengambil data";
    die;
}

$check = $this->db->findOne([
    "gid" => $info->id,
], 'user');

if ($check) {
    $_SESSION['name'] = $check->name;
} else {
    $saved = $this->db->insertOne([
        "gid" => $info->id,
        "name" => $info->name,
        "image" => $info->picture,
        "email" => $info->email,
    ], 'user');

    if ($saved) {
        $_SESSION['name'] = $info->name;
        header("../index.php");
    } else {
        echo "Terjadi kesalahan ketika menyimpan user";
        die;
    }
}
