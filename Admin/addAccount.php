<?php session_start();
//header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8

if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$identity = $_POST["identity"];
    @$account = $_POST["account"];
    @$pswd = $_POST["pswd"];

    if ($identity != 'none' && $account != '' && $pswd != '') { 
        $csvfile = './user_identity.csv';
        $line = array (
            $identity, $account, $pswd,
        );

        $fp = fopen($csvfile, 'a');

        fputcsv($fp, $line);

        fclose($fp);

        echo json_encode(array(
            'success' => true
        ));
    }  else{
        echo json_encode(array(
            'success' => false
        ));
    }
} else {
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>