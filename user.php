<?php

    include "pdo.php";
    // 获取用户信息接口

    //获取客户端的 token参数
    if(empty($_GET['token'])){      //不能为空
        $response = [
            'errno' => 400002,
            'msg'   => "缺少token参数"
        ];
        die( json_encode($response));
    }

    $pdo = getPdo();
    $token = $_GET['token'];
    //验证token
    $sql = "select * from p_tokens where token='{$token}'";
    $res = $pdo->query($sql);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    if($row && $row['expire']>time()){      // 有token并且未过期
        //token有效  查询用户信息并返回
        $sql2 = "select user_id,user_name,email,reg_time from p_users where user_id={$row['uid']}";
        $res2 = $pdo->query($sql2);
        $user_info = $res2->fetch(PDO::FETCH_ASSOC);

        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'  => [
                'info'  => $user_info
            ]
        ];
    }else{
        $response = [
            'errno' => 400003,
            'msg'   => 'token无效'
        ];

    }

    die(json_encode($response));


