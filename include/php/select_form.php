<?php
        $store_name = $_SESSION['user_name'];
        $page = 1;
    
?>
<h3>アカウント名：<?php echo $store_name ?></h3>
<h2>使い方</h2>
    <p>アイテムを選択(4つまで)し，生成するをクリックするだけ</p>
<form class = "choiceProduct" method="post" action="generate.php">
    <div class="production-container">
        <?php 
            do{
                $offset = 50*($page - 1);
                $base_url = 'https://suzuri.jp/api/v1/products?limit=50&offset='.$offset . '&userName=';
                
                $curl = curl_init($base_url.$store_name);
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
                curl_close($curl);
                $count = 0;
                foreach($decoded['products'] as $product){//foreachで商品一覧を作成 
                    $count += 1;?>

                    <div class="production">
                        <label><input type="checkbox" name="chakedProduct[]" value=<?php echo $product['id'] ?>>
                            <div class="production-info">
                                <div class="production-info_image"><?php echo '<img src=' . $product['sampleImageUrl'] . '>'?> </div>
                                <div class="production-info_name"><?php echo $product['title'] ?></div>
                                <div class="production-info_price"><?php echo $product['material']['price'] +  $product['sampleItemVariant']['price']?>円(税抜き)</div>
                            </div> <!-- production-info-->
                        </label>
                    </div><!-- production-->
            <?php } ?><!-- foreach-->
        <?php $page += 1; ?>
        <?php } while( $count == 50) ?><!-- do-->
    </div><!-- production-container-->
    <div class="fixed"> 
        <input type="submit" value="生成する" class="fixed">
    </div>
</form>
