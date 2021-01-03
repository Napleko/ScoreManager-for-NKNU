<?php 
if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$Code = $_POST["Code"];
    @$Student = $_POST["Student"];
    
    $csvfile = './ClassData/'.$Code.'.csv';
    $tmpFile = './ClassData/tmp'.$Code.'.csv';
    $file = fopen($csvfile, "r");
    $tmp = fopen($tmpFile, "w");
    while($data = fgetcsv($file, 1000, ",")){
        if($data[0]==$Student){
            continue;
        }
        fputcsv($tmp, $data);
    }
    fclose($file);
    fclose($tmp);
    rename($tmpFile,$csvfile);

    echo json_encode(array(
        'success' => true
    ));
} else {
    echo json_encode(array(
        'success' => false
    ));
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>