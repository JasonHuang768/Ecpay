<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Allpay</title>
        <link rel="stylesheet" href="css/style.css" />
        <style type="text/css">
            body {min-width: 360px;}   
        </style>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
	<body>
		<header>
	        <div class="container">
	            <div class="navbar">
	                <div class="navbar-header">
	                    <a class="navbar-toggle"></a>
	                    <a class="navbar-brand" href="index.php">Allpay API</a>
	                </div>
	            </div>
	        </div>
	    </header>
	    <div class="container">
	        <ul class="step">
	            <li class="step-item active">
	                <h6 class="step-title">1. 訂單確認與付款</h6>
	                <p class="step-text">Payment Reserve</p>
	            </li>
	        </ul>
	    </div>
	    <div class="container">
	        <form class="form-horizontal" id="reserveForm" method="POST" action="reserve.php">
	            <div class="panel">
	                <div class="panel-header">
	                    <h3 class="panel-title">商家資料</h3>
	                </div>
	                <div class="panel-box">
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">MerchantID</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="MerchantID" value="2000132" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">Hashkey</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="Hashkey" value="5294y06JbISpM5x9" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">HashIV</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="HashIV" value="v77hoKGq4kWxNNIS" required>
	                        </div>
	                    </div>
	                </div>
	            </div>                
	            <div class="panel">
	                <div class="panel-header">
	                    <h3 class="panel-title">訂單資料</h3>
	                </div>
	                <div class="panel-box">
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">訂單編號</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="MerchantTradeNo" value="{VALUE_O_NO}" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">交易時間</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="MerchantTradeDate" value="{VALUE_O_DATE}" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">訂單金額</label>
	                        <div class="ctrls col-9">
	                            <div class="input-grp">
	                                <span class="adorn">TWD</span>
	                                <input type="text" class="ctrl-input" name="TotalAmount" value="180" required>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">交易描述</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="TradeDesc" value="網路訂單一筆" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">returnUrl(伺服器接收)</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="returnUrl" value="return.php" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">clientBackUrl(返回頁)</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="clientBackUrl" value="clientBack.php" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">orderResultUrl(結果頁)</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="orderResultUrl" value="orderResult.php" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
                            <label class="ctrl-label col-3">付款閘道</label>
                            <div class="ctrls col-9">
                                <div class="kui-opts">
                                	<label class="kui-opt">
                                        <input type="radio" name="paymentGateWay" value="EcPay" checked>
                                        <span class="kui-opt-input">ECPay</span>
                                    </label>
                                	<label class="kui-opt">
                                        <input type="radio" name="paymentGateWay" value="AllPay">
                                        <span class="kui-opt-input">AllPay</span>
                                    </label>
                                </div>
                            </div>
                        </div>
	                    <div class="ctrl-grp columns-12">
                            <label class="ctrl-label col-3">交易類型</label>
                            <div class="ctrls col-9">
                                <div class="kui-opts">
                                	<!-- START BLOCK : PAYMENT_ZONE -->
                                	<label class="kui-opt">
                                        <input type="radio" name="ChoosePayment" value="{TAG_KEY}" {TAG_CHECKED}>
                                        <span class="kui-opt-input">{TAG_VALUE}</span>
                                    </label>
                                	<!-- END BLOCK : PAYMENT_ZONE -->
                                </div>
                            </div>
                        </div>
	                </div>
	                <div class="panel" id="cvs_barcode" style="display: none;">
		                <div class="panel-header">
		                    <h3 class="panel-title">相關資料</h3>
		                </div>
		                <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">交易描述1</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="Desc_1" value="交易描述1" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">交易描述2</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="Desc_2" value="交易描述2" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">交易描述3</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="Desc_3" value="交易描述3" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">交易描述4</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="Desc_4" value="交易描述4" required>
	                        </div>
	                    </div>
	                    <div class="ctrl-grp columns-12">
	                        <label class="ctrl-label col-3">PaymentInfoURL</label>
	                        <div class="ctrls col-9">
	                            <input type="text" class="ctrl-input" name="PaymentInfoURL" value="http://localhost/self/payment/Allpay/PaymentInfo.php" placeholder="您要收到付款相關資訊的伺服器端網址" required>
	                        </div>
	                    </div>
		            </div>
	                <div class="panel">
		                <div class="panel-header">
		                    <h3 class="panel-title">操作</h3>
		                </div>
		                <div class="ctrl-grp columns-12">
	                        <div class="ctrls col-9 col-offset-3"><input type="submit" value="確認付款"></div>
	                    </div>
		            </div>
	            </div>
	        </form>
	    </div>
	</body>
</html>
<script>
	$("input[name=ChoosePayment]").click(function(e){
		var Payment  	 = $(this).val();
			// t            = new Date();
			// getYear      = t.getFullYear().toString();
			// getthisMonth = t.getMonth() + 2;

		if (Payment == "CVS" || Payment == "BARCODE"){
			$("#cvs_barcode").fadeIn();
		}else{
			$("#cvs_barcode").fadeOut();
		}

	});
</script>