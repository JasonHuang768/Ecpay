<?php
require_once "src/AIO.php";

$MerchantID        = $_REQUEST['MerchantID'];
$HashKey           = $_REQUEST['Hashkey'];
$HashIV            = $_REQUEST['HashIV'];
$ChoosePayment     = $_REQUEST['ChoosePayment'];
$MerchantTradeNo   = $_REQUEST['MerchantTradeNo'];
$MerchantTradeDate = $_REQUEST['MerchantTradeDate'];
$TotalAmount       = $_REQUEST['TotalAmount'];
$TradeDesc         = $_REQUEST['TradeDesc'];
$returnUrl         = "http://localhost/self/payment/Allpay/".$_REQUEST['returnUrl'];
$clientBackUrl     = "http://localhost/self/payment/Allpay/".$_REQUEST['clientBackUrl'];
$orderResultUrl    = "http://localhost/self/payment/Allpay/".$_REQUEST['orderResultUrl'];

$paymentGateWay    = $_REQUEST['paymentGateWay'];

$setParameArr = array(
	'MerchantID'     => $MerchantID,
	'HashKey'        => $HashKey,
	'HashIV'         => $HashIV,
	'returnUrl'      => $returnUrl,
	'clientBackUrl'  => $clientBackUrl,
	'orderResultUrl' => $orderResultUrl,
);

$params = array(
	"MerchantTradeNo"   => $MerchantTradeNo,
	"MerchantTradeDate" => $MerchantTradeDate,
	"TotalAmount"       => $TotalAmount,
	"TradeDesc"         => $TradeDesc,
	"ChoosePayment"     => $ChoosePayment,
);

$allpay = new payment\Allpay\AIO();

$allpay->_set($setParameArr, true, $paymentGateWay);

$paramsExtend = $allpay->PaymentExtend($ChoosePayment);

foreach ($paramsExtend as $key => $value) {
	if ($_REQUEST[$key]){
		$paramsExtend[$key] = $_REQUEST[$key];
	}else{
		unset($paramsExtend[$key]);
	}
}

$result = $allpay->checkOut($params, $paramsExtend);

print_r ($result);

?>