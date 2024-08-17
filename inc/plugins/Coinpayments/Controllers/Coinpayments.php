<?php
namespace Plugins\Coinpayments\Controllers;

class Coinpayments extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');

        $this->public_key = get_option("coinpayments_public_key");
        $this->private_key = get_option("coinpayments_private_key");
        if ( uri("segment", 2) != "ipn" ) {
            $this->plan = get_payment_plan( uri("segment", 3), uri("segment", 4) );
            if( !get_option("coinpayments_status", 0) || empty($this->plan) || $this->public_key == "" || $this->private_key == "" ){
                redirect_to( base_url() );
            }
        }

        $this->cps_api = new \CoinpaymentsAPI($this->private_key, $this->public_key, 'json');
    }

    public function index($ids = "")
    {
        try {
            if(!get_user("id")){
                redirect_to( base_url("login"), true);
            }

            if(get_user_data("is_subscription", 0)){
                $error = __("You are using the monthly payment plan. Cancel it if you want to change the package or change your payment method.");
                redirect_to( base_url( "profile/index/plan?error=".urlencode($error) ) );
            }

            $currency = get_option('payment_currency', 'USD');
            $buyer_email = get_user("email");
            $ipn_url = get_module_url("webhook");

            $transaction_response = $this->cps_api->CreateSimpleTransactionWithConversion($this->plan->amount, $currency, get_option("coinpayments_public_coin", "BTC"), $buyer_email, $ipn_url);

            if($transaction_response['error'] == 'ok'){
                $user_id = get_user("id");
                db_delete(TB_COINPAYMENTS_HISTORY, ["user" => $user_id]);
                db_insert(TB_COINPAYMENTS_HISTORY, [
                    "ids" => ids(),
                    "user" => $user_id,
                    "plan_id" => $this->plan->id,
                    "plan_by" => $this->plan->by,
                    "txn_id" => $transaction_response['result']['txn_id'],
                    "coin_amount" => $transaction_response['result']['amount'],
                    "amount" => $this->plan->amount,
                ]);
                redirect_to( $transaction_response['result']['checkout_url'] );
            }else{
                $error = [
                    "status" => "error",
                    "message" => $transaction_response['error']
                ];

                redirect_to( base_url("payment/failed?".http_build_query($error) ) );
            }
        }catch (\PayPal\Exception\PayPalConnectionException $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];

            redirect_to( base_url("payment/failed?".http_build_query($error) ) );
        }
    }

    public function ipn(){
        try {
            $cp_merchant_id = get_option("coinpayments_merchant_id", "");
            $cp_ipn_secret = get_option("coinpayments_ipn_secrect", "");
            $order_currency = get_option('payment_currency', 'USD');
            if($cp_merchant_id == "" || $cp_ipn_secret == ""){
                return false;
            }

            if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
                die('IPN Mode is not HMAC');
            }

            if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
                die('No HMAC signature sent.');
            }

            $request = file_get_contents('php://input');
            if ($request === FALSE || empty($request)) {
                die('Error reading POST data');
            }

            if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
                die('No or incorrect Merchant ID passed');
            }

            $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
            if ($hmac != $_SERVER['HTTP_HMAC']) {
                die('HMAC signature does not match');
            }

            // HMAC Signature verified at this point, load some variables.
            $ipn_type = $_POST['ipn_type'];
            $txn_id = $_POST['txn_id'];
            $amount1 = floatval($_POST['amount1']);
            $amount2 = floatval($_POST['amount2']);
            $currency1 = $_POST['currency1'];
            $currency2 = $_POST['currency2'];
            $status = intval($_POST['status']);
            $status_text = $_POST['status_text'];

            // Check the original currency to make sure the buyer didn't change it.
            if ($currency1 != $order_currency) {
                die('Original currency mismatch!');
            }

            if ($status >= 100 || $status == 2) {
                $payment_request = db_get("*", TB_COINPAYMENTS_HISTORY, ["txn_id" => $txn_id]);

                if ($amount1 < $payment_request->amount) {
                    die('Amount is less than order total!');
                }

                $data = [
                    'type' => 'coinpayments',
                    'plan' => $payment_request->plan_id,
                    'transaction_id' => $txn_id,
                    'amount' => $amount1,
                    'by' => $payment_request->plan_by,
                    'uid' => $payment_request->user
                ];

                db_delete(TB_COINPAYMENTS_HISTORY, ["user" => $payment_request->user]);
                payment_save($data);
            } else if ($status < 0) {
                die('Payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent');
            } else {
                die('Payment is pending, you can optionally add a note to the order page');
            }   
            die('IPN OK');
        } catch (\Exception $e) {}
    }
}