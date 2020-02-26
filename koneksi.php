<?php
    ini_set('date.timezone', 'Asia/Jakarta');
    define("HOST","localhost");
    define("USERNAME","locdowns_store");
    define("PASSWORD","3.s.0.c.9.m.7");
    define("DATABASE","locdowns_store");

    /* set config connection procedural */
    $koneksi = new mysqli(HOST,USERNAME,PASSWORD,DATABASE);