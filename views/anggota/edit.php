<?php

if($this->user->get('name')==null){
    Url::redirect("site/index");
}

$redirection = $table_name = "anggota";
$primary_key = "nrp";
$readable_column = "nama";
$readable_name = ucwords(str_replace("_", " ", $table_name));
$trigger = "submit";
$lokasi = $this->db->find([], "lokasi");

$this->title = "Edit " . $readable_name;

$model = $this->db->findOne([
    "where" => [
        "=",
        $primary_key,
        $_GET['id'],
    ],
], $table_name);

if ((array) $model == []):
    Url::redirect('site/error', ['error' => '404']);
endif;

if (isset($_POST[$trigger])) {
    unset($_POST[$trigger]);
    $response = $this->db->update($_POST, $table_name, "$primary_key='{$model->$primary_key}'");

    if ($response) {
        Url::redirect($redirection, ['update-success' => 'true']);
    } else {?>
        <div class="alert alert-danger">
            Gagal Diupdate: <?=$this->db->getError()?>
        </div>
    <?php }
}

?>

<div class="row">
    <div class="col-md-8">
        <h1>Edit <?=$readable_name?>: <?=$model->$readable_column?></h1>
    </div>
</div>

<form class="form" action="" method="POST">
    <div class="mb-3">
        <label for="">NRP</label>
        <input type="text" class="form-control" name="nrp" value="<?= ($model->nrp) ?? "" ?>">
    </div>
    <div class="mb-3">
        <label for="">NAMA</label>
        <input type="text" class="form-control" name="nama" value="<?= ($model->nama) ?? "" ?>">
    </div>
    <div class="mb-3">
        <label for="">Tanggal Lahir</label>
        <input type="date" class="form-control" name="tgl_lahir" value="<?= ($model->tgl_lahir) ?? "" ?>">
    </div>
    <div class="mb-3">
        <label for="">Alamat</label>
        <input type="text" class="form-control" name="alamat" value="<?= ($model->alamat) ?? "" ?>">
    </div>
    <div class="mb-3">
        <label for="">No HP</label>
        <input type="text" class="form-control" name="no_hp" value="<?= ($model->no_hp) ?? "" ?>">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary" name="<?=$trigger?>">Submit</button>
        <a href="<?=Url::to($redirection);?>" class="btn btn-warning">Kembali</a>
    </div>
</form>