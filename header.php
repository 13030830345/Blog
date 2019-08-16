<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM user_center WHERE username_t LIKE '$username'";
    $result = $conn->query($sql);
    $result->num_rows > 0;
    $row = $result->fetch_assoc();
    $uid = $row['id'];
}
function Active($var, $id)
{
    $a = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    if ($id) {
        $a = $a . '?' . $_SERVER['QUERY_STRING'];
    }
    echo basename($a) == $var ? "class=\"active\"" : "";
}
?>
<header class="header">
    <nav class="navbar navbar-default" id="navbar">
        <div class="container">
            <div class="header-topbar hidden-xs link-border">
                <ul class="site-nav topmenu">
                    <li><a href="tags">标签云</a></li>
                    <li><a href="readers" rel="nofollow">读者墙</a></li>
                    <li><a href="links" rel="nofollow">友情链接</a></li>
                    <?php
                    if (isset($username)) { ?>
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" rel="nofollow">操作 <span class="caret"></span></a>
                            <ul class="dropdown-menu header-topbar-dropdown-menu">
                                <li><a data-toggle="modal" data-target="#WeChat" rel="nofollow"><i class="fa fa-weixin"></i> 关注本站</a></li>
                                <li><a data-toggle="modal" data-target="#logoutModal" class="logout" rel="nofollow"><i class="glyphicon glyphicon-log-out"></i> 注销登录</a></li>
                                <li><a data-toggle="modal" data-target="#seeUserInfo" class="logout" rel="nofollow"><i class="glyphicon glyphicon-asterisk"></i> 修改密码</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                <?php
                if (isset($username)) { ?>
                    <a href="#">Hi,<?php echo $username ?></a>&nbsp;&nbsp;
                <?php } else { ?>
                    <a data-toggle="modal" data-target="#loginModal" class="login" rel="nofollow">Hi,请登录</a>&nbsp;&nbsp;
                    <a data-toggle="modal" data-target="#regModal" class="register" rel="nofollow">我要注册</a>&nbsp;&nbsp;
                    <a data-toggle="modal" data-target="#LostPasswordModal" class="register" rel="nofollow">找回密码</a>
                <?php } ?>
            </div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar" aria-expanded="false"> <span class="sr-only"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <h1 class="logo hvr-bounce-in"><a href="/" title=""><img src="/images/MiaoWo.png" alt=""></a></h1>
            </div>
            <div class="collapse navbar-collapse" id="header-navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li <?php Active("index.php", false); ?>><a data-cont="首页" href="/">首页</a></li>
                    <?php
                    $sql = "SELECT * FROM classify";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['name'] != "") {
                                ?>
                                <li <?php Active("category.php?id=" . $row['id'], true);
                                    if (isset($page)) Active("category.php?id=" . $row['id'] . "&page=" . $page, true); ?>>
                                    <a href="category-<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
                                </li>
                            <?php }
                    }
                }
                if (isset($uid)) {
                    if ($uid == 1) {
                        ?><li><a href="/Admin">管理系统</a></li>
                        <?php }
                    ?><li class="active">
                            <a data-cont="聊天室" data-toggle="modal" data-target="#chatModal" rel="nofollow">聊天室</a>
                        </li>
                    <?php } ?>

                </ul>
                <form class="navbar-form visible-xs" action="/Search" method="post">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="请输入关键字" maxlength="20" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
                        </span> </div>
                </form>
            </div>
        </div>
    </nav>
</header>