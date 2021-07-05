<?php
$redirection = $table_name = "pinjam";
$readable_name = ucwords(str_replace("_", " ", $table_name));

$primary_key = $this->db->getPrimaryKey($table_name);
$columns = $this->db->getColumns($table_name, [
    "without_primary_key" => false,
    "unset" => [
        "nrp",
        "kode_buku",
    ],
]);

$model = $this->db->find([], $table_name);

$this->title = $readable_name;

if($this->user->get('name')==null){
    Url::redirect("site/index");
}

?>

<h1><?=$readable_name?></h1>
<a href="<?=Url::to($redirection . "/create")?>" class="btn btn-success">Tambah</a>

<button class="btn btn-success" onclick="printDiv()">Cetak</button>
<div id="areaToPrint">
<table class="table table-responsive">
    <thead>
        <?php foreach ($columns as $col): ?>
            <th><?=ucwords(str_replace("_", " ", $col))?></th>
        <?php endforeach?>
        <th>Nama</th>
        <th>Buku</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php foreach ($model as $row): ?>
        <tr>
            <?php foreach ($columns as $col): ?>
                <td><?=$row->$col?></td>
            <?php endforeach?>
            <td><?=$this->db->findOne([
                    'where'=>[
                        '=',
                        'nrp',
                        $row->nrp
                    ],
                ],'anggota')->nama;?></td>
            <td><?=$this->db->findOne([
                    'where'=>[
                        '=',
                        'kode_buku',
                        $row->kode_buku
                    ],
                ],'buku')->judul;?></td>
            <td>
                <?php if($row->realisasi_kembali!=null&&$row->lunas==0): ?>
                <a href="<?=Url::to($redirection . "/lunas", ['id' => $row->$primary_key])?>" class="btn btn-primary  mt-1">Lunas</a>
                <?php endif ?>
                <?php if($row->realisasi_kembali==null): ?>
                <a href="<?=Url::to($redirection . "/kembalikan", ['id' => $row->$primary_key])?>" class="btn btn-dark  mt-1">Kembalikan</a>
                <?php endif ?>
                <?php if($row->realisasi_kembali==null): ?>
                <form action="<?=Url::to($redirection . "/delete")?>" method="post" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?=$row->$primary_key?>">
                    <button class="btn btn-danger mt-1">delete</button>
                </form>
                <?php endif ?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
</div>


<script type="text/javascript">
function printDiv()
    {
        Popup(document.getElementById("areaToPrint").innerHTML);
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body style="direction:rtl;"><pre>');
        mywindow.document.write(data);
        mywindow.document.write('</pre></body></html>');
        mywindow.document.close();
        mywindow.print();
        return true;
    }
</script>