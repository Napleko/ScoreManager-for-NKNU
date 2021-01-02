<?php session_start();
//header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8

if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$index = $_POST["index"];
    
    $csvfile = './class.csv';
    $lines = count(file($csvfile));
    if ($index < $lines) { 
        $file=fopen($csvfile,'r');
        $tmpFile=fopen("./tmp.csv",'w');
        $row=1;
        while($data = fgetcsv($file, 1000, ",")){
            if(($row-1)!=$index){
                fputcsv($tmpFile, $data);       
            }
            $row++;
        }
        fclose($file);
        fclose($tmpFile);
        rename('./tmp.csv','class.csv');

        echo json_encode(array(
            'success' => true,
        ));
    }  else{
        echo json_encode(array(
            'success' => false,
        ));
    }
} else {
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>