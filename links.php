<?php include 'config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>友情链接 - | <?php echo WebSite_Title ?> | <?php echo WebSite_Subtitle ?> | Powered By <?php echo WebSite_Copyright ?></title>
    <?php include 'tool.php'; ?>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body class="user-select">
    <?php include 'header.php' ?>
    <section class="container container-page">
        <div class="pageside">
            <div class="pagemenus">
                <ul class="pagemenu">
                    <li><a href="tags">标签云</a></li>
                    <li><a href="readers">读者墙</a></li>
                    <li><a class="active" href="links">友情链接</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            <header class="article-header">
                <h1 class="article-title">友情链接</h1>
            </header>
            <ul class="plinks">
                <?php
                $sql = "SELECT * FROM links";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <li>
                            <a href="<?php echo $row['link'] ?>" title="" target="<?php echo $row['target'] ?>" rel="<?php echo $row['rel'] ?>">
                                <img src="<?php echo $row['icon'] ?>" alt="">
                                <?php echo $row['title'] ?>
                            </a>
                        </li>
                    <?php
                }
            }
            ?>
            </ul>
        </div>
    </section>
    <?php include 'footer.php' ?>
</body>
<?php
function InputImage($url)
{
    $temp = parse_url($url)['host'];
    echo "//www." . substr($temp, strpos($temp, '.') + 1) . "/favicon.ico";
}
function InputTitle($url)
{
    $c = curl_init();
    $arr = file($url);
    if ($arr) {
        foreach ($arr as $a) {
            if (strchr($a, "<title>")) {
                $a = str_ireplace("<title>", "", $a);
                $a = str_ireplace("</title>", "", $a);
                echo $a;
                break;
            }
        }
    }
}
?>

</html>