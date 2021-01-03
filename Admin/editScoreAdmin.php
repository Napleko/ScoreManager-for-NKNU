<!--防止未授權訪問-->
<?php include("rejectAccessAdmin.php"); ?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/Styles/am.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>成績更新</h1>
    <!--帳號列-->
    <table id='scoreList'>
        <tr>
            <th colspan="4">成績列表</th>
        </tr>
        <tr class='alHead'>
            <td>學生</td>
            <td>課程</td>
            <td>成績</td>
            <td>修改成績</td>
        </tr>
    </table>
</body>
</html>

<script>
    function showScore(uID,className,score,row) {
        //成績列表
        var account_List=document.getElementById('scoreList');
        var newRow = document.createElement("tr");
        account_List.appendChild(newRow);
        //學生
        var uid = document.createElement("td");
        uid.innerHTML = uID;
        newRow.appendChild(uid);
        //課程
        var name = document.createElement("td");
        name.innerHTML = className;
        newRow.appendChild(name);
        //成績
        var showScore = document.createElement("td");
        showScore.innerHTML = score;
        newRow.appendChild(showScore);
        //修改
        var btnContainer2 = document.createElement("td");
        var chText = document.createElement("input");
        chText.type = 'number';
        chText.style = "width:160px;height:30px;margin: auto;font-size: 18px;";
        chText.id = "changeScore"+row;
        chText.placeholder = '新成績';
        var chBtn = document.createElement("input");
        chBtn.type = 'button';
        chBtn.onclick=function() { 
            changeScore(row);
        };
        chBtn.value = "修改成績";
        chBtn.style = "width:120px;height:30px;margin-left: 20px;margin-left: 20px;font-size: 18px;";
        btnContainer2.appendChild(chText);
        btnContainer2.appendChild(chBtn);
        newRow.appendChild(btnContainer2);
    }
    function changeScore(theIndex) {
        $.ajax({
                type: "POST", //傳送方式
                url: "/Student/changeScore.php", //傳送目的地
                dataType: "json", //資料格式
                data: { //傳送資料
                    index: theIndex,
                    score: $("#changeScore"+theIndex).val()
                },
                success: function(data) {
                    if (data.success === true) {
                        alert("修改成功");
                        window.location.reload();
                    }
                    else {
                        alert("修改失敗");
                    }
                }
            })
    }
</script>

<?php
$csvfile = '../Student/score.csv';

$file = fopen($csvfile, "r");
$row = 0;
while ($data = fgetcsv($file, 1000, ",")) {
    echo "<script type='text/javascript'>showScore('$data[0]','$data[1]','$data[2]','$row');</script>";
    $row++;
}
fclose($file);
?>
