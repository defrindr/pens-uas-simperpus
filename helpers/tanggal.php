<?php

class Tanggal {
    public static function toReadable($date){
        $time = strtotime($date);
        return date("d F Y",$time);
    }
}