各檔案功能:
首頁：index.html
管理員頁：administrator.php
登出(後端)：logout.php
以錯誤方式進入登出頁時使用：logoutEXC.js
驗證身分(後端)：authorize.php
帳戶管理分頁：AccountManager.php
驗證網頁存取權(後端)(確認是否為管理員)：rejectAccessAdmin.php
新增帳號：addAccount.php
刪除帳號：removeAccount.php
修改密碼：changePassword.php

管理員頁：
各功能對應的網頁內嵌於id='am'的iframe
按各功能按鈕會改變其src值
目前僅有帳戶管理分頁

帳戶管理分頁：
功能_讀取帳戶資料並以表格顯示
功能_新增帳號
功能_刪除帳號
功能_修改密碼

安全性：
登入時php建立session,產生session變數auth=a,代表用戶為管理員
登出或關閉瀏覽器時解除session

藉由網址直接呼叫檔案時,藉由"Admin/rejectAccessAdmin.php"的確認auth值,沒有權限的用戶會被送回首頁
