<?php
/**
 *	This file is part of Allpay
 *
 * @author JasonHuang <>
 *
 * @package Allpay
 * @since Allpay Ver 1.0
**/

namespace payment\Allpay;

class AIO {

	/*
	//Alipay 必要參數
	$alipay_item_name   = $item_name;
	$alipay_item_counts = 1;
	$alipay_item_price  = $total_amt;
	$alipay_email       = 'stage_test@allpay.com.tw';
	$alipay_phone_no    = '0911222333';
	$alipay_user_name   = 'Stage Test';
	*/

    protected $AllLiveAction = "https://payment.allpay.com.tw/Cashier/AioCheckOut/V2";
    protected $AllTestAction = "https://payment-stage.allpay.com.tw/Cashier/AioCheckOut/V2";

    protected $EcLiveAction = "https://payment.ecpay.com.tw/Cashier/AioCheckOut/V2";
    protected $EcTestAction = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V2";

    public function __construct(){}

    public function _set($setParameArr = array(), $mode = false, $gateWay = "AllPay"){

        $this->parameters = array(
            "ReturnURL"         => $setParameArr['returnUrl'],
            "ClientBackURL"     => $setParameArr['clientBackUrl'],
            "OrderResultURL"    => $setParameArr['orderResultUrl'],
            "MerchantID"        => $setParameArr['MerchantID'],
            "MerchantTradeNo"   => "",
            "MerchantTradeDate" => "",
            "PaymentType"       => "aio",
            "TotalAmount"       => "",
            "TradeDesc"         => "",
            "ItemName"          => "網路訂單一筆",
            "ChoosePayment"     => "ALL",
            "NeedExtraPaidInfo" => "N",
        );

        $this->hashKey  = $setParameArr['HashKey'];
        $this->hashIv   = $setParameArr['HashIV'];
        $this->testMode = $mode;
        $this->gateWay  = $gateWay;
    }

	public function PaymentMethod(){
		return $PaymentMethod = array(
			"ALL"       => "不指定付款方式",
			"Credit"    => "信用卡付費",
			"WebATM"    => "網路 ATM",
			"ATM"       => "自動櫃員機",
			"CVS"       => "超商代碼",
			"BARCODE"   => "超商條碼",
			"Alipay"    => "支付寶",
			"Tenpay"    => "財付通",
			"TopUpUsed" => "儲值消費",
		);
	}

	public function PaymentExtend($paymentType = "ALL"){
		switch ($paymentType) {
        	case 'ALL':
        	case 'WebATM':
        	case 'TopUpUsed':
        		$paramsExtend = array();
        		break;
        	case 'Credit':
        		$paramsExtend = array(
        			"CreditInstallment" => 0, 		#分期期數，預設0(不分期)
                    "InstallmentAmount" => 0,		#使用刷卡分期的付款金額，預設0(不分期)
                    "Redeem"            => FALSE, 	#是否使用紅利折抵，預設false
                    "UnionPay"          => FALSE,	#是否為聯營卡，預設false;
                    "Language"          => '',		
                    "PeriodAmount"      => '',		#每次授權金額，預設空字串
                    "PeriodType"        => '',  	#週期種類，預設空字串
                    "Frequency"         => '',  	#執行頻率，預設空字串
                    "ExecTimes"         => '',		#執行次數，預設空字串
                    "PeriodReturnURL"   => ''
        		);
        		break;
        	case 'ATM':
        		$paramsExtend = array(
        			'ExpireDate'       => 3,  #繳費期限 (預設3天，最長60天，最短1天)
                    'PaymentInfoURL'   => '', #伺服器端回傳付款相關資訊。
                    'ClientRedirectURL'=> '',
        		);
        		break;
        	case 'CVS':
        	case 'BARCODE':
        		$paramsExtend = array(
        			'Desc_1'           =>'', #交易描述1 會顯示在超商繳費平台的螢幕上。預設空值
                    'Desc_2'           =>'', #交易描述2 會顯示在超商繳費平台的螢幕上。預設空值
                    'Desc_3'           =>'', #交易描述3 會顯示在超商繳費平台的螢幕上。預設空值
                    'Desc_4'           =>'', #交易描述4 會顯示在超商繳費平台的螢幕上。預設空值
                    'PaymentInfoURL'   =>'', #預設空值
                    'ClientRedirectURL'=>'', #預設空值
                    'StoreExpireDate'  =>''  #預設空值
        		);
        		break;
        	case 'Alipay':
        		$paramsExtend = array(
        			'Email'           => '',
                    'PhoneNo'         => '',
                    'UserName'        => '',
                    'AlipayItemName'  => '',
                    'AlipayItemCounts'=> '',
                    'AlipayItemPrice' => ''
        		);
        		break;
        	case 'Tenpay':
        		$paramsExtend = array(
        			'ExpireTime' => '' #付款截止時間只能帶入送出交易後的 72 小時(三天)之內時間。不填則預設為送出交易後的 72 小時。
        		);
        		break;
        }

        return $paramsExtend;
	}

	#產生訂單
	public function checkOut($params = array(), $paramsExtend = array()){

		if ($params == null){
            throw new GeneralException('Params are not set.');
        }

        $params = array_merge($this->parameters, $params);

        $params = array_merge($params, $paramsExtend);

        #資料排序 php 5.3以下不支援
        uksort($params, array($this, 'merchantSort'));

        $params['CheckMacValue'] = $this->_getMacValue($params);

        $Html .= '<form name="_AIOForm" method="post" action="'.$this->setActionMode().'">';
		foreach ($params as $key => $val) {
		    $Html .= "<input type='hidden' name='".$key."' value='".$val."'>";
		}
		$Html .= '</form>';
		$Html .= '<script>document._AIOForm.submit();</script>';
		
		sleep(1);
		return $Html;
	}

	#取得付款結果通知的方法
	public function checkOutFeedBack($params = array()){
        $arErrors = array();
        $arFeedback = array();
        $szCheckMacValue = '';
        // 重新整理回傳參數。
        foreach ($params as $keys => $value) {
            if ($keys != 'CheckMacValue') {
                if ($keys == 'PaymentType') {
                    $value = str_replace('_CVS', '', $value);
                    $value = str_replace('_Alipay', '', $value);
                    $value = str_replace('_Tenpay', '', $value);
                    $value = str_replace('_CreditCard', '', $value);
                }
                if ($keys == 'PeriodType') {
                    $value = str_replace('Y', 'Year', $value);
                    $value = str_replace('M', 'Month', $value);
                    $value = str_replace('D', 'Day', $value);
                }
                $arFeedback[$keys] = $value;
            }
        }

        $CheckMacValue = $this->_getMacValue($params);

        if ($CheckMacValue != $params['CheckMacValue']) {
            array_push($arErrors, 'CheckMacValue verify fail.');
        }
        if (sizeof($arErrors) > 0) {
            throw new GeneralException(join('- ', $arErrors));
        }
        
        return $arFeedback;
	}

	# 仿自然排序法
    protected function merchantSort($a, $b){
		return strcasecmp($a, $b);
	}

	# 路徑
	protected function setActionMode(){
        switch ($this->gateWay) {
            case 'AllPay':
                return $this->testMode ? $this->AllTestAction : $this->AllLiveAction;
                break;
            case 'EcPay':
                return $this->testMode ? $this->EcTestAction : $this->EcLiveAction;
                break;
        }
        
    }

	# 特殊字元置換
	protected function _replaceChar($value){
		$searchList  = array('%2d', '%5f', '%2e', '%21', '%2a', '%28', '%29');
		$replaceList = array('-', '_', '.', '!', '*', '(', ')');
		$value = str_replace($searchList, $replaceList, $value);
		
		return $value;
	}

	# 產生檢查碼
	protected function _getMacValue($formArr){
		$encodeStr = "HashKey=" . $this->hashKey;
		foreach ($formArr as $key => $value){
			$encodeStr .= "&" . $key . "=" . $value;
		}
		$encodeStr .= "&HashIV=" . $this->hashIv;
		$encodeStr = strtolower(urlencode($encodeStr));
		$encodeStr = $this->_replaceChar($encodeStr);

		// $sMacValue =  hash('sha256', $encodeStr);
		$sMacValue =  md5($encodeStr);

		return strtoupper($sMacValue);
	}
}


namespace payment\Allpay;

use Exception;

class GeneralException extends Exception{
	
	function __construct($value){
		print_r ($value);
	}
}

?>