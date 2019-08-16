<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>常规设置 - <?php echo WebSite_Title ?>博客管理系统 | Powered By <?php echo WebSite_Copyright ?></title>
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
          <form action="" method="post" autocomplete="off" draggable="false" id="setting">
            <div class="col-md-9">
              <h1 class="page-header">常规设置</h1>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>站点标题</span> (<strong style="color:red"> * </strong>)</h2>
                <div class="add-article-box-content">
                  <input type="text" name="title" class="form-control" placeholder="请输入站点标题" required autofocus autocomplete="off" value="<?php echo WebSite_Title ?>">
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>副标题</span> (<strong style="color:red"> * </strong>)</h2>
                <div class="add-article-box-content">
                  <input type="text" name="subtitle" class="form-control" placeholder="请输入站点副标题" autocomplete="off" value="<?php echo WebSite_Subtitle ?>">
                  <span class="prompt-text">用简洁的文字描述本站点。</span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>站点地址（URL）</span> (<strong style="color:red"> * </strong>)</h2>
                <div class="add-article-box-content">
                  <input type="text" name="Url" class="form-control" placeholder="在此处输入站点地址（URL）" required autocomplete="off" value="<?php echo WebSite_Url ?>">
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>站点关键字</span></h2>
                <div class="add-article-box-content">
                  <input type="text" name="Keywords" class="form-control" placeholder="在此处输入站点关键字" autocomplete="off" value="<?php echo WebSite_Keywords ?>">
                  <span class="prompt-text">请使用英文逗号( , )隔开，关键字会出现在网页的keywords属性中。</span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>站点描述</span></h2>
                <div class="add-article-box-content">
                  <textarea class="form-control" name="Description" rows="4" autocomplete="off" style="height:86px"><?php echo WebSite_Description ?></textarea>
                  <span class="prompt-text">描述会出现在网页的description属性中。</span> </div>
              </div>
            </div>
            <div class="col-md-3">
              <h1 class="page-header">站点</h1>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>电子邮件地址</span></h2>
                <div class="add-article-box-content">
                  <input type="email" name="email" class="form-control" placeholder="在此处输入邮箱" autocomplete="off" value="<?php echo WebSite_Email ?>" />
                  <span class="prompt-text">此邮件地址用于联系管理员。</span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>ICP备案号</span></h2>
                <div class="add-article-box-content">
                  <input type="text" name="ICP" class="form-control" placeholder="在此处输入备案号" autocomplete="off" value="<?php echo WebSite_ICP ?>" />
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>站点版权</span> (<strong style="color:red"> * </strong>)</h2>
                <div class="add-article-box-content">
                  <input type="text" name="Copyright" class="form-control" placeholder="在此处输入站点版权信息" required autocomplete="off" value="<?php echo WebSite_Copyright ?>" />
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>登录超时</span> (<strong style="color:red"> * </strong>)</h2>
                <div class="add-article-box-content">
                  <input type="number" name="LoginOut" class="form-control" placeholder="在此处输入超时时间(s)" required autocomplete="off" value="<?php echo WebSite_LoginOut ?>" />
                  <input type="hidden" name="LastOutTime" class="form-control" required autocomplete="off" value="<?php echo WebSite_LoginOut ?>" />
                  <span class="prompt-text">单位(秒),超时将强制退出</span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>保存</span></h2>
                <div class="add-article-box-content"> <span class="prompt-text">
                    请确定您已经填写所有带有<strong style="color:red"> * </strong>的必填选项</span>
                </div>
                <div class="add-article-box-content"> <span class="prompt-text">请确定您对所有选项所做的更改</span> </div>
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
</body>

</html>