<?php

if ($this->user->get('name') == null) {
    Url::redirect("site/index");
}

$redirection = $table_name = "pinjam";
$primary_key = "id";
$readable_column = "tgl_pinjam";
$readable_name = ucwords(str_replace("_", " ", $table_name));
$trigger = "submit";
$columns = $this->db->getColumns($table_name, [
    "without_primary_key" => false,
    "unset" => [
        // "lokasi_id"
    ],
]);

$model = $this->db->findOne([
    "where" => [
        "=",
        $primary_key,
        $_GET['id'],
    ],
], $table_name);

if($model->lunas==1){
    Url::redirect($redirection, [
        'lunas-success' => 'false',
        'msg' => "Sudah Lunas",
    ]);
}

$data["lunas"] = 1;
$response = $this->db->update($data, $table_name, "$primary_key='{$model->$primary_key}'");

if ($response) {
    Url::redirect($redirection, ['lunas-success' => 'true']);
} else {
    Url::redirect($redirection, [
        'lunas-success' => 'false',
        'msg' => $this->db->getError(),
    ]);
}
