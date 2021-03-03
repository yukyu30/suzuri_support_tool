<?php
    session_start();
    require ("../../private/suzuri_config_authorize_req.php");
    $oauth_parametrs = http_build_query($oauth_parametrs, "", "&");
    $authorize_request_url = $authorize_prefix_url . "?" . $oauth_parametrs;
    $totalPage = 6;
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include( $_SERVER['DOCUMENT_ROOT'] . '/include/html/head.html'); ?>
        <link rel="stylesheet" type="text/css" href="./css/index.css">
    </head>
    <body>
        <div id="header">
            <?php include( $_SERVER['DOCUMENT_ROOT'] . '/include/html/header.html'); ?>
        </div><!-- header-->
            <div id = "main">
                <h1>PR画像生成ツール</h1>
                <?php if($_SESSION['token'] == NULL){ ?>
                    <h2>注意事項</h2>
                        <p>生成した画像はサーバーに残り，その画像は公開されます</p>
                        <p>画像は1日から2日後に自動的に削除されます</p>
                        <p>本ウェブサイトのご利用に起因するソフトウェア，ハードウェア上の事故および不具合，その他損害について責任を負いません</p>
                    <h2>SUZURIと連携する</h2>
                        <p>上記の注意事項を読んでから連携をお願いします．商品情報やユーザー名等を取得するためSUZURIと連携を行う必要があります．</p>
                        <div class="connect_button">
                            <a class="button" href="<?php echo $authorize_request_url ?>">SUZURIと連携する</a>
                        </div>  
                        <h2>みんなが生成した画像</h2>
                    <div class="generatedimg-container">
                        <?php
                            $dir = "./generated_img/" ;
                            if( is_dir( $dir ) && $handle = opendir( $dir ) ) {
                                while( ($file = readdir($handle)) !== false ) {
                                    if( filetype( $path = $dir . $file ) == "file" ) {
                                        $cut = 22;//カットしたい文字数
                                        $suffix = substr( $file , 0 , strlen($file)-$cut );
                                        $shop_url = "https://suzuri.jp/" . $suffix; ?>
                                        <div class="generatedimg"><a href="<?php echo $shop_url ?>" >
                                            <div class="generatedimg-info">
                                                <div class="generatedimg-info_image"><img src="<?php echo $path ?>"></div>
                                                <div class="generatedimg-info_name"><p><?php echo $suffix ?>さん</p></div>
                                            </div>
                                        </a></div>   
                                <?php }
                            }
                        }?>
                 </div> 
                </div>
                <?php } else{
                    include('./include/php/select_form.php'); 
                    } ?>
                
            </div>
            
            <div id="footer">
                <?php include( $_SERVER['DOCUMENT_ROOT'] . '/include/html/footer.html'); ?>
            </div>
    </body>
</html>