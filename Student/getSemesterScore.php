<?php 
if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$student = $_POST["student"];
    @$semester = $_POST["semester"].$_POST["type"];

    $scoreData = array();
    $scoreDataIndex = 0;
    $studentClassData = array();
    $studentClassDataIndex = 0;
    $classData = array();
    $classDataIndex = 0;

    $csvfile = './score.csv';
    $file = fopen($csvfile, "r");
    $row = 0;
    //找學生課程成績
    while ($data = fgetcsv($file, 1000, ",")) {
        if($student==$data[0]){
            $studentClassData[$studentClassDataIndex++] = array($data[1],$data[2]);//課程名稱,成績
        }
        $row++;
    }
    fclose($file);
    //找學年課程
    $classFile = '../Classes/class.csv';
    $file = fopen($classFile, "r");
    $row2 = 0;
    while($data = fgetcsv($file, 1000, ",")){
        if($data[0]==$semester){
            $classData[$classDataIndex++] = array($data[1],$data[2],$data[3],$data[4],$data[5]);
            //代碼,名稱,教授,學分,類型
        }
        $row2++;
    }
    fclose($classFile);
    //找學生學年課程
    for($i=0;$i<$studentClassDataIndex;$i++){
        $scData = $studentClassData[$i];
        //判斷成績是否為該學年
        for($j=0;$j<$classDataIndex;$j++){
            $cData = $classData[$j];
            if($scData[0]==$cData[1]){
                $scoreData[$scoreDataIndex++] = array($cData[0],$cData[1],$cData[2],$cData[3],$cData[4],$scData[1]);
                break;
            }
        }
    }


    echo json_encode(array(
        'success' => true,
        'score' => $scoreData,
        //'message' => $scoreDataIndex." ".$studentClassDataIndex." ".$classDataIndex." ".$row2
    ));
} else {
    echo json_encode(array(
        'success' => false
    ));
    echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
}
?>