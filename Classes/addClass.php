<?php session_start();
//header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8

if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$semester = $_POST["semester"];    //學期
    @$code = $_POST["code"];  //代碼
    @$name = $_POST["name"];  //名稱
    @$professor = $_POST["professor"];  //教授
    @$credit = $_POST["credit"];  //學分
    @$category = $_POST["category"];    //類型

    if ($code != '' && $name != '' && $professor != '' && $credit != '' && $category != '') { 
        $csvfile = './class.csv';
        $line = array (
            $semester,$code, $name, $professor, $credit, $category
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