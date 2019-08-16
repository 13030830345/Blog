<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阅读设置 - <?php echo WebSite_Title ?>博客管理系统</title>
  <?php include '../tool.php'; ?>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="user-select">
  <section class="container-fluid">
    <?php include 'header.php' ?>
    <div class="row">
      <?php include 'aside.php' ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <div class="row">
          <form action="" method="post" autocomplete="off" draggable="false" id="read_set">
            <div class="col-md-6">
              <h1 class="page-header">文章</h1>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>单页数量</span></h2>
                <div class="add-article-box-content">
                  <input type="number" name="show_num" class="form-control" placeholder="请输入数字" required autofocus autocomplete="off" value="<?php echo WebSite_show_num ?>" min="2" max="10">
                  <span class="prompt-text">单页面文章数量（首页最新文章、栏目下全部文章、搜索文章、文章下评论数量等）</span>
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>首页文章页数</span></h2>
                <div class="add-article-box-content">
                  <input type="number" name="page_num" class="form-control" placeholder="请输入数字" autocomplete="off" value="<?php echo WebSite_page_num ?>" min="2" max="5">
                  <span class="prompt-text">首页最新文章可显示的页数（可显示的总数量为 <strong>单页数量 * 页数</strong> ）</span>
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>首页轮播数量</span></h2>
                <div class="add-article-box-content">
                  <input type="number" name="carousel_num" class="form-control" placeholder="请输入数字" autocomplete="off" value="<?php echo WebSite_carousel_num ?>" min="3" max="10" />
                  <span class="prompt-text">首页中轮播展示的文章数量</span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>热门文章数量</span></h2>
                <div class="add-article-box-content">
                  <input type="number" name="hot_num" class="form-control" placeholder="请输入数字" required autocomplete="off" value="<?php echo WebSite_hot_num ?>" min="2" max="10">
                  <span class="prompt-text">右侧热门文章数量</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h1 class="page-header">操作</h1>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>栏目热门推荐数量</span></h2>
                <div class="add-article-box-content">
                  <input type="number" name="category_num" class="form-control" placeholder="请输入数字" required autocomplete="off" value="<?php echo WebSite_category_num ?>" min="2" max="15">
                  <span class="prompt-text">文章页面中，栏目热门推荐的文章数量</span>
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>「Live 2D」</span></h2>
                <div class="add-article-box-content">
                  <div class="switch switch-small" style="margin-top:3px;margin-bottom:4px">
                    <input type="checkbox" name="Live2D" style="display:none" data-size="Normal" data-on-color="success" data-off-color="info" <?php echo WebSite_Live2Ds == "1" ? "checked" : "" ?> />
                    <input type="hidden" name="Live2Ds" value="<?php echo WebSite_Live2Ds ?>">
                  </div>
                  <span class="prompt-text">是否开启「Live 2D」伊斯特瓦尔</span>
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>「ONE · 一个」</span></h2>
                <div class="add-article-box-content">
                  <div class="switch switch-small" style="margin-top:3px;margin-bottom:4px">
                    <input type="checkbox" name="one" style="display:none" data-size="Normal" data-on-color="success" data-off-color="info" <?php echo WebSite_ones == "1" ? "checked" : "" ?> />
                    <input type="hidden" name="ones" value="<?php echo WebSite_ones ?>">
                  </div>
                  <span class="prompt-text">是否开启「ONE · 一个」每日一句</span>
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>保存</span></h2>
                <div class="add-article-box-content">
                  <span class="prompt-text">请确定您对所有选项所做的更改</span>
                </div>
                <div class="add-article-box-footer">
                  <button class="btn btn-primary" type="submit" name="submit">更新</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php include 'modal.php' ?>
  <script>
    $($('input[name=one]')).bootstrapSwitch({
      onSwitchChange: function(event, state) {
        if (state == true) {
          $('input[name=ones]').val(1);
        } else {
          $('input[name=ones]').val(0);
        }
      }
    });
    $($('input[name=Live2D]')).bootstrapSwitch({
      onSwitchChange: function(event, state) {
        if (state == true) {
          $('input[name=Live2Ds]').val(1);
        } else {
          $('input[name=Live2Ds]').val(0);
        }
      }
    });
  </script>
</body>

</html>