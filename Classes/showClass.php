<?php 
if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$semester = $_POST["semester"];

    $csvfile = 'class.csv';
    
    $file = fopen($csvfile, "r");
    $row = 0;
    $classData = array();
    $classDataIndex = 0;
    if($semester==='all'){
        while ($data = fgetcsv($file, 1000, ",")) {
            $classData[$classDataIndex++] = array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$row);
            $row++;
        }
        fclose($file);
    }
    else{
        while ($data = fgetcsv($file, 1000, ",")) {
            if($semester==$data[0]){
                $classData[$classDataIndex++] = array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$row);
            }
            $row++;
        }
    }
    fclose($file);

    echo json_encode(array(
        'success' => true,
        'classes' => $classData
    ));
} else {
    echo json_encode(array(
        'success' => false
    ));
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>