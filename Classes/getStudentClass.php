<?php 
if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$student = $_POST["student"];
    
    $csvfile = 'class.csv';
    $file = fopen($csvfile, "r");
    $classData = array();
    $classDataIndex = 0;
    $all = array();
    $allIndex = 0;
    while($data = fgetcsv($file, 1000, ",")){
        $classfile = './ClassData/'.$data[1].'.csv';

        $file2 = fopen($classfile, "r");
        while($st = fgetcsv($file2, 1000, ",")){
            if($st[0]==$student){
                $classData[$classDataIndex++] = array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5]);
            }
        }
        fclose($file2);
        $all[$allIndex++] = array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5]);
    }
    fclose($file);

    echo json_encode(array(
        'success' => true,
        'classes' => $classData,
        'allClasses' => $all,
        'account' => $student,
    ));
} else {
    echo json_encode(array(
        'success' => false
    ));
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>