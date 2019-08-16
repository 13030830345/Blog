<footer class="footer">
  <div class="container">
    <p>&copy; 2019 <a href="/"><?php echo WebSite_Url ?></a> &nbsp;
      <a href="http://www.miitbeian.gov.cn/" target="_blank" rel="nofollow"><?php echo WebSite_ICP ?></a> &nbsp;
      <!-- <a href="sitemap.xml" target="_blank" class="sitemap">网站地图</a> -->
    </p>
    <p>
      <a href="#" rel="nofollow">Powered By <?php echo WebSite_Copyright ?></a> &nbsp;
    </p>
  </div>
  <div id="gotop"><a class="gotop"></a></div>
</footer>
<!--二维码模态框-->
<div class="modal fade user-select" id="WeChat" tabindex="-1" role="dialog" aria-labelledby="WeChatModalLabel">
  <div class="modal-dialog" role="document" style="margin-top:120px;max-width:280px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="WeChatModalLabel" style="cursor:default;">扫一扫</h4>
      </div>
      <div class="modal-body" style="text-align:center;cursor:pointer"> <img src="/images/QR Code.png" alt="" width="200px" height="200" /> </div>
    </div>
  </div>
</div>
<!--该功能正在日以继夜的开发中-->
<div class="modal fade user-select" id="areDeveloping" tabindex="-1" role="dialog" aria-labelledby="areDevelopingModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="areDevelopingModalLabel" style="cursor:default;">该功能正在日以继夜的开发中…</h4>
      </div>
      <div class="modal-body"> <img src="/images/baoman/baoman_01.gif" alt="深思熟虑" />
        <p style="padding:15px 15px 15px 100px; position:absolute; top:15px; cursor:default;">很抱歉，程序猿正在日以继夜的开发此功能，本程序将会在以后的版本中持续完善！</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">朕已阅</button>
      </div>
    </div>
  </div>
</div>
<!--公告模态框-->
<div class="modal fade user-select" id="noticePopups" tabindex="-1" role="dialog" aria-labelledby="noticePopupsModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="noticePopupsModalLabel" style="cursor:default;">该公告于2019年5月27日发布。</h4>
      </div>
      <div class="modal-body">
        <p style="padding:15px; cursor:default;" id="noticePopupsModalContent">欢迎访问喵窝博客</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="noticePopupsOff">朕已阅</button>
      </div>
    </div>
  </div>
</div>
<!--注销模态框-->
<div class="modal fade user-select" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="logoutModalLabel" style="cursor:default;">提示</h4>
      </div>
      <div class="modal-body">
        <p style="padding:15px; cursor:default;" id="logoutModalContent">是否退出登录？</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary" id="logoutButton">退出</button>
      </div>
    </div>
  </div>
</div>



<!--聊天室模态框-->
<div class="modal fade user-select" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel">
  <div class="modal-dialog" role="document" style="max-width: 1280px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="chatModalLabel" style="cursor:default;">聊天室</h4>
      </div>
      <div class="modal-body chatBody">

      </div>
      <div class="modal-footer">
        <textarea type="text" placeholder="请输入内容" class="form-control" name="chatContent" autocomplete="off" maxlength="36" style="margin-bottom: 10px;resize: none;"></textarea>
        <input type="hidden" value="<?php echo $uid ?>" />
        <button type="submit" class="btn btn-primary" id="chatButton">发表</button>
      </div>
    </div>
  </div>
</div>
</div>



<!--登录模态框-->
<div class="modal fade user-select" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- <form action="/" method="post" onsubmit="return check();"> -->
      <form action="/" method="post" id="loginModalForm">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="loginModalLabel">登录</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="loginModalUserName">用户名</label>
            <input type="text" class="form-control" id="loginModalUserName" placeholder="请输入用户名" autofocus maxlength="15" autocomplete="off" required oninvalid="setCustomValidity('请输入用户名')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="loginModalUserPwd">密码</label>
            <input type="password" class="form-control" id="loginModalUserPwd" placeholder="请输入密码" maxlength="18" autocomplete="off" required oninvalid="setCustomValidity('请输入密码')" oninput="setCustomValidity('')">
          </div>
        </div>
        <div class="modal-footer">
          <div class="comment-prompt">
            <i class="fa fa-spin fa-circle-o-notch"></i>
            <span class="comment-prompt-text">正在登陆</span>
          </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="submit" class="btn btn-primary">登录</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--注册模态框-->
<div class="modal fade user-select" id="regModal" tabindex="-1" role="dialog" aria-labelledby="regModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- <form action="/" method="post" onsubmit="return check();"> -->
      <form action="/" method="post" id="regModalForm">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="regModalLabel">注册</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="regModalUserName">用户名</label>
            <input type="text" class="form-control" id="regModalUserName" placeholder="请输入用户名" autofocus maxlength="16" autocomplete="off" required oninvalid="setCustomValidity('请输入用户名')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="regModalUserPwd">密码</label>
            <input type="password" class="form-control" id="regModalUserPwd" placeholder="请输入密码" maxlength="16" autocomplete="off" required oninvalid="setCustomValidity('请输入密码')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="regModalUserPwdAgain">确认密码</label>
            <input type="password" class="form-control" id="regModalUserPwdAgain" placeholder="再次输入密码" maxlength="16" autocomplete="off" required oninvalid="setCustomValidity('请输入密码')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <input type="checkbox" id="regModalProtocol" autocomplete="off" checked>
            <span>我同意 <strong title="总之，您必须勾选“同意用户协议才能成功注册。"><u>用户协议</u></strong></span>
          </div>
        </div>
        <div class="modal-footer">
          <div class="comment-prompt">
            <i class="fa fa-spin fa-circle-o-notch"></i>
            <span class="comment-prompt-text">正在注册</span>
          </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="submit" class="btn btn-primary" id="reg_btn">注册</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--头像上传模态框 -->
<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" style="max-width: 960px">
    <div class="modal-content">
      <form class="avatar-form" action="test.php" enctype="multipart/form-data" method="post">
        <div class="modal-header">
          <button class="close" data-dismiss="modal" type="button">&times;</button>
          <h4 class="modal-title" id="avatar-modal-label">修改头像</h4>
        </div>
        <div class="modal-body">
          <div class="avatar-body">
            <div class="avatar-upload">
              <input class="avatar-src" name="avatar_src" type="hidden">
              <input class="avatar-data" name="avatar_data" type="hidden">
              <label for="avatarInput">图片上传</label>
              <input class="avatar-input" id="avatarInput" name="avatar_file" type="file"></div>
            <div class="row">
              <div class="col-md-9">
                <div class="avatar-wrapper"></div>
              </div>
              <div class="col-md-3">
                <div class="avatar-preview preview-lg"></div>
                <div class="avatar-preview preview-md"></div>
                <div class="avatar-preview preview-sm"></div>
              </div>
            </div>
            <div class="row avatar-btns">
              <div class="col-md-9">
                <div class="btn-group">
                  <button class="btn" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees"><i class="fa fa-undo"></i> 向左旋转</button>
                </div>
                <div class="btn-group">
                  <button class="btn" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees"><i class="fa fa-repeat"></i> 向右旋转</button>
                </div>
              </div>
              <div class="col-md-3">
                <button class="btn btn-success btn-block avatar-save" type="submit"><i class="fa fa-save"></i>
                  保存修改</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!--个人信息模态框-->
<div class="modal fade" id="seeUserInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="max-width: 450px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">个人信息</h4>
      </div>
      <div class="modal-body">
        <table class="table" style="margin-bottom:0px;">
          <tbody>
            <tr>
              <td wdith="20%">用户名:</td>
              <td width="80%"><input type="text" value="<?php echo $username ?>" class="form-control" name="Info_username" maxlength="10" autocomplete="off" disabled="disabled" /></td>
            </tr>
            <tr>
              <td wdith="20%">旧密码:</td>
              <td width="80%"><input type="password" class="form-control" name="Info_old_password" maxlength="18" autocomplete="off" /></td>
            </tr>
            <tr>
              <td wdith="20%">新密码:</td>
              <td width="80%"><input type="password" class="form-control" name="Info_password" maxlength="18" autocomplete="off" /></td>
            </tr>
            <tr>
              <td wdith="20%">确认密码:</td>
              <td width="80%"><input type="password" class="form-control" name="Info_new_password" maxlength="18" autocomplete="off" /></td>
            </tr>
          </tbody>
        </table>
        <div id="InfoTips" style="text-align: right;display: none"> <i class=" fa fa-spin fa-circle-o-notch"></i> 警告：提交成功后，您将会被强制退出！</div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="user_id" value="<?php echo $uid ?>" />
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary" id="UserInfoButton">提交</button>
      </div>
    </div>
  </div>
</div>
<!--右键菜单列表-->
<div id="rightClickMenu">
  <ul class="list-group rightClickMenuList">
    <li class="list-group-item disabled">喵窝博客</li>
    <li class="list-group-item"><span>IP：</span>172.16.10.129</li>
    <li class="list-group-item"><span>地址：</span>河南省郑州市</li>
    <li class="list-group-item"><span>系统：</span>Windows10 </li>
    <li class="list-group-item"><span>浏览器：</span>Chrome47</li>
  </ul>
</div>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.ias.js"></script>
<script src="/js/iziToast.min.js"></script>
<script src="/js/scripts.js"></script>
<script src="/js/jdenticon-2.1.1.js"></script>
<script src="/js/cropper.min.js"></script>
<script src="/js/avatar.js"></script>
<div class="iziToast-wrapper iziToast-wrapper-bottomLeft"></div>
<div class="iziToast-wrapper iziToast-wrapper-bottomRight"></div>
<div class="iziToast-wrapper iziToast-wrapper-topLeft"></div>
<div class="iziToast-wrapper iziToast-wrapper-topRight"></div>
<div class="iziToast-wrapper iziToast-wrapper-bottomCenter"></div>
<div class="iziToast-wrapper iziToast-wrapper-topCenter"></div>
<?php
function showLoginToast()
{
  if (isset($_SESSION['showToast']) && isset($_SESSION['login']) && $_SESSION['showToast'] && $_SESSION['login']) {
    $_SESSION['showToast'] = false;
    return "1";
  } else return "0";
}
function showLogoutToast()
{
  if (isset($_SESSION['showToast']) && isset($_SESSION['login']) && $_SESSION['showToast'] && !$_SESSION['login']) {
    $_SESSION['showToast'] = false;
    return "1";
  } else return "0";
}
?>
<script type="text/javascript">
  $(function() {



    function chat() {
      $.ajax({
        type: "POST",
        url: "/chat",
        cache: false,
        success: function(data) {
          $('.chatBody').html(data);
          jdenticon();
        }
      });
    }
    setInterval(function() {
      chat();
    }, 2000);


    $('#chatButton').click(function() {
      var chatContent = $('textarea[name=chatContent]').val();
      var userId = $('input[name=user_id]').val();
      if (chatContent != "") {
        $('textarea[name=chatContent]').val('');
        $.ajax({
          type: "POST",
          url: "/ajax.php",
          data: "function=AddChat&age=" + chatContent + "//,//" + userId,
          cache: false,
          success: function(data) {
            if (data == "true") {
              chat();
              iziToast.success({
                title: '成功',
                message: '内容已成功发送~',
                position: 'topCenter',
                transitionIn: 'fadeInDown',
                zindex: 1100,
                pauseOnHover: false,
              });
            }
          }
        });
      } else {
        iziToast.error({
          title: '错误',
          message: '请输入内容',
          position: 'topCenter',
          transitionIn: 'fadeInDown',
          timeout: 2000,
          zindex: 1100,
          pauseOnHover: false,
          onOpening: function() {
            $('textarea[name=chatContent]').focus();
          },
        });
      }
    });





    if (<?php echo showLoginToast() ?>) {
      iziToast.success({
        title: '<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "" ?>',
        message: '欢迎回来喵窝博客~',
        position: 'bottomRight',
        transitionIn: 'bounceInLeft',
        zindex: 1100,
        pauseOnHover: false,
      });
    }
    if (<?php echo showLogoutToast() ?>) {
      iziToast.error({
        title: 'Oh no!',
        message: '您从用户中心断开了连接...',
        position: 'bottomRight',
        transitionIn: 'bounceInLeft',
        zindex: 1100,
        pauseOnHover: false,
      });
    }
  });

  $('#UserInfoButton').click(function() {
    UserInfo();
  });

  function UserInfo() {
    var username = $('input[name=Info_username]').val();;
    var old_password = $('input[name=Info_old_password]').val();;
    var password = $('input[name=Info_password]').val();;
    var new_password = $('input[name=Info_new_password]').val();;
    if (password != new_password) {
      iziToast.error({
        title: '错误',
        message: '两次输入的密码不一致',
        position: 'topCenter',
        transitionIn: 'fadeInDown',
        zindex: 1100,
        pauseOnHover: false,
        onOpening: function() {
          $('#regModalUserPwdAgain').focus();
        },
      });
      return;
    }
    if (password == old_password) {
      iziToast.error({
        title: '错误',
        message: '新密码和旧密码一致',
        position: 'topCenter',
        transitionIn: 'fadeInDown',
        zindex: 1100,
        pauseOnHover: false,
        onOpening: function() {
          $('#regModalUserPwdAgain').focus();
        },
      });
      return;
    }
    var btn = $('#UserInfoButton');
    btn.attr("disabled", true);
    btn.text("3");
    $('#InfoTips').fadeIn();
    setTimeout(function() {
      btn.text("2");
    }, 1000);
    setTimeout(function() {
      btn.text("1");
    }, 2000);
    setTimeout(function() {
      btn.text("再次确认");
      btn.attr("disabled", false);
      btn.unbind("click");
      btn.click(function() {
        $.ajax({
          type: "POST",
          url: "/ajax.php",
          data: "function=AdminInfo&age=" + username + "//,//" + old_password + "//,//" + new_password + "//,//<?php if (isset($uid)) echo $uid ?>//,//1",
          cache: false, //不缓存此页面   
          success: function(data) {
            if (data == "true") {
              window.location.href = "/";
            } else {
              iziToast.error({
                title: '错误',
                message: '您输入的旧密码不符！',
                position: 'topCenter',
                transitionIn: 'fadeInDown',
                timeout: 2000,
                zindex: 1100,
                pauseOnHover: false,
                onOpening: function() {
                  $('#loginModalUserName').focus();
                },
              });
              $('#InfoTips').fadeOut();
              $('#UserInfoButton').text("提交");
              $('#UserInfoButton').unbind("click");
              $('#UserInfoButton').click(function() {
                UserInfo();
              });
            }
          }
        });
      })
    }, 3000);
  }

  $('#seeUserInfo').on('hidden.bs.modal', function() {
    $('#InfoTips').fadeOut();
    $('#UserInfoButton').text("提交");
    $('#UserInfoButton').unbind("click");
    $('#UserInfoButton').click(function() {
      UserInfo();
    });
  })
</script>
<?php
if (WebSite_Live2Ds == "1")
  include 'live2d.php';
?>