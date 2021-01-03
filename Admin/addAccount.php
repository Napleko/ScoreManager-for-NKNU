<?php session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$identity = $_POST["identity"];
    @$account = $_POST["account"];
    @$pswd = $_POST["pswd"];
    @$name = $_POST["name"];

    if ($identity != 'none' && $account != '' && $pswd != '' && $name != '') { 
        $csvfile = './user_identity.csv';

        $line = array (
            $identity, $account, $pswd, $name
        );
        if($identity==='st'){
            $line = array (
                $identity, $account, $pswd, $name, 0
            );
        }

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