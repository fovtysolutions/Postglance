<?php
if(!class_exists("Pinterest_API")){
    include 'CurlBuilder.php';
    class Pinterest_API{
        private $client_id;
        private $client_secret;
        private $redirect_uri;
        private $access_token;
        private $params;
        private $curlbuilder;
        private $host = "https://api-sandbox.pinterest.com/v5/";

        public function __construct($client_id = null, $client_secret = null, $callback_url = null){
            $this->client_id = $client_id;
            $this->client_secret = $client_secret;
            $this->redirect_uri = $callback_url;
            $this->curlbuilder = new \CurlBuilder();

            $this->scopes = [
                "ads:read",
                "boards:read",
                "boards:read_secret",
                "boards:write",
                "boards:write_secret",
                "pins:read",
                "pins:read_secret",
                "pins:write",
                "pins:write_secret",
                "user_accounts:read",
                "catalogs:read",
                "catalogs:write"
            ];

            $this->params = array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $this->redirect_uri,
                'response_type' => 'code',
                'scope' => implode(",", $this->scopes),
                'state' => uniqid()
            );

            if( (get_session("Pinterest_AccessToken_Sandbox") ) || get_option("pinterest_environment", 0)){
                $this->host = "https://api.pinterest.com/v5/";
            }
        }

        function login_url(){
            return 'https://www.pinterest.com/oauth/?' . urldecode(http_build_query($this->params));;
        }

        function get_access_token($code){
            $auth = base64_encode($this->client_id . ':' . $this->client_secret);

            $payload = [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirect_uri
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->host."oauth/token");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'Authorization: Basic {'.$auth.'}',
                'Content-Type: application/x-www-form-urlencoded',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

            $server_output = curl_exec ($ch);

            curl_close ($ch);

            $result = json_decode($server_output, false);

            if( isset($result->message) ){
                throw new Exception($result->message); 
            }

            return $result;
        }

        function renew_access_token($refresh_token){
            $auth = base64_encode($this->client_id . ':' . $this->client_secret);

            $payload = [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'scope' => implode(",", $this->scopes)
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$this->host."oauth/token");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'Authorization: Basic {'.$auth.'}',
                'Content-Type: application/x-www-form-urlencoded',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

            $server_output = curl_exec ($ch);

            curl_close ($ch);

            $result = json_decode($server_output, false);

            if( isset($result->message) ){
                throw new Exception($result->message); 
            }

            return $result;
        }

        function set_access_token($access_token){
            $this->access_token = $access_token;
        }

        function get_user_info(){
            $params = []; 
            $result = $this->get("user_account");
            return $result;
        }

        function get_boards(){
            $params = [
                'page_size' => 100
            ]; 

            $result = $this->get("boards", $params);

            return $result;
        }

        /**
         * Set the access token
         *
         * @access public
         * @param  string   $token
         * @return void
         */
        public function setAccessToken($token)
        {
            $this->access_token = $token;
        }

        /**
         * Make a get request to the given endpoint
         *
         * @access public
         * @param  string   $endpoint
         * @param  array    $parameters
         * @return Response
         */
        public function get($endpoint, array $parameters = array())
        {
            if (!empty($parameters)) {
                $path = sprintf("%s/?%s", $endpoint, http_build_query($parameters));
            } else {
                $path = $endpoint;
            }

            return $this->execute("GET", sprintf("%s%s", $this->host, $path));
        }

        /**
         * Make a post request to the given endpoint
         *
         * @access public
         * @param  string   $endpoint
         * @param  array    $parameters
         * @return Response
         */
        public function post($endpoint, array $parameters = array(), $headers = array())
        {
            return $this->execute("POST", sprintf("%s%s", $this->host, $endpoint), $parameters, $headers);
        }

        /**
         * Make a put request to the given endpoint
         *
         * @access public
         * @param  string   $endpoint
         * @param  array    $parameters
         * @return Response
         */
        public function put($endpoint, array $parameters = array())
        {
            return $this->execute("PUT", sprintf("%s%s", $this->host, $endpoint), $parameters);
        }

        /**
         * Make a delete request to the given endpoint
         *
         * @access public
         * @param  string   $endpoint
         * @param  array    $parameters
         * @return Response
         */
        public function delete($endpoint, array $parameters = array())
        {
            return $this->execute("DELETE", sprintf("%s%s", $this->host, $endpoint) . "/", $parameters);
        }

        /**
         * Make an update request to the given endpoint
         *
         * @access public
         * @param  string   $endpoint
         * @param  array    $parameters
         * @param  array    $queryparameters
         * @return Response
         */
        public function update($endpoint, array $parameters = array(), array $queryparameters = array())
        {
            if (!empty($queryparameters)) {
                $path = sprintf("%s/?%s", $endpoint, http_build_query($queryparameters));
            } else {
                $path = $endpoint;
            }

            return $this->execute("PATCH", sprintf("%s%s", $this->host, $path), $parameters);
        }

        /**
         * Return the headers from the last request
         *
         * @return array
         */
        public function getHeaders()
        {
            return $this->headers;
        }

        /**
         * Execute the http request
         *
         * @access public
         * @param  string $method
         * @param  string $apiCall
         * @param  array $parameters
         * @param  array $headers
         * @return Response
         * @throws CurlException
         * @throws PinterestException
         */
        public function execute($method, $apiCall, array $parameters = array(), $headers = array())
        {
            // Check if the access token needs to be added
            if ($this->access_token != null) {
                $headers = array_merge($headers, array(
                    "Authorization: Bearer " . $this->access_token,
                ));
            }

            // Force cURL to not send Expect header to workaround bug with Akamai CDN not handling
            // this type of requests correctly
            $headers = array_merge($headers, array(
                "Expect:",
            ));

            // Setup CURL
            $ch = $this->curlbuilder->create();

            // Set default options
            $ch->setOptions(array(
                CURLOPT_URL             => $apiCall,
                CURLOPT_HTTPHEADER      => $headers,
                CURLOPT_CONNECTTIMEOUT  => 20,
                CURLOPT_TIMEOUT         => 30,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_SSL_VERIFYPEER  => false,
                CURLOPT_SSL_VERIFYHOST  => false,
                CURLOPT_HEADER          => false,
                CURLINFO_HEADER_OUT     => true
            ));

            switch ($method) {
                case 'POST':
                    $ch->setOptions(array(
                        CURLOPT_CUSTOMREQUEST   => "POST",
                        CURLOPT_POST            => 1,
                        CURLOPT_POSTFIELDS      => json_encode($parameters)
                    ));

                    if (!class_exists('\CURLFile') && defined('CURLOPT_SAFE_UPLOAD')) {
                        $ch->setOption(CURLOPT_SAFE_UPLOAD, false);
                    }
                    elseif (class_exists('\CURLFile') && defined('CURLOPT_SAFE_UPLOAD')) {
                        $ch->setOption(CURLOPT_SAFE_UPLOAD, true);
                    }

                    break;
                case 'DELETE':
                    $ch->setOption(CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;
                case 'PATCH':
                    $ch->setOptions(array(
                        CURLOPT_CUSTOMREQUEST   => "PATCH",
                        CURLOPT_POST            => count($parameters),
                        CURLOPT_POSTFIELDS      => $parameters
                    ));
                    break;
                default:
                    $ch->setOption(CURLOPT_CUSTOMREQUEST, "GET");
                    break;
            }

            // Execute request and catch response
            $response = $ch->execute();

            if ($response === false && !$ch->hasErrors()) {
                throw new CurlException("Error: Curl request failed");
            }
            else if($ch->hasErrors()) {
                throw new PinterestException('Error: execute() - cURL error: ' . $ch->getErrors(), $ch->getErrorNumber());
            }

            // Get headers from last request
            $this->headers = $ch->getHeaders();

            // Close curl resource
            $ch->close();

            // Return the response
            if (is_string($response)) {
                $response = json_decode($response, false);
            }

            return $response;
        }

    }
}
?>