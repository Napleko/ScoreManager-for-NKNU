<?php session_start();
//header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8

if ($_SERVER['REQUEST_METHOD'] == "POST") { //如果是 POST 請求
    @$identity = $_POST["identity"];
    @$account = $_POST["account"];
    @$pswd = $_POST["pswd"];

    if ($identity === 'administrator') {
        $csvfile = './Admin/user_identity.csv';

        $file = fopen($csvfile, "r");
        $data = fgetcsv($file, 1000, ",");
        $op_act = $data[1];
        $op_pswd = $data[2];
        fclose($file);
        if ($account === $op_act && $pswd === $op_pswd) {
            $_SESSION['auth'] = 'a';
            echo json_encode(array(
                'success' => true,
                'message' => '進入管理員系統',
                'webpage' => '/administrator.php'
            ));
        } else {
            echo json_encode(array(
                'success' => '帳號或密碼錯誤'
            ));
        }
    } else if ($identity === 'professor' || $identity === 'student') {
        $csvfile = './Admin/user_identity.csv';

        $file = fopen($csvfile, "r");
        do {
            $data = fgetcsv($file, 1000, ",");
            $index = $data[0];

            if ($index === 'pr') {
                $pr_act = $data[1];
                $pr_pswd = $data[2];
                if ($account === $pr_act && $pswd === $pr_pswd) {
                    echo json_encode(array(
                        'success' => true,
                        'message' => '歡迎回來，教授!',
                        'webpage' => '/professor.html'
                    ));
                    return false;
                }
            }
            else if ($index === 'st'){
                $st_act = $data[1];
                $st_pswd = $data[2];
                if ($account === $st_act && $pswd === $st_pswd) {
                    echo json_encode(array(
                        'success' => true,
                        'message' => '歡迎回來，同學!',
                        'webpage' => '/student.html'
                    ));
                    return false;
                }
            }
        } while ($data !== FALSE);
        echo json_encode(array(
            'success' => '帳號或密碼錯誤'
        ));
    }else if ($identity == 'none' || $account == '' || $pswd == '') {
        echo json_encode(array(
            //'success' => "身分".$identity."帳號".$account."密碼".$pswd
            'success' => '未選擇身分 或 未填寫帳號密碼'
        ));
    } else {
        echo json_encode(array(
            'success' => '帳號或密碼錯誤'
        ));
    }
} //else {
    //echo "<a href='/index.html'>網頁請求錯誤,點此返回</a>";
//}
