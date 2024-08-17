<?php

if(!function_exists("isZeroDecimalCurrency")){
    function isZeroDecimalCurrency($currency)
    {
        if (!is_string($currency)) {
            return false;
        }

        $zero_decimal_currencies = [
            "BIF", "CLP", "DJF", "GNF", "JPY", "KMF", "KRW",
            "MGA", "PYG", "RWF", "VND", "VUV", "XAF", "XOF", "XPF", 
            "HUF", "TWD"
        ];

        return in_array(strtoupper($currency), $zero_decimal_currencies);
    }
}

if (!function_exists("get_payment_plan")) {
    function get_payment_plan( $ids = "", $plan_by = "" ){
        if(!$ids) redirect_to( base_url("pricing") );
        $plan = db_get("*", TB_PLANS, ["ids" => $ids]);
        if(empty($plan)) redirect_to( base_url("pricing") );

        $price_monthly = $plan->price_monthly;
        $price_annually = $plan->price_annually;

        $price_monthly_tmp = $price_monthly;
        $price_annually_tmp = $price_annually;

        $coupon = false;
        if( get_session("coupon")){
            $coupon_info = (object) json_decode( get_session("coupon") ) ;
            $coupon_code = $coupon_info->code;
            if(in_array((int)$plan->id, json_decode($coupon_info->plans) )){
                $coupon = true;
                if($coupon_info->by == 2){
                    $price_monthly = number_format($price_monthly - $coupon_info->price, 2);
                    $price_annually = number_format($price_annually - $coupon_info->price, 2);

                    $price_monthly_coupon = ( $price_monthly_tmp - $coupon_info->price )/100;
                    $price_annually_coupon = (( $price_annually_tmp - $coupon_info->price )*12)/100;

                }else{
                    $price_monthly = number_format($price_monthly*(100 - $coupon_info->price)/100, 1);
                    $price_annually = number_format($price_annually*(100 - $coupon_info->price)/100, 2);

                    $price_monthly_coupon = ( $price_monthly_tmp * $coupon_info->price )/100;
                    $price_annually_coupon = ( $price_annually_tmp*12 * $coupon_info->price )/100;
                }
            }
        }

        $amount_monthly = $price_monthly;
        $amount_annually = $price_annually*12;

        $price_monthly_tmp = $price_monthly_tmp;
        $price_save = ( $price_annually_tmp*12 - $price_monthly_tmp*12 ) * -1;
        $price_annually_tmp = $price_monthly_tmp*12;
        
        $amount = $price_monthly;
        if($plan_by == 2){
            $amount = $price_annually*12;
            
        }else{
            $plan_by = 1;
            
        }

        $iszdc = isZeroDecimalCurrency( get_option("payment_currency", "USD") );

        $data = [
            "amount" => $iszdc?round($amount):$amount,
            "by" => $plan_by,
            "id" => $plan->id,
            "name"=> $plan->name,
            "desc" => $plan->description,
            "plan" => $plan,
            "coupon" => $coupon,
            "price_save" => $price_save,

            "amount_monthly" => $amount_monthly,
            "amount_annually" => $amount_annually,

            "price_monthly_default" => $price_monthly_tmp,
            "price_annually_default" => $price_annually_tmp,

            "price_monthly_default" => $price_monthly_tmp,
            "price_annually_default" => $price_annually_tmp,
        ];

        if( $coupon ){
            $data["coupon_info"] = $coupon_info;
            $data["price_monthly_coupon"] = $price_monthly_coupon;
            $data["price_annually_coupon"] = $price_annually_coupon;
        }

        return (object)$data;
    }
}

if (!function_exists("payment_save")) {
    function payment_save($data){
        $user_id = isset($data['uid'])?$data['uid']:get_user("id");
        $save = [
            'ids' => ids(),
            'uid' => $user_id,
            'plan' => $data['plan'],
            'type' => $data['type'],
            'transaction_id' => $data['transaction_id'],
            'amount' => $data['amount'],
            'by' => $data['by'],
            'created' => time()
        ];

        db_insert(TB_PAYMENT_HISTORY, $save);
        update_plan($data['plan'], $data['by'], $user_id);

        $is_subscription = get_user_data("is_subscription", 0, $user_id);
        update_user_data("is_subscription", 0, $user_id);

        $payment_getway = get_user_data("payment_getway", "", $user_id);
        update_user_data("payment_getway", $data['type'], $user_id);

        $subscription_id = get_user_data("subscription_id", "", $user_id);
        update_user_data("subscription_id", "", $user_id);

        if(get_option("email_payment_success", 0)){
            system_email($user_id, "payment_done");
        }

        redirect_to( base_url("payment/successful") );
    }
}

if (!function_exists("payment_save_subscription")) {
    function payment_save_subscription($data){
        $user_id = get_user("id");
        $save = [
            'ids' => ids(),
            'uid' => $user_id,
            'plan' => $data['plan'],
            'type' => $data['type'],
            'subscription_id' => $data['subscription_id'],
            'customer_id' => $data['customer_id'],
            'by' => $data['by'],
            'created' => time()
        ];
        db_insert(TB_PAYMENT_SUBSCRIPTIONS, $save);

        $is_subscription = get_user_data("is_subscription", 0);
        update_user_data("is_subscription", 1);

        $payment_getway = get_user_data("payment_getway", "");
        update_user_data("payment_getway", $data['type']);

        $subscription_id = get_user_data("subscription_id", "");
        update_user_data("subscription_id", $data['subscription_id']);

        if(get_option("email_payment_success")){
            system_email($user_id, "payment_done");
        }

        redirect_to( base_url("payment/successful") );
    }
}

if (!function_exists("payment_cancel_subscription")){
    function payment_cancel_subscription($subscription_id = ""){
        $subscription = db_get("*", TB_PAYMENT_SUBSCRIPTIONS, ["subscription_id" => $subscription_id]);
        if(!empty($subscription)){
            db_delete(TB_PAYMENT_SUBSCRIPTIONS, [ "subscription_id" => $subscription_id ]);
            
            $is_subscription = get_user_data("is_subscription", 0);
            update_user_data("is_subscription", 0, $subscription->uid);

            $payment_getway = get_user_data("payment_getway", "");
            update_user_data("payment_getway", "", $subscription->uid);

            $subscription_id = get_user_data("subscription_id", "");
            update_user_data("subscription_id", "", $subscription->uid);
        }
    }
}

if (!function_exists("payment_delete_supscription")){
    function payment_delete_supscription($subscription_id){
        $subscription = db_get("*", TB_PAYMENT_SUBSCRIPTIONS, ["subscription_id" => $subscription_id]);
        if(!empty($subscription)){
            db_delete(TB_PAYMENT_SUBSCRIPTIONS, ["subscription_id" => $subscription_id]);

            $is_subscription = get_user_data("is_subscription", 0, $subscription->uid);
            update_user_data("is_subscription", 0, $subscription->uid);

            $payment_getway = get_user_data("payment_getway", "", $subscription->uid);
            update_user_data("payment_getway", "", $subscription->uid);

            $subscription_id = get_user_data("subscription_id", "", $subscription->uid);
            update_user_data("subscription_id", "", $subscription->uid);
        }

    }
}

if (!function_exists("payment_stop_subscription")){
    function payment_stop_subscription(){
        $is_subscription = get_user_data("is_subscription", 0);
        $payment_getway = get_user_data("payment_getway", "");
        $subscription_id = get_user_data("subscription_id", "");
        if($is_subscription){

            $payment_getway = "Plugins\\".ucfirst($payment_getway)."\Models\\".ucfirst($payment_getway)."Model";
            $model = model($payment_getway);

            if(!$model){
                ms([
                    "status" => "error",
                    "message" => __("Have a problem on your request. Please contact us to get support")
                ]);
            }

            $result = $model->cancel_subscription();

            if($result){
                ms([
                    "status" => "success",
                    "message" => __("Success")
                ]);
            }else{
                ms([
                    "status" => "error",
                    "message" => __("Have a problem on your request. Please try again later")
                ]);
            }
        }
    }
}

if (!function_exists("payment_update_subscription")){
    function payment_update_subscription($data){
        $subscription = db_get("*", TB_PAYMENT_SUBSCRIPTIONS, [ "subscription_id" => $data["subscription_id"] ]);
        if(!empty($subscription)){
            $save = array(
                'ids' => ids(),
                'uid' => $subscription->uid,
                'plan' => $subscription->plan,
                'type' => $subscription->type,
                'transaction_id' => $data['transaction_id'],
                'amount' => $data['amount'],
                'by' => $subscription->by,
                'created' => time()
            );
            db_insert(TB_PAYMENT_HISTORY, $save);
            update_plan($subscription->plan, $subscription->by, $subscription->uid);
        }
    }
}

if (!function_exists("update_plan")) {
    function update_plan($plan, $by, $user_id = 0){
        $user = db_get("*", TB_USERS, "id = '".$user_id."'");
        if( $user )
        {
            $plan_old = db_get("*", TB_PLANS, ["id" => $user->plan]);
            $plan_new = db_get("*", TB_PLANS, ["id" => $plan]);

            $new_days  = 30;
            if($by == 2)
            {
                $new_days  = 365;
            }

            if( $plan_old )
            {
                if( time() < $user->expiration_date )
                {
                    $date_now = time();
                    $date_expiration = $user->expiration_date;
                    $diff = abs( $date_expiration - $date_now );
                    $left_days = floor( $diff / 86400 );

                    if($by == 2)
                    {
                        $day_added = round( ( $plan_old->price_annually / $plan_new->price_annually ) * $left_days );
                    }
                    else
                    {
                        $day_added = round( ( $plan_old->price_monthly / $plan_new->price_monthly ) * $left_days );
                    }

                    $expiration_date = time() + ($new_days + $day_added) * 24 * 60 * 60;
                }
                else
                {
                    $expiration_date = time() + $new_days * 24 * 60 * 60;
                }
            }
            else
            {
                $expiration_date = time() + $new_days * 24 * 60 * 60;
            }

            $data = array(
                "plan" => $plan_new->id,
                "expiration_date" => $expiration_date
            );

            db_update( TB_USERS, $data, ["id" => $user_id] );
            $team = db_get("*", TB_TEAM, ["owner" => $user_id] );
            
            if($team)
            {
                db_update( TB_TEAM, [ "permissions" => $plan_new->permissions, "pid" => $plan ], [ "id" => $team->id ] );
                if ($plan_old->id != $plan_new->id) {
                    db_update( TB_TEAM_MEMBER, [ "permissions" => $plan_new->permissions ], [ "team_id" => $team->id ] );
                }
            }
        }
    }
}

if(!function_exists("get_list_currency")){
    function get_list_currency(){
        return [
            'ALL' => 'Albania Lek',
            'AFN' => 'Afghanistan Afghani',
            'ARS' => 'Argentina Peso',
            'AWG' => 'Aruba Guilder',
            'AUD' => 'Australia Dollar',
            'AZN' => 'Azerbaijan New Manat',
            'BSD' => 'Bahamas Dollar',
            'BBD' => 'Barbados Dollar',
            'BDT' => 'Bangladeshi taka',
            'BYR' => 'Belarus Ruble',
            'BZD' => 'Belize Dollar',
            'BMD' => 'Bermuda Dollar',
            'BOB' => 'Bolivia Boliviano',
            'BAM' => 'Bosnia and Herzegovina Convertible Marka',
            'BWP' => 'Botswana Pula',
            'BGN' => 'Bulgaria Lev',
            'BRL' => 'Brazil Real',
            'BND' => 'Brunei Darussalam Dollar',
            'KHR' => 'Cambodia Riel',
            'CAD' => 'Canada Dollar',
            'KYD' => 'Cayman Islands Dollar',
            'CLP' => 'Chile Peso',
            'CNY' => 'China Yuan Renminbi',
            'COP' => 'Colombia Peso',
            'CRC' => 'Costa Rica Colon',
            'HRK' => 'Croatia Kuna',
            'CUP' => 'Cuba Peso',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Denmark Krone',
            'DOP' => 'Dominican Republic Peso',
            'XCD' => 'East Caribbean Dollar',
            'EGP' => 'Egypt Pound',
            'SVC' => 'El Salvador Colon',
            'EEK' => 'Estonia Kroon',
            'EUR' => 'Euro Member Countries',
            'FKP' => 'Falkland Islands (Malvinas) Pound',
            'FJD' => 'Fiji Dollar',
            'GHC' => 'Ghana Cedis',
            'GIP' => 'Gibraltar Pound',
            'GTQ' => 'Guatemala Quetzal',
            'GGP' => 'Guernsey Pound',
            'GYD' => 'Guyana Dollar',
            'HNL' => 'Honduras Lempira',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungary Forint',
            'ISK' => 'Iceland Krona',
            'INR' => 'India Rupee',
            'IDR' => 'Indonesia Rupiah',
            'IRR' => 'Iran Rial',
            'IMP' => 'Isle of Man Pound',
            'ILS' => 'Israel Shekel',
            'JMD' => 'Jamaica Dollar',
            'JPY' => 'Japan Yen',
            'JEP' => 'Jersey Pound',
            'KZT' => 'Kazakhstan Tenge',
            'KPW' => 'Korea (North) Won',
            'KRW' => 'Korea (South) Won',
            'KGS' => 'Kyrgyzstan Som',
            'LAK' => 'Laos Kip',
            'LVL' => 'Latvia Lat',
            'LBP' => 'Lebanon Pound',
            'LRD' => 'Liberia Dollar',
            'LTL' => 'Lithuania Litas',
            'MKD' => 'Macedonia Denar',
            'MYR' => 'Malaysia Ringgit',
            'MUR' => 'Mauritius Rupee',
            'MXN' => 'Mexico Peso',
            'MNT' => 'Mongolia Tughrik',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Namibia Dollar',
            'NPR' => 'Nepal Rupee',
            'ANG' => 'Netherlands Antilles Guilder',
            'NZD' => 'New Zealand Dollar',
            'NIO' => 'Nicaragua Cordoba',
            'NGN' => 'Nigeria Naira',
            'NOK' => 'Norway Krone',
            'OMR' => 'Oman Rial',
            'PKR' => 'Pakistan Rupee',
            'PAB' => 'Panama Balboa',
            'PYG' => 'Paraguay Guarani',
            'PEN' => 'Peru Nuevo Sol',
            'PHP' => 'Philippines Peso',
            'PLN' => 'Poland Zloty',
            'QAR' => 'Qatar Riyal',
            'RON' => 'Romania New Leu',
            'RUB' => 'Russia Ruble',
            'SHP' => 'Saint Helena Pound',
            'SAR' => 'Saudi Arabia Riyal',
            'RSD' => 'Serbia Dinar',
            'SCR' => 'Seychelles Rupee',
            'SGD' => 'Singapore Dollar',
            'SBD' => 'Solomon Islands Dollar',
            'SOS' => 'Somalia Shilling',
            'ZAR' => 'South Africa Rand',
            'LKR' => 'Sri Lanka Rupee',
            'SEK' => 'Sweden Krona',
            'CHF' => 'Switzerland Franc',
            'SRD' => 'Suriname Dollar',
            'SYP' => 'Syria Pound',
            'TWD' => 'Taiwan New Dollar',
            'THB' => 'Thailand Baht',
            'TTD' => 'Trinidad and Tobago Dollar',
            'TRY' => 'Turkey Lira',
            'TRL' => 'Turkey Lira',
            'TVD' => 'Tuvalu Dollar',
            'UAH' => 'Ukraine Hryvna',
            'GBP' => 'United Kingdom Pound',
            'USD' => 'United States Dollar',
            'UYU' => 'Uruguay Peso',
            'UZS' => 'Uzbekistan Som',
            'VEF' => 'Venezuela Bolivar',
            'VND' => 'Viet Nam Dong',
            'YER' => 'Yemen Rial',
            'ZWD' => 'Zimbabwe Dollar'
        ];
    }
}