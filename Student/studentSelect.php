<!--防止未授權訪問-->
<?php include("../Admin/rejectAccessAdmin.php"); ?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/Styles/ss.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>學生各學期成績單</h1>
    <div>
    <div>
    <form action="getSemesterScore.php" method="POST">
        <select id = 'semesterScoreStudent'>
            <option value = 'none'>選擇學生</option>
        </select>
        <input type = 'number' name = 'classSemester' placeholder = '學年度'>
            <select name = 'classType'>
                <option value = '1'>上學期</option>
                <option value = '2'>下學期</option>
            </select>
        <input type = 'button' name='readStudentScore' value = '生成學期成績單'>
    </form>
    <script type="text/javascript">
      $(document).ready(function() {
            $('[name = "readStudentScore"]').click(function() { 
                var childs = document.getElementById('semesterScoreStudent').children.length;
                if(childs==0){ 
                    alert("沒有學生"); 
                }
                else{
                    $.ajax({
                        type: "POST", //傳送方式
                        url: "getSemesterScore.php", //傳送目的地
                        dataType: "json", //資料格式
                        data: { //傳送資料
                            student: $('#semesterScoreStudent').val(),
                            semester: $('[name="classSemester"]').val(),
                            type :$('[name="classType"]').val()
                        },
                        success: function(data) {
                            if (data.success === true) {
                                 //改標題
                                var title = document.getElementById('scoreBoard');
                                if($('[name="classType"]').val()==1){
                                    title.innerHTML=$('#semesterScoreStudent').val()+" "+
                                    $('[name="classSemester"]').val()+"學年度上學期成績單";
                                }
                                else{
                                    title.innerHTML=$('#semesterScoreStudent').val()+" "+
                                    $('[name="classSemester"]').val()+"學年度下學期成績單";
                                }
                                if(data.score.length==0) alert("查無資料");
                                //成績資料顯示
                                var scoreList = document.getElementById('scoreList');
                                //清空舊資料
                                var child = scoreList.lastElementChild;
                                while (scoreList.childElementCount>1) { 
                                    scoreList.removeChild(child); 
                                    child = scoreList.lastElementChild; 
                                } 
                                //加入新資料
                                let i;
                                for(i=0;i<data.score.length;i++){
                                    var scoreData = data.score[i];
                                    showScore(scoreData[0],scoreData[1],scoreData[2],scoreData[3],scoreData[4],scoreData[5]);
                                }
                            }
                            else {
                                alert("讀取失敗");
                            }
                        }
                    })
                }
            })
      });
      </script>
    </div>
	</div>
    <!--成績單-->
    <table id='scoreList'>
        <tr>
            <th colspan="6" id="scoreBoard">學期成績單</th>
        </tr>
        <tr class='alHead'>
            <td>代碼</td>
            <td>課程名稱</td>
            <td>教授</td>
            <td>學分</td>
            <td>類型</td>
            <td>成績</td>
        </tr>
    </table>
</body>
</html>

<script>
    function showScore(code,name,professor,credit,type,score) {
        //成績列表
        var score_List=document.getElementById('scoreList');
        var newRow = document.createElement("tr");
        score_List.appendChild(newRow);
        //代碼
        var showClassCode = document.createElement("td");
        showClassCode.innerHTML = code;
        newRow.appendChild(showClassCode);
        //課程名稱
        var showClassName = document.createElement("td");
        showClassName.innerHTML = name;
        newRow.appendChild(showClassName);
        //教授
        var showClassPr = document.createElement("td");
        showClassPr.innerHTML = professor;
        newRow.appendChild(showClassPr);
        //學分
        var showClassCredit = document.createElement("td");
        showClassCredit.innerHTML = credit;
        newRow.appendChild(showClassCredit);
        //類型
        var showClassCategory = document.createElement("td");
        if(type=='A'){
            showClassCategory.innerHTML = "必修";
        }
        else{
            showClassCategory.innerHTML = "選修";
        }
        newRow.appendChild(showClassCategory);
        //成績
        var showScore = document.createElement("td");
        showScore.innerHTML = score;
        newRow.appendChild(showScore);
    }
    function addStudentOption(student){
        var studentList=document.getElementById('semesterScoreStudent');
        var newOption = document.createElement("option");
        newOption.value = student;
        newOption.innerHTML = student;
        studentList.appendChild(newOption);
    }
</script>

<?php
// Read Students
$csvfile = '../Admin/user_identity.csv';

$file = fopen($csvfile, "r");
$row = 0;
while ($data = fgetcsv($file, 1000, ",")) {
    if($data[0]==='st')
        echo "<script type='text/javascript'>addStudentOption('$data[1]');</script>";
    $row++;
}
fclose($file);
?>