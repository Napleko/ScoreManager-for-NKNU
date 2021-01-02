<?php session_start();
    header('charset=UTF-8'); //設定資料類型為 json，編碼 utf-8

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        @$submission = $_POST["submission"];

        if($submission === 'true'){
            session_destroy();
            echo json_encode(array('success' => true));
        } else{
            echo json_encode(array(
                'success' => '登出失敗'
            ));
        }
    } else {
        //防止直接存取
        echo "<script type='text/javascript' src='logoutEXC.js'></script>";
        echo "<button onclick='rejectAccess()'>請以正規方式進入本頁</button>";
    }
?>