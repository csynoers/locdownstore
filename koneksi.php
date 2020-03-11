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
     * setting konfigurasi RAJAONGKIR
     */
    define("RAJAONGKIR_API_KEY","04419aca2907b96962780057dbc98f5a");

    /**
     * setting konfigurasi XENDIT
     */
    define("XENDIT_API_KEY","xnd_development_iSkAxVRSCnwSVyvnC4lQR7rRnuSgO4CNmtWNIetIeRRayMJTZV6JEhl0Th3");

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
        
        /*
        *	public function query
        *	return lastInsertId
        */
        public function lastInsertId()
        {
            return $this->db->lastInsertId();
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
    
    class Rajaongkir {
    
        function __construct(){
            $this->key = RAJAONGKIR_API_KEY;
        }
        
        public function province()
        {
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "key: {$this->key}"
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
                return $response;
            }
        }
        public function city($province_id)
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province={$province_id}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 04419aca2907b96962780057dbc98f5a"
            ),
            ));
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
                return $response;
            }
        }
        public function cost($data)
        {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=501&destination={$data['destination']}&weight={$data['weight']}&courier={$data['courier']}",
            // CURLOPT_POSTFIELDS => "origin=501&destination=114&weight=1700&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 04419aca2907b96962780057dbc98f5a"
            ),
            ));
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            if ($err) {
                return "cURL Error #:" . $err;
            } else {
                return $response;
            }
        }
        public function courier()
        {
            return [
                'jne',
                'pos',
                'tiki',
            ];
        }
        public function cost_all($get=null){
            $data= [];
            foreach ($this->courier() as $key => $value) {
                $kurir= json_decode(
                    $this->cost([
                        'destination'=> $get['destination'],
                        'weight'=> $get['weight'],
                        'courier'=> $value,
                    ])
                )->rajaongkir->results;
    
                foreach ($kurir as $key_kurir => $value_kurir) {
                    $code= strtoupper( $value_kurir->code );
                    foreach ($value_kurir->costs as $key_costs => $value_costs) {
                        $service= $value_costs->service;
                        foreach ($value_costs->cost as $key_cost => $value_cost) {
                            $data[]= [
                                'code'=> $code,
                                'service'=> $service,
                                'etd'=> $value_cost->etd .($code=='POS'? null : ' HARI' ),
                                'value'=> $value_cost->value,
                            ];
                        }
                    }
                }
            }
            return $data;
        }
        public function courier_html_option()
        {
            $this->load->helper('currency');
            $rows= $this->cost_all([
                'destination'=> $this->input->get('destination'),
                'weight'=> $this->input->get('weight'),
            ]);
            $html= "";
            foreach ($rows as $key => $value) {
                $html .= "<option value='{$value["value"]}' kurir='{$value["code"]} {$value["service"]} ({$value["etd"]})' >{$value["code"]} {$value["service"]} ({$value["etd"]}) - ".idr($value['value'])."</option>";
            }
            echo $html;
        }
      
    }
    
    $rajaongkir = new Rajaongkir();

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