<?php session_start();
//header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8

if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$oldCode = $_POST["oldCode"];
    @$newCode = $_POST["newCode"];
    @$name = $_POST["name"];
    @$professor = $_POST["professor"];
    @$credit = $_POST["credit"];
    @$category = $_POST["category"];
    
    $csvfile = './class.csv';
    $hasCode = false;
    $file=fopen($csvfile,'r');
    $tmpFile=fopen("./tmp.csv",'w');
    $row=1;
    while($data = fgetcsv($file, 1000, ",")){
        if($data[1]==$oldCode){
            $data[1] = $newCode;
            $data[2] = $name;
            $data[3] = $professor;
            $data[4] = $credit;
            $data[5] = $category;
            fputcsv($tmpFile, $data);
            $hasCode = true;
        }
        else{
            fputcsv($tmpFile, $data);
        }
        $row++;
    }
    fclose($file);
    fclose($tmpFile);
    rename('./tmp.csv','class.csv');

    if($hasCode){
        echo json_encode(array(
            'success' => true,
        ));
    }
    else{
        echo json_encode(array(
            'success' => false,
        ));
    }
} else {
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>