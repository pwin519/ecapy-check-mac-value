<?php

//git test
	
	/* 0. 訂單資訊 */

	$str = 'TradeDesc=good to drink&PaymentType=aio&MerchantTradeDate=2013/03/12 15:30:23&MerchantTradeNo=ecpay20130312153023&MerchantID=2000132&ReturnURL=https://www.ecpay.com.tw/receive.php&ItemName=Apple iphone 7 手機殼&TotalAmount=1000&ChoosePayment=ALL&EncryptType=1';

	/* 1. 將每個參數依 A-Z 排序 */

	$tmp_str = explode("&", $str);
	sort($tmp_str);
	$new_str = "";
	for($i = 0; $i < count($tmp_str); $i++) {
		if($i == count($tmp_str) - 1) {
			$new_str .= $tmp_str[$i];
		} else {
			$new_str .= $tmp_str[$i].'&';
		}
	}
	// 此時 $new_str(String) 以照a-z排序

	/* 2. 頭加上 HashKey，尾加上HashIV */

	$HASH_KEY = '5294y06JbISpM5x9';
	$HASH_IV = 'v77hoKGq4kWxNNIS';
	$new_str = 'HashKey='.$HASH_KEY.'&'.$new_str.'&HashIV='.$HASH_IV;
	// 此時 $new_str(String) 以加入 hash 值

	/* 3. 進行 URL encode */

	$new_str = urlencode($new_str);

	/* 4. 所有英文字元轉為小寫 */

	$new_str = strtolower($new_str);

	/* 5. 處理特殊字元(需與 .NET URL Encode 相符) */

	$new_str = str_replace('%2d', '-', $new_str);
	$new_str = str_replace('%5f', '_', $new_str);
	$new_str = str_replace('%2e', '.', $new_str);
	$new_str = str_replace('%21', '!', $new_str);
	$new_str = str_replace('%2a', '*', $new_str);
	$new_str = str_replace('%28', '(', $new_str);
	$new_str = str_replace('%29', ')', $new_str);
	$new_str = str_replace('%20', '+', $new_str);

	/* 6. 使用 SHA-256 雜湊 */

	$hash_value = hash('sha256', $new_str);

	/* 7. 所有英文字元轉為大寫 */

	$hash_value = strtoupper($hash_value);

	// $hash_value 即為檢核碼

	echo $hash_value;

?>

