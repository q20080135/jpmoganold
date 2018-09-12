<?php
    $param = !empty($_REQUEST['get']) ? $_REQUEST['get'] : null;
    $list = get_loaded_extensions();

    if($param == 'redis') {
        if(in_array($param, $list)) {
            $redis = new Redis();
            //测试服务器ip: 114.55.96.33
            $result = $redis->connect('localhost', 6379);
            if($result) {
                //权限登录
                $auth = $redis->auth("redisadmin");
                if($auth) {
                    echo "<h3>Server is running: " . $redis->ping() . "</h3>";
                }else {
                    echo "<h3>redis登录失败!</h3>";
                }
            }else {
                echo "<h3>redis连接失败!</h3>";
            }
        }else {
            echo "<h3>未安装php-redis扩展!</h3>";
        }
    }else if($param == 'test') {
        echo 'param is ok';
    }else {
        phpinfo();
    }
?>