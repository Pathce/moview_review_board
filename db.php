<?php
    session_start();

    header('Content-Type: text/html; charset=utf-8');

    $db = new mysqli("localhost", "root", "", "review_board");
    $db->set_charset("utf8");

    function query($query){
        global $db;
        return $db->query($query);
    }