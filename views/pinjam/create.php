<?php

if($this->user->get('name')==null){
    Url::redirect("site/index");
}

$redirection = $table_name = "pinjam";
$readable_name = ucwords(str_replace("_", " ", $table_name));
$trigger = "submit";

$this->title = "Tambah " . $readable_name;

$anggota = $this->db->find([], "anggota");
$buku = $this->db->find([], "buku");

$anggota_list = [];
$buku_list = [];

foreach($anggota as $row){
    $anggota_list[$row->nrp] = $row->nama;
}

foreach($buku as $row){
    $buku_list[$row->kode_buku] = $row->judul;
}


if (isset($_POST[$trigger])) {
    unset($_POST[$trigger]);
    $cek=$this->db->findOne([
        'where'=>[
            'and',
            [
                'and',
                [
                    '=',
                    'kode_buku',
                    $_POST['kode_buku'],
                ],[
                    '=',
                    'nrp',
                    $_POST['nrp'],
                ],
            ],
            [
                '=',
                'lunas',
                0
            ],
        ],
        'order'=>'tgl_pinjam DESC'
    ],'pinjam');
    if($cek){?>
    <div class="alert alert-danger">
        Gagal Dibuat : Masih mempunyai tanggungan
    </div>
    <?php }else{
        $_POST['tgl_pinjam']=date("Y-m-d H:i:s");
        $_POST['tgl_kembali']=date("Y-m-d H:i:s",strtotime("+7 days"));
        $response = $this->db->insertOne($_POST, $table_name);

        if ($response) {
            Url::redirect($redirection, ['create-success' => 'true']);
        } else {?>
        <div class="alert alert-danger">
            Gagal Dibuat : <?=$this->db->getError()?>
        </div>
        <?php }
    }
}

?>

<div class="row">
    <div class="col-md-8">
        <h1>Tambah <?=$readable_name?></h1>
    </div>
</div>

<form class="form" action="" method="POST">
    <div class="mb-3">
        <label for="">Anggota</label>
        <select name="nrp" class="form-control">
            <option value="">-- Pilih Anggota --</option>
            <?= buildOption($anggota_list, $_POST['nrp']) ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="">Buku</label>
        
        <select name="kode_buku" class="form-control">
            <option value="">-- Pilih Buku --</option>
            <?= buildOption($buku_list, $_POST['kode_buku']) ?>
        </select>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary" name="<?=$trigger?>">Submit</button>
        <a href="<?=Url::to($redirection)?>" class="btn btn-warning">Kembali</a>
    </div>
</form>