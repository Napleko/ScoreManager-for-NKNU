<?php 
if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$student = $_POST["student"];
    @$class = $_POST["class"];
    
    if($class==''){
        echo json_encode(array(
            'success' => false
        ));
    }
    else{
        $csvfile = './ClassData/'.$class.'.csv';
        $file = fopen($csvfile, 'a');
        $data = array(
            $student
        );
        fputcsv($file, $data);

        fclose($file);

        echo json_encode(array(
            'success' => true
        ));
    }
} else {
    echo json_encode(array(
        'success' => false
    ));
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>