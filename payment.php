<?php
    include_once("koneksi.php");
    class Payment extends DB {
        protected $db;
        public $xendit;
        function __construct () {
            parent::__construct();
            $this->db = new DB();
            $this->xendit = new Xendit();
            $this->update();
        }

        public function update ()
        {        
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->data                     = [];
                $this->data['response']         = file_get_contents("php://input");
                $this->data['responseDecode']   = json_decode($this->data['response']);

                # get data id for WHERE condition to change field tabel in your database
                $this->data['id']               = $this->data['responseDecode']->id;

                switch ( $this->data['responseDecode']->status ) {
                    case 'PAID':
                        # code controller paid payment here...
                        $this->db->query = "UPDATE `pembelian` SET `status_pembayaran`='sudah_dibayar',`status_pesanan`='sedang_dikemas' WHERE `external_id`='{$result->id}' ";
                        $this->db->query();
                        break;
                    
                    case 'EXPIRED':
                        # code controller expired payment here...
                        $this->db->query = "UPDATE `pembelian` SET `status_pembayaran`='kadaluarsa' WHERE `external_id`='{$result->id}' ";
                        $this->db->query();
                        break;
                    
                    default:
                        # code...
                        break;
                }
                
                print_r("\n\{$this->data['response']} contains the updated invoice data \n\n");
                print_r($this->data['response']);
                print_r("\n\nUpdate your database with the invoice status \n\n");

            } else {
                print_r("Cannot ".$_SERVER["REQUEST_METHOD"]." ".$_SERVER["SCRIPT_NAME"]);

            }
        }
    }

    $payment = new Payment();
?>