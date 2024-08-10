<?php

function get_domain($url){
    if(filter_var($url, FILTER_VALIDATE_URL)){
        $parse_domain = parse_url($url);
        $real_domain = str_replace("www.", "", $parse_domain['host']);
        return $real_domain;
    }else{
        return false;
    }
}

function do_encrypt($message, $key, $encoded = false)
{
    $nonceSize = openssl_cipher_iv_length("aes-256-ctr");
    $nonce = openssl_random_pseudo_bytes($nonceSize);

    $ciphertext = openssl_encrypt(
        $message,
        "aes-256-ctr",
        $key,
        OPENSSL_RAW_DATA,
        $nonce
    );

    $encrypted = $nonce . $ciphertext;

    if ($encoded) {
        $encrypted = base64_encode($encrypted);
    }

    return $encrypted;
}

function license_helper() {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $domain = get_domain($url);

    $licensedata = '{
    "domain":"'.$domain.'","license":"Regular License","item_id":"21747459"
    }';

    $license = '{
        "status":"success",
        "item_id":"21747459",
        "license":"'.do_encrypt($licensedata, get_key(), true).'",
        "path":"",
        "version":"8.0.1",
        "is_main":"1",
        "file":"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"
    }';

    $encrypted_lic = do_encrypt($license, get_key(), true);
    $error = false;

    $result = $encrypted_lic;
    if(!$result){
        //echo "There seems to be a problem with your request. Please ensure that your server has enabled sufficient permissions to allow for the installation";
        $error = true;
    }

    $result_array = json_decode( $result , 1 );
    if( is_array( $result_array ) && isset( $result_array['status'] ) && $result_array['status'] == "error"){
        $error = true;
    }

    try {
        $result = do_decrypt($result, get_key(), true );
    } catch (Exception $e) {
        //echo "do_decrypt error";
        $error = true;
    }

    $result = json_decode($result);

    if(count((array)$result) != 7){
        //echo "array count error";
        $error = true;
    }

    if(!$error){
        return $encrypted_lic;
    }
    else {
        return false;
    }
}
