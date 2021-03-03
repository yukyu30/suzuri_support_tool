<?php
    session_start();
    require ("../../private/suzuri_config_authorize_req.php");
    require ("../../private/suzuri_config_token_req.php");
    
    $token_req_data = http_build_query($token_parameters, "", "&");
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_req_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $token_req_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    $token_info = curl_exec($ch);
    $decoded_token_info = json_decode($token_info, true);
    $token = $decoded_token_info['access_token'];
    $_SESSION['token'] = $token;
    curl_close($ch);

    $base_url = 'https://suzuri.jp/api/v1/user';
    $curl = curl_init($base_url);
    $option = [
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer '.$_SESSION['token'],  //APIキー
            'Content-Type: application/json',
            ],
    ];
    curl_setopt_array($curl, $option);
    $json = curl_exec($curl);
    $decoded = json_decode($json,true);
    $_SESSION['user_name'] = $decoded['user']['name'];
    curl_close($curl);
    header('Location: https://creator-support-tool.yukyu.net/');
?>