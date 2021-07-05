<?php

class Alert {
    public static function message($err=""){
        $show = 0;
        $color = "success";

        if(isset($_GET['update-success'])){
            $show = 1;
            $message = "Data berhasil di ubah";
        } else if(isset($_GET['create-success'])){
            $show = 1;
            $message = "Data berhasil di buat";
        } else if(isset($_GET['delete-success'])){
            $show = 1;
            if($_GET['delete-success'] == "true"){
                $message = "Data berhasil di hapus";
            } else {
                $message = "Data gagal di hapus: ".$_GET['msg'];
                $color = "danger";
            }
        } 

        if ($show):
            echo "<div class=\"alert alert-$color\">
                $message
            </div>";
        endif;
    }
}