<?php
$lists = [
    [
        Url::getBaseUrl()."/anggota/",
        "Anggota",
    ],
    [
        Url::getBaseUrl()."/buku/",
        "Buku",
    ],
    [
        Url::getBaseUrl()."/pinjam/",
        "Transaksi Pinjam",
    ],
];
?>
<ul class="nav nav-pills">
<?php foreach($lists as $list): ?>
    <li class="nav-item"><a href="<?= $list[0] ?>index" class="nav-link <?= (strpos("?".$_SERVER['QUERY_STRING'], $list[0]) != false) ? "active" : '' ?>"><?= $list[1] ?></a></li>
<?php endforeach ?>
<?php if($this->user->get('name')!=null):?>
    <li class="nav-item"><a href="<?=Url::getBaseUrl()."/site/logout"?>" class="nav-link">Logout</a></li>
<?php endif?>
</ul>