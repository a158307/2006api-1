<?php

    include "pdo.php";
    // 获取用户信息接口

    //接收 token

    if(empty($_GET['token']))
    {
        $response = [
            'errno' => 400005,
            'msg'   => "缺少token参数"
        ];
        die( json_encode($response,JSON_UNESCAPED_UNICODE));
    }

    $token = $_GET['token'];

    $pdo = getPdo();
    //验证token是否正确
    $sql = "select * from p_tokens where token='{$token}'";
    $res = $pdo->query($sql);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    if($row && $row['expire']>time())       //有记录并且未过期
    {
        //token验证通过

        // TODO 查询用户信息  并返回JSON


    }else{

        // TODO 验证未通过
    }



