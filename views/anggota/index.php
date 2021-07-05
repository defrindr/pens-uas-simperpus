<?php
$redirection = $table_name = "anggota";
$readable_name = ucwords(str_replace("_", " ", $table_name));

$primary_key = $this->db->getPrimaryKey($table_name);
$columns = $this->db->getColumns($table_name, [
    "without_primary_key" => false,
    "unset" => [
        // "lokasi_id",
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
<table class="table table-responsive">
    <thead>
        <?php foreach ($columns as $col): ?>
            <th><?=ucwords(str_replace("_", " ", $col))?></th>
        <?php endforeach?>
        <th>Action</th>
    </thead>
    <tbody>
        <?php foreach ($model as $row): ?>
        <tr>
            <?php foreach ($columns as $col): ?>
                <td><?=$row->$col?></td>
            <?php endforeach?>
            <td>
                <a href="<?=Url::to($redirection . "/view", ['id' => $row->$primary_key])?>" class="btn btn-primary  mt-1">show</a>
                <a href="<?=Url::to($redirection . "/edit", ['id' => $row->$primary_key])?>" class="btn btn-warning mt-1">edit</a>
                <form action="<?=Url::to($redirection . "/delete")?>" method="post" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?=$row->$primary_key?>">
                    <button class="btn btn-danger mt-1">delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>