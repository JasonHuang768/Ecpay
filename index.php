<?php
require_once "src/AIO.php";
require_once "TP/class.TemplatePower.inc.php";

$tpl = new TemplatePower("view/index.tpl");
$tpl->prepare();

$allpay = new payment\Allpay\AIO();

$PaymentMethod = $allpay->PaymentMethod();

foreach ($PaymentMethod as $key => $value) {
	$tpl->newBlock("PAYMENT_ZONE");
	$tpl->assign(array(
		"TAG_CHECKED" => ($key == "ALL")?"CHECKED":"",
		"TAG_KEY"     => $key,
		"TAG_VALUE"   => $value,
	));
}

$tpl->assignGlobal(array(
	"VALUE_O_NO"   => "Test".time(),
	"VALUE_O_DATE" => date("Y/m/d H:i:s"),
));

$tpl->printToScreen();

?>