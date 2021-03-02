<?php
    $authorize_prefix_url = 'https://suzuri.jp/oauth/authorize';//認可リクエスト先
    $oauth_parametrs = [
       "client_id" => 'xxxxxxxxxxxxxxxxxxxx',
        "scope" => 'read',  // 権限 read ,write
        "redirect_uri" => 'https://creator-support-tool.yuykyu.net/callback.php', // redirect_uri
        "response_type" => 'code', //response_typeは必ずcode
    ];
?>