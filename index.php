<?php include 'config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo WebSite_Title ?> - <?php echo WebSite_Subtitle ?> | Powered By <?php echo WebSite_Copyright ?></title>
    <?php include 'tool.php';
    $page_num = $conn->query("SELECT * FROM article")->num_rows;
    $amount = WebSite_show_num;
    if ($page_num / $amount > (int)($page_num / $amount))
        $page_num =  (int)($page_num / $amount) + 1;
    else
        $page_num = (int)$page_num / $amount;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    if ($page > $page_num) $page = $page_num;
    if ($page_num >= 2) $page_num = 2;
    ?>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body class="user-select">
    <?php include 'header.php' ?>
    <section class="container">
        <div class="content-wrap">
            <div class="content">
                <div class="jumbotron">
                    <h1>欢迎访问喵窝博客</h1>
                    <p>在这里可以看到前端技术，后端程序，网站内容管理系统等文章，还有我的程序人生！</p>
                </div>
                <?php
                $s = WebSite_carousel_num;
                $sql = "SELECT * FROM article LIMIT 0,$s";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    ?>
                    <div id="focusslide" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php for ($i = 0; $i < $s; $i++) {
                                ?>
                                <li data-target="#focusslide" data-slide-to="<?php echo $i ?>" <?php echo $i == 0 ? "class='active'" : "" ?>></li>
                            <?php } ?>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $i = 0;
                            while ($row = $result->fetch_assoc()) { ?>
                                <div class="item <?php echo $i == 0 ? "active" : "" ?>"> <a href="article-<?php echo $row['id'] ?>" target="_blank"><img src="<?php echo $row['image'] ?>" alt="" class="img-responsive" width="820" height="200"></a>
                                </div>
                                <?php $i = 1;
                            } ?>
                        </div>
                        <a class="left carousel-control" href="#focusslide" role="button" data-slide="prev" rel="nofollow"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">上一个</span> </a> <a class="right carousel-control" href="#focusslide" role="button" data-slide="next" rel="nofollow"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">下一个</span> </a>
                    </div>
                <?php } ?>
                <!-- <article class="excerpt-minic excerpt-minic-index">
                    <h2><span class="red">【推荐】</span><a href="" title="">从下载看我们该如何做事</a></h2>
                    <p class="note">一次我下载几部电影，发现如果同时下载多部要等上几个小时，然后我把最想看的做个先后排序，去设置同时只能下载一部，结果是不到一杯茶功夫我就能看到最想看的电影。 这就像我们一段时间内想干成很多事情，是同时干还是有选择有顺序的干，结果很不一样。同时...</p>
                </article> -->
                <div class="title">
                    <h3>最新发布</h3>
                    <div class="more"><a href="">PHP</a><a href="">JavaScript</a><a href="">Unity</a><a href="">C Sharp</a><a href="">MySQL</a></div>
                </div>

                <?php
                $sql = "SELECT * FROM article ORDER BY `article`.`date` DESC LIMIT " . ($page - 1) * $amount . "," . $amount;
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <article class="excerpt excerpt-<?php echo $row['id'] ?>"><a class="focus" href="article-<?php echo $row['id'] ?>" title=""><img class="thumb" data-original="<?php echo $row['image'] ?>" src="<?php echo $row['image'] ?>" alt=""></a>
                            <header><a class="cat" href="program"><?php echo $row['classify'] ?><i></i></a>
                                <h2><a href="article-<?php echo $row['id'] ?>" class="isArticle"><?php echo $row['title'] ?></a></h2>
                            </header>
                            <p class="meta">
                                <time class="time"><i class="glyphicon glyphicon-time"></i><?php echo $row['date'] ?></time>
                                <span class="views"><i class="glyphicon glyphicon-eye-open"></i> 共<?php echo $row['view'] ?>人围观</span> <a class="comment" href="article-<?php echo $row['id'] ?>"><i class="glyphicon glyphicon-comment"></i> <?php echo $conn->query("SELECT COUNT(*) FROM comment WHERE article_id = " . $row['id'])->fetch_assoc()['COUNT(*)'] ?>个不明物体</a></p>
                            <div class="note"><?php echo $row['foreword'] ?></div>
                        </article>
                    <?php
                }
            }
            ?>
                <div class="ias_end" style="display:none"><a>已是最后一页</a></div>
                <nav class="pagination" style="display: none;">
                    <ul>
                        <li class="prev-page"></li>
                        <?php for ($i = 0; $i < $page_num; $i++) { ?>
                            <li <?php echo $page == (1 + $i) ? "class=\"active\"" : "" ?>>
                                <a href="index-<?php echo (1 + $i) ?>">
                                    <?php echo (1 + $i) ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="next-page"><a href="index-<?php echo ($page + 1) > $page_num ? $page_num + 1 : ($page + 1) ?>">下一页</a></li>
                        <li><span>共 <?php echo $page_num ?> 页</span></li>
                    </ul>
                </nav>
            </div>
        </div>
        <aside class="sidebar">
            <?php include 'RightMenu.php' ?>
        </aside>
    </section>
    <script type="text/javascript">
        var page_num = <?php echo $page_num ?>;
        $(function() {
            $("a[data-target=#noticePopups]").click(function() {
                $('#noticePopupsModalLabel').text("该公告于" + $(this).attr('class') + "发布。");
                $('#noticePopupsModalContent').text($(this).text());
            });
        });
    </script>
    <?php include 'footer.php' ?>
</body>

</html>