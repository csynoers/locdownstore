<?php
    include_once('koneksi.php');
    # data initialize
    $data = [];
    $data['options'][] = "<option value='' selected disabled> -- Pilih kota/kabupaten -- </option>";

    # loop rows kota ambil dari data RAJAONGKIR
    foreach (json_decode($rajaongkir->city( $_GET['province_id'] ))->rajaongkir->results as $key => $value) {
        $data['options'][] = "<option data-postal-code='{$value->postal_code}' value='{$value->city_id}'>{$value->city_name}</option>";
    }
    # implode data $data['options']
    $data['options'] = implode('',$data['options']);

    echo $data['options'];