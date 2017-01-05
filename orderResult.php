<?php

/**
 * 完成付款的瀏覽器結果頁面
 */

foreach ($_REQUEST as $key => $value) {
    $data = $key." = ".$value."\n========================================================\n";
    $fh = fopen("paymentInfo.txt", 'a+');
    fwrite($fh, $data);
    fclose($fh);
}

require_once "src/AIO.php";

$MerchantID = "2000132";
$HashKey    = "5294y06JbISpM5x9";
$HashIV     = "v77hoKGq4kWxNNIS";

$setParameArr = array(
    'MerchantID'     => '2000132',
    'HashKey'        => '5294y06JbISpM5x9',
    'HashIV'         => 'v77hoKGq4kWxNNIS',
    'returnUrl'      => '',
    'clientBackUrl'  => '',
    'orderResultUrl' => '',
);

$allpay = new payment\Allpay\AIO();

$allpay->_set($setParameArr, true);

/* 取得回傳參數 */
$arFeedback = $allpay->checkOutFeedBack($_REQUEST);

/* 檢核與變更訂單狀態 */
if (sizeof($arFeedback) > 0) {
    foreach ($arFeedback as $key => $value) {
        switch ($key){
            /* 支付後的回傳的基本參數 */
            case "MerchantID": $szMerchantID = $value; break;
            case "MerchantTradeNo": $szMerchantTradeNo = $value; break;
            case "PaymentDate": $szPaymentDate = $value; break;
            case "PaymentType": $szPaymentType = $value; break;
            case "PaymentTypeChargeFee": $szPaymentTypeChargeFee = $value; break;
            case "RtnCode": $szRtnCode = $value; break;
            case "RtnMsg": $szRtnMsg = $value; break;
            case "SimulatePaid": $szSimulatePaid = $value; break;
            case "TradeAmt": $szTradeAmt = $value; break;
            case "TradeDate": $szTradeDate = $value; break;
            case "TradeNo": $szTradeNo = $value; break;
            case "PaymentNo": $szPaymentNo = $value; break;//超商代碼
            case "vAccount": $szVirtualAccount = $value; break;//ATM 虛擬碼
            default: break;
        }
    }
    // 其他資料處理。
    if(substr($szPaymentType, 0, 3)=='CVS'){//若付款方式為 超商代碼
        //在這裡把超商代碼存進你的訂單資料表中
    }else if(substr($szPaymentType, 0, 3)=='ATM'){//若付款方式為ATM 虛擬碼
        //在這裡把ATM虛擬碼存進你的訂單資料表中
    }else{
        //寫入付款方式
    }
    print '1|OK';
} else {
	print '0|Fail';
}

?>