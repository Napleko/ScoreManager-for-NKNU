<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$oldCode = $_POST["oldCode"];
    @$newCode = $_POST["newCode"];
    @$name = $_POST["name"];
    @$semester = $_POST["semester"];
    
    $csvfile = '../Admin/user_identity.csv';

    $file=fopen($csvfile,'r');
    $tmpFile=fopen("tmp2.csv",'w');
    $row=0;
    while($data = fgetcsv($file, 1000, ",")){
        if($data[1]==$oldCode){
            $data[1] = $newCode;
            $data[3] = $name;
            $data[4] = $semester;
            fputcsv($tmpFile, $data);
        }
        else{
            fputcsv($tmpFile, $data);
        }
        $row++;
    }
    fclose($file);
    fclose($tmpFile);
    rename('tmp2.csv','../Admin/user_identity.csv');

    echo json_encode(array(
        'success' => true
    ));
} else {
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>