<?php
namespace Plugins\Payment\Controllers;

class Payment extends \CodeIgniter\Controller
{
    public function __construct(){
        file_put_contents(FCPATH."test.txt","Hello World. Testing!");
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }
    
    public function index( $ids = "", $plan_by = 1) {
        $configs = get_blocks("payment_button", false);
        $plan = get_payment_plan($ids, ($plan_by == "")?1:$plan_by);

        $items = [];
        if( ! empty($configs) ){
            $items = $configs;
            if( count($items) >= 2 ){
                usort($items, function($a, $b) {
                    if( isset($a['data']['position']) &&  isset($b['data']['position']) )
                        return $a['data']['position'] <=> $b['data']['position'];
                });
            }
        }

        if(empty($plan)) redirect_to( base_url("pricing") );

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Plugins\Payment\Views\content', ['items' => $items, "plan" => $plan])
        ];

        return view('Plugins\Payment\Views\index', $data);
    }

    public function coupon( $page = false ) {
        $coupon_code = post("coupon_code");
        $coupon = db_get("*", TB_COUPONS, ["code" => $coupon_code]);

        if(empty($coupon)){
            ms([
                "status" => "error",
                "message" => __("Invalid promo code")
            ]);
        }

        if( time() > $coupon->expiration_date ){
            ms([
                "status" => "error",
                "message" => __("The coupon code has already expired.")
            ]);
        }

        set_session(["coupon" => json_encode($coupon)]);

        ms([
            "status" => "success"
        ]);
    }

    public function cancel_subscription(){
        payment_stop_subscription();
    }

    public function successful( $page = false ) {
        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Plugins\Payment\Views\successful', [])
        ];

        return view('Plugins\Payment\Views\index', $data);
    }

    public function failed( $page = false ) {
        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Plugins\Payment\Views\failed', [])
        ];

        return view('Plugins\Payment\Views\index', $data);
    }

    public function cron()
    {
        if( get_option("email_payment_renewal_reminders", 0) ){
            $after_day = time();
            $before_day = time() + 3*86400;
            $users = db_fetch( "*", TB_USERS, "expiration_date >= {$after_day} AND expiration_date <= {$before_day}" );

            if($users){
                foreach ($users as $user) {
                    system_email($user->id, "renewal_reminders");
                }
            }

            _e("Success");
        }
    }
}