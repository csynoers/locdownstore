<?php
    ini_set('date.timezone', 'Asia/Jakarta');
    define("HOST","localhost");
    define("USERNAME","locdowns_store");
    define("PASSWORD","3.s.0.c.9.m.7");
    define("DATABASE","locdowns_store");

    /**
     * setting konfigurasi replace database 
     */
    define("SQL_DUMP","sql_dump/".DATABASE.".sql");
    
    /**
     * setting konfigurasi XENDIT
     */
    define("XENDIT_API_KEY","secret_api_key");

    /* set config connection procedural */
    $koneksi = new mysqli(HOST,USERNAME,PASSWORD,DATABASE);

    class DB
    {
        protected $db;
        function __construct() {
            $this->db = $this->check_connection(); 
        }

        /*
        *	public function query
        *	return object
        */
        public function query()
        {
            $stmt= $this->db->prepare($this->query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        /*
        *	public function query
        *	return boolean
        */
        public function query_exec()
        {
            $stmt= $this->db->prepare($this->query);
            return $stmt->execute();
        }

        protected function check_connection()
        {
            try {
                $conn = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USERNAME, PASSWORD);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
                // echo "Connection failed: " . $e->getMessage();
            }
        }
    }

    $db = new DB();

    class Xendit{
        function __construct () {
            $this->server_domain = 'https://api.xendit.co';
            $this->secret_api_key = XENDIT_API_KEY;
        }

        function createInvoice ($external_id, $amount, $payer_email, $description, $invoice_options = null) {
            $curl = curl_init();

            $headers = array();
            $headers[] = 'Content-Type: application/json';

            $end_point = $this->server_domain.'/v2/invoices';

            $data['external_id'] = $external_id;
            $data['amount'] = (int)$amount;
            $data['payer_email'] = $payer_email;
            $data['description'] = $description;

            if ( is_array($invoice_options) ) {
                foreach ( $invoice_options as $key => $value ) {
                    $data[$key] = $value;
                }
            }

            $payload = json_encode($data);

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_USERPWD, $this->secret_api_key.":");
            curl_setopt($curl, CURLOPT_URL, $end_point);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            curl_close($curl);

            $responseObject = json_decode($response, true);
            return $responseObject;
        }

        function getInvoice ($invoice_id) {
            $curl = curl_init();

            $headers = array();
            $headers[] = 'Content-Type: application/json';

            $end_point = $this->server_domain.'/v2/invoices/'.$invoice_id;

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_USERPWD, $this->secret_api_key.":");
            curl_setopt($curl, CURLOPT_URL, $end_point);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            curl_close($curl);

            $responseObject = json_decode($response, true);
            return $responseObject;
        }
    }

    $xendit = new Xendit();