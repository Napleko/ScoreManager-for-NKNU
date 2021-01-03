<?php session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$index = $_POST["index"];
    @$score = $_POST["score"];
    
    $csvfile = './score.csv';
    $lines = count(file($csvfile));
    if ($index < $lines) { 
        $file=fopen($csvfile,'r');
        $tmpFile=fopen("./tmp.csv",'w');
        $row=0;
        while($data = fgetcsv($file, 1000, ",")){
            if($row==$index){
                $data[2] = $score;
                fputcsv($tmpFile, $data);
            }
            else{
                fputcsv($tmpFile, $data);
            }
            $row++;
        }
        fclose($file);
        fclose($tmpFile);
        rename('./tmp.csv','./score.csv');

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