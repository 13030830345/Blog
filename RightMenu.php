<div class="fixed">
    <div class="widget widget-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab">网站公告</a></li>
            <li role="presentation"><a href="#centre" aria-controls="centre" role="tab" data-toggle="tab">会员中心</a></li>
            <li role="presentation"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">联系站长</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane notice active" id="notice">
                <ul>
                    <?php
                    $sql = "SELECT * FROM notice";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['content'] != "") { ?>
                                <li>
                                    <time datetime="<?php echo $row['date'] ?>" title="该公告于 <?php echo $row['date'] ?> 发布。"><?php echo substr($row['date'], 6) ?></time>
                                    <a data-toggle="modal" data-target="#noticePopups" rel="nofollow" title="<?php echo $row['content'] ?>" class="<?php echo $row['date'] ?>"><?php echo $row['content'] ?></a></li>
                            <?php }
                    }
                } ?>
                </ul>
            </div>
            <?php
            if (isset($username)) {
                $username = $_SESSION['username'];
                $sql = "SELECT * FROM user_center WHERE username_t LIKE '$username'";
                $result = $conn->query($sql);
                $result->num_rows > 0;
                $row = $result->fetch_assoc();
                $id_C = $row['id'];
                ?>
                <div role="tabpanel" class="tab-pane centre" id="centre">
                    <div id="crop-avatar" class="col-md-6">
                        <div class="avatar-view">
                            <?php if ($row['avatar'] != "") { ?>
                                <img src="<?php echo $row['avatar'] ?>" class="img-circle">
                            <?php } else { ?>
                                <svg data-jdenticon-value="<?php echo $row['username_t'] ?>"></svg>
                            <?php } ?>
                        </div>
                    </div>
                    <div>
                        <a href="#"><span>用户名</span>：<i class="glyphicon glyphicon-user"></i>
                            <?php echo $username ?></a>
                        <a href="#">
                            <span>浏览器</span>：<i class="glyphicon glyphicon-leaf"></i>
                            <?php echo $row['login_browse'] ?></a>
                        <a href="#">
                            <span>评论数</span>：<i class="glyphicon glyphicon-comment"></i>
                            <?php echo $conn->query("SELECT COUNT(*) FROM comment WHERE user_id = $id_C")->fetch_assoc()['COUNT(*)'] ?>个自知之明</a>
                        <a href="#"><span>等级</span>：<i class="glyphicon glyphicon-<?php echo $id_C == "1" ? "king" : "pawn" ?>"></i>
                            </i> <?php echo $id_C == "1" ? "管理员" : "普通读者" ?></a>
                        <?php if (isset($glyphicon)) {
                            ?>
                            <i class="glyphicon glyphicon-king"></i>管理员
                            <i class="glyphicon glyphicon-queen"></i>金牌读者
                            <i class="glyphicon glyphicon-bishop"></i>银牌读者
                            <i class="glyphicon glyphicon-knight"></i>铜牌读者
                            <i class="glyphicon glyphicon-pawn"></i>普通读者
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                <div role="tabpanel" class="tab-pane centre" id="centre">
                    <h4>需要登录才能进入会员中心</h4>
                    <p> <a data-toggle="modal" data-target="#loginModal" class="btn btn-primary">立即登录</a> <a data-toggle="modal" data-target="#regModal" class="btn btn-default">现在注册</a> </p>
                </div>
            <?php  } ?>

            <div role="tabpanel" class="tab-pane contact" id="contact">
                <h2>Email:<br />
                    <a href="mailto:<?php echo WebSite_Email ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo WebSite_Email ?>"><?php echo WebSite_Email ?></a></h2>
            </div>
        </div>
    </div>
</div>
<div class="widget widget_search">
    <form class="navbar-form" action="search" method="post">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control searchbox" size="35" placeholder="请输入关键字" maxlength="15" autocomplete="off" required oninvalid="setCustomValidity('请输入搜索内容')" oninput="setCustomValidity('')">
            <span class="input-group-btn">
                <button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
            </span> </div>
    </form>
</div>
<?php if (WebSite_ones == "1") { ?>
    <div class="widget widget_sentence">
        <h3>「ONE · 一个」</h3>
        <div class="widget-sentence-content">
            <h4 id="Today">2019年</h4>
            <p id="ONE_word"></p>
        </div>
    </div>
<?php } ?>
<div class="widget widget_hot">
    <h3>热门文章</h3>
    <ul>
        <?php
        $sql = "SELECT * FROM article ORDER BY article.view DESC LIMIT 0," . WebSite_hot_num;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <li>
                    <a href="article-<?php echo $row['id'] ?>">
                        <span class="thumbnail"><img class="thumb" data-original="<?php echo $row['image'] ?>" src="<?php echo $row['image'] ?>" alt=""></span>
                        <span class="text"><?php echo $row['title'] ?></span>
                        <span class="muted"><i class="glyphicon glyphicon-time"></i><?php echo $row['date'] ?></span>
                        <span class="muted"><i class="glyphicon glyphicon-eye-open"></i> <?php echo $row['view'] ?></span>
                    </a>
                </li>
            <?php
        }
    }
    ?>
    </ul>
</div>
<script type="text/javascript">
    $(function() {
        if ("<?php echo WebSite_ones ?>" == "1") {
            var date = new Date;
            var year = date.getFullYear() + "年";
            var month = date.getMonth() + 1;
            month = (month < 10 ? "0" + month : month);
            var Week = ['日', '一', '二', '三', '四', '五', '六'];
            $("#Today").text((year + month + "月" + date.getDate() + "日 星期" + Week[date.getDay()]));
            $("#Today").autotype();
            $.ajax({
                type: "POST",
                url: 'https://api.hibai.cn/api/index/index',
                dataType: 'json',
                data: {
                    "TransCode": "030111",
                    "OpenId": "123456789",
                    "Body": ""
                },
                success: function(result) {
                    $("#ONE_word").html(result.Body.word);
                    $("#ONE_word").attr("title", result.Body.word_from);
                    $("#ONE_word").autotype();
                    return false;
                }
            });
        }
    });

    $.fn.autotype = function() {
        var $text = $(this);

        var str = $text.html();
        var index = 0;
        var x = $text.html('');

        var timer = setInterval(function() {
            var current = str.substr(index, 1);

            if (current == '<') {
                index = str.indexOf('>', index) + 1;
            } else {
                index++;
            }
            $text.html(str.substring(0, index) + (index & 1 ? '' : '_'));
            index > $text.html().length + 10 && (index = 0);
            if (index >= str.length) {
                clearInterval(timer);
            }
        }, 100);
    };
</script>