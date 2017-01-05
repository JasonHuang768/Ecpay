<?php

/**
 * 完成付款的伺服器結果頁面
 */

foreach ($_REQUEST as $key => $value) {
    $data = $key." = ".$value."\n========================================================\n";
    $fh = fopen("paymentInfo.txt", 'a+');
    fwrite($fh, $data);
    fclose($fh);
}

?>