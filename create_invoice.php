<?php
// 5e5a67cbe938f912e5c1c0f0
// https://invoice-staging.xendit.co/web/invoices/5e5a67cbe938f912e5c1c0f0
    session_start();
    include_once("koneksi.php");
    $invoice = $xendit->createInvoice($_GET['id'], $_GET['amount'], $_GET['email'], $_GET['keterangan']);
    if ( $invoice['id'] ) {
        $query = [];
        $query['query_insert_pembelian'] = ("INSERT INTO `pembelian`(`id_pembelian`, `id_pelanggan`, `tanggal_pembelian`, `total_pembelian`, `external_id`, `invoice_url`, `status_pembayaran`) VALUES ('{$_SESSION['order_id']}','{$_SESSION['pelanggan']['id_pelanggan']}','".date('Y-m-d H:i:s')."','{$_GET['amount']}','{$invoice['id']}','{$invoice['invoice_url']}','belum_dibayar')");
        foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) {
            // $db->query = "SELECT * FROM produk WHERE id_produk='{$id_produk}'";
            // $row = $db->query();
            $query[] = ("INSERT INTO `pembelian_produk`(`id_pembelian`, `id_produk`) VALUES ('{$_SESSION['order_id']}','{$id_produk}')");
            // $query[] = ("UPDATE `produk`(`id_pembelian`, `id_produk`) VALUES ('{$_SESSION['order_id']}','{$id_produk}')");
        }

        foreach($query as $key => $value) {
            $db->query = $value;
            $db->query_exec();
        }
        $data = [
            'status' => 'true',
            'url' => $invoice['invoice_url']
        ];
        unset($_SESSION["keranjang"]);
    }else {
        $data = [
            'status' => 'false'
        ];

    }

    echo json_encode($data);
    