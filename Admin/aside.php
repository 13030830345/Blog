<aside class="col-sm-3 col-md-2 col-lg-2 sidebar">
    <?php $php_self = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1); ?>
    <ul class="nav nav-sidebar">
        <li <?php echo $php_self == "index.php" ? "class='active'" : ""; ?>><a href="index">报告</a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li <?php echo $php_self == "article.php" || $php_self == "EditArticle.php" ? "class='active'" : ""; ?>><a href="article">文章</a></li>
        <li <?php echo $php_self == "notice.php" ? "class='active'" : ""; ?>><a href="notice">公告</a></li>
        <li <?php echo $php_self == "comment.php" ? "class='active'" : ""; ?>><a href="comment">评论</a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li <?php echo $php_self == "category.php" ? "class='active'" : ""; ?>><a href="category">栏目</a></li>
        <li <?php echo $php_self == "fLink.php" || $php_self == "EditFLink.php" ? "class='active'" : ""; ?>><a href="fLink">友链</a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li <?php echo $php_self == "manageUser.php" || $php_self == "loginLog.php" ? "class='active'" : ""; ?>>
            <a class="dropdown-toggle" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">用户</a>
            <ul class="dropdown-menu" aria-labelledby="userMenu">
                <li><a href="manageUser">管理用户</a></li>
                <li><a href="loginLog">登录日志</a></li>
            </ul>
        </li>
        <li <?php echo $php_self == "setting.php" || $php_self == "readSet.php" ? "class='active'" : ""; ?>>
            <a class="dropdown-toggle" id="settingMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">设置</a>
            <ul class="dropdown-menu" aria-labelledby="settingMenu">
                <li><a href="setting">基本设置</a></li>
                <li><a href="readSet">阅读设置</a></li>
                <!-- <li role="separator" class="divider"></li>
                <li><a data-toggle="modal" data-target="#areDeveloping">安全配置</a></li>
                <li role="separator" class="divider"></li>
                <li class="disabled"><a>扩展设置</a></li> -->
            </ul>
        </li>
    </ul>
</aside>