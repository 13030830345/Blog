<header>
    <?php
    session_start();
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $login_time = $_SESSION['login_time'];
        $login_ip = $_SESSION['login_ip'];
        $sql = "SELECT * FROM user_center WHERE username_t LIKE '$username'";
        $row_U = $conn->query($sql)->fetch_assoc();
        $uid = $row_U['id'];
        if ($uid != "1")
            header("location: /");
    } else
        header("location: /admin/login");
    ?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">切换导航</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="/Admin" id="Login"><?php echo $_SERVER['SERVER_NAME']; ?></a> </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <!-- <li><a href="">消息 <span class="badge">1</span></a></li> -->
                    <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            <li><a title="查看或修改个人信息" data-toggle="modal" data-target="#seeUserInfo">个人信息</a></li>
                            <li><a title="查看您的登录记录" data-toggle="modal" data-target="#seeUserLoginlog">登录记录</a></li>
                        </ul>
                    </li>
                    <li><a data-toggle="modal" data-target="#logoutModal" class="logout" rel="nofollow">退出登录</a></li>
                    <li><a href="/">站点首页</a></li>
                    <li><a data-toggle="modal" data-target="#WeChat">帮助</a></li>
                </ul>
                <!-- <form action="" method="post" class="navbar-form navbar-right" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" autocomplete="off" placeholder="键入关键字搜索" maxlength="15">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">搜索</button>
                        </span> </div>
                </form> -->
            </div>
        </div>
    </nav>
</header>