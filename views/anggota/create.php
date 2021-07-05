<?php

if($this->user->get('name')==null){
    Url::redirect("site/index");
}

$redirection = $table_name = "anggota";
$readable_name = ucwords(str_replace("_", " ", $table_name));
$trigger = "submit";

$this->title = "Tambah " . $readable_name;
$lokasi = $this->db->find([], "lokasi");

if (isset($_POST[$trigger])) {
    unset($_POST[$trigger]);
    $response = $this->db->insertOne($_POST, $table_name);

    if ($response) {
        Url::redirect($redirection, ['create-success' => 'true']);
    } else {?>
    <div class="alert alert-danger">
        Gagal Dibuat : <?=$this->db->getError()?>
    </div>
<?php }
}

?>

<div class="row">
    <div class="col-md-8">
        <h1>Tambah <?=$readable_name?></h1>
    </div>
</div>

<form class="form" action="" method="POST">
    <div class="mb-3">
        <label for="">NRP</label>
        <input type="text" class="form-control" name="nrp" value="<?= ($_POST['nrp']) ?? "" ?>">
    </div>
    <div class="mb-3">
        <label for="">NAMA</label>
        <input type="text" class="form-control" name="nama" value="<?= ($_POST['nama']) ?? "" ?>">
    </div>
    <div class="mb-3">
        <label for="">Tanggal Lahir</label>
        <input type="date" class="form-control" name="tgl_lahir" value="<?= ($_POST['tgl_lahir']) ?? "" ?>">
    </div>
    <div class="mb-3">
        <label for="">Alamat</label>
        <input type="text" class="form-control" name="alamat" value="<?= ($_POST['alamat']) ?? "" ?>">
    </div>
    <div class="mb-3">
        <label for="">No HP</label>
        <input type="text" class="form-control" name="no_hp" value="<?= ($_POST['no_hp']) ?? "" ?>">
    </div>
    <div class="mb-3">
        <button class="btn btn-primary" name="<?=$trigger?>">Submit</button>
        <a href="<?=Url::to($redirection)?>" class="btn btn-warning">Kembali</a>
    </div>
</form>