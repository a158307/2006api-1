<?php
    include "pdo.php";

    //授权接口

    //接收 用户名和 密码
    $user = $_POST['name'];
    $pass = $_POST['pass'];


    //查询数据库 验证用户是否合法

    $sql = "select * from p_users where user_name='{$user}'";

    $pdo = getPdo();
    $res = $pdo->query($sql);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    if($row)        //如果有记录
    {
        //验证密码
        if(password_verify($pass,$row['password']))
        {
            //登录成功 ，生成 token  保存token  返回token
            $hash_str = hash('sha256',$row['user_id'].$row['user_name'].mt_rand(1,99999));
            $token = substr($hash_str,10,20);

            //删除原有记录
            $sql = "delete from p_tokens where uid={$row['user_id']}";
            $pdo->exec($sql);

            //写入新数据
            $expire = time();
            $sql = "insert into p_tokens (`uid`,`token`,`expire`) 
values ({$row['user_id']},'{$token}',$expire)";
            $pdo->exec($sql);
            $response = [
                'errno' => 0,
                'msg'   => 'ok',
                'data'  => [
                    'token' => $token
                ]
            ];
            echo json_encode($response);
            exit;
        }
    }


    //返回错误  授权失败
    $response = [
        'errno' => 400001,
        'msg'   => '授权失败'
    ];
    echo json_encode($response);
    exit;



