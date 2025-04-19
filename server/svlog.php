<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

 $logPath = 'D:\@ServerMinecraft\servertest\logs\latest.log';
 $logcontent = file_get_contents($logPath);

 if($logcontent === false){
    echo "เกิดข้อผิดพลาด";
 }else{
    header('Content-Type: text/plain');
    echo $logcontent;
    // echo "<pre>$logcontent</pre>";
 }
?>