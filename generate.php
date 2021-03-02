<?php
    session_start();
    $baseImage = imagecreatefrompng('./original_img/bg_1.png');
    $chakedProduct = $_POST['chakedProduct'];
    $i= 1;

    $positionX_array = [
        1 => 0,
        2 => 0,
        3 => 323,
        4 =>323,
    ];
    $positionY_array = [
        1 => 0,
        2 => 323,
        3 => 0,
        4 =>323,
    ];
    foreach ($chakedProduct as $value){
        if($i == 5){
        break;
        }
        $c = $value;
        $base_url = 'https://suzuri.jp/api/v1/products/' . $c;

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
        $product = $decoded['product'];

        imageLayerEffect($baseImage, IMG_EFFECT_ALPHABLEND);// 合成する際、透過を考慮する
        $pngImageUrl = str_replace('.jpg', '.png', $product['sampleImageUrl']);
        $img = imagecreatefrompng($pngImageUrl);

        //画像サイズを取得する
        $sx = imagesx($img);
        $sy = imagesy($img);
        //
        
        imagecopy($baseImage, $img, $positionX_array[$i], $positionY_array[$i], 0, 0, $sx, $sy); // 合成する
        $i += 1 ;
        imagedestroy($img);
        
    }
        curl_close($curl); 
        $date = date('y-m-j-h-i-s');
        $imagename = './generated_img/' .  $_SESSION['user_name'] . '_' . $date . '.png';
        imagepng( $baseImage, $imagename);
        imagedestroy($baseImage);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include( $_SERVER['DOCUMENT_ROOT'] . '/include/html/head.html'); ?>
        <link rel="stylesheet" type="text/css" href="./css/generate.css">
    </head>
    <body>
        <div id="header">
            <?php include( $_SERVER['DOCUMENT_ROOT'] . '/include/html/header.html'); ?>
        </div><!-- header-->
            <div id = "main">
            <h1>PR画像生成ツール</h1>
            <h3>アカウント名：<?php echo $_SESSION['user_name'] ?></h3>
                <img class ="created_image" src="<?php echo $imagename ?>">
                <div class="download_button">
                        <a class="button" href="<?php echo $imagename ?>" download>保存する</a>
                </div>
                <div class="back_button">
                        <a class="back_button-button" href="https://creator-support-tool.yukyu.net/">アイテム選びに戻る</a>
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
                                $shop_url = "https://suzuri.jp/" . $suffix;
                ?>
                                <div class="generatedimg"><a href="<?php echo $shop_url ?>"  target="_blank" rel="noopener noreferrer" >
                                    <div class="generatedimg-info">
                                        <div class="generatedimg-info_image"><img src="<?php echo $path ?>"></div>
                                        <div class="generatedimg-info_name"><p><?php echo $suffix ?>さん</p></div>
                                    </div>
                                </a></div>
                <?php              // $path: ファイルのパス
                            }
                        }
                    }
                ?>
                 </div> 
            </div><!-- main-->
            <div id="footer">
                <?php include( $_SERVER['DOCUMENT_ROOT'] . '/include/html/footer.html'); ?>
            </div>
    </body>
</html>

