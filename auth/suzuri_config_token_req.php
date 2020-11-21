<?php
    $token_req_url = 'https://suzuri.jp/oauth/token';//トークンリクエスト先
    $token_parameters =[
        "grant_type" => 'authorization_code',//grant_type
        "code" => $_GET["code"],//code リダイレクトの際にURIに付与された認可コード
        "redirect_uri" => $oauth_parametrs["redirect_uri"],//redirect_uri
        "client_id" => $oauth_parametrs["client_id"],//client_id
        "client_secret" => 'XXXXXXXXXXXXX',//client_secret
    ];
?>