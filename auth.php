<?php
    include "pdo.php";

    //授权接口
    echo '<pre>';print_r($_POST);echo '</pre>';

    //接收 用户名和 密码
    $user = $_POST['name'];
    $pass = $_POST['pass'];


    //查询数据库 验证用户是否合法

    $sql = "select * from p_users where user_name='{$user}'";
    echo $sql;echo '</br>';

    $pdo = getPdo();
    $res = $pdo->query($sql);
    $row = $res->fetch(PDO::FETCH_ASSOC);
    echo '<pre>';print_r($row);echo '</pre>';

    if($row)        //如果有记录
    {
        //验证密码
        if(password_verify($pass,$row['password']))
        {
            //登录成功 ，生成 token  保存token  返回token

            echo json_encode();
            exit;
        }
    }


    //返回错误  授权失败
    echo json_encode();
    exit;



