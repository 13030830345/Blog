//当浏览器窗口大小改变时重载网页
/*window.onresize=function(){
    window.location.reload();
}*/

//页面加载时给img和a标签添加draggable属性
(function () {
    $('img').attr('draggable', 'false');
    $('a').attr('draggable', 'false');
})();

function getsec(str) {
    var str1 = str.substring(1, str.length) * 1;
    var str2 = str.substring(0, 1);
    if (str2 == "s") {
        return str1 * 1000;
    } else if (str2 == "h") {
        return str1 * 60 * 60 * 1000;
    } else if (str2 == "d") {
        return str1 * 24 * 60 * 60 * 1000;
    }
}

var checkall = document.getElementsByName("checkbox[]");
//全选
function select() {
    for (var $i = 0; $i < checkall.length; $i++) {
        checkall[$i].checked = true;
    }
};
//反选
function reverse() {
    for (var $i = 0; $i < checkall.length; $i++) {
        if (checkall[$i].checked) {
            checkall[$i].checked = false;
        } else {
            checkall[$i].checked = true;
        }
    }
}
//全不选     
function noselect() {
    for (var $i = 0; $i < checkall.length; $i++) {
        checkall[$i].checked = false;
    }
}

//IE6-9禁止用户选中文本
/*document.body.onselectstart = document.body.ondrag = function () {
    return false;
};*/

//启用工具提示
$('[data-toggle="tooltip"]').tooltip();


//禁止右键菜单
/*window.oncontextmenu = function(){
	return false;
};*/

/*自定义右键菜单*/
/*(function () {
    var oMenu = document.getElementById("rightClickMenu");
    var aLi = oMenu.getElementsByTagName("li");
	//加载后隐藏自定义右键菜单
	//oMenu.style.display = "none";
    //菜单鼠标移入/移出样式
    for (i = 0; i < aLi.length; i++) {
        //鼠标移入样式
        aLi[i].onmouseover = function () {
            $(this).addClass('rightClickMenuActive');
			//this.className = "rightClickMenuActive";
        };
        //鼠标移出样式
        aLi[i].onmouseout = function () {
            $(this).removeClass('rightClickMenuActive');
			//this.className = "";
        };
    }
    //自定义菜单
    document.oncontextmenu = function (event) {
		$(oMenu).fadeOut(0);
        var event = event || window.event;
        var style = oMenu.style;
        $(oMenu).fadeIn(300);
		//style.display = "block";
        style.top = event.clientY + "px";
        style.left = event.clientX + "px";
        return false;
    };
    //页面点击后自定义菜单消失
    document.onclick = function () {
        $(oMenu).fadeOut(100);
		//oMenu.style.display = "none"
    }
})();*/

/*禁止键盘操作*/
/*document.onkeydown=function(event){
	var e = event || window.event || arguments.callee.caller.arguments[0];
	if((e.keyCode === 123) || (e.ctrlKey) || (e.ctrlKey) && (e.keyCode === 85)){
		return false;
	}
}; */
/*登录*/
$("#loginModalForm").submit(function (event) {
    event.preventDefault();
    var username = $("#userName").val().replace(/\s/g, "");
    var password = $("#userPwd").val().replace(/\s/g, "");
    var isThis = $(this);
    isThis.find('.comment-prompt').show();
    isThis.find('.comment-prompt-text').hide();
    isThis.find('input[type=text]').attr("disabled", true);
    isThis.find('input[type=password]').attr("disabled", true);
    $('.footer').hide();
    $.ajax({
        type: "POST",
        url: "/ajax.php",
        data: "function=Login&age=" + username + "//,//" + password + "//,//admin",
        cache: false, //不缓存此页面  
        success: function (data) {
            if (data != "true") {
                isThis.find('.comment-prompt').hide();
                isThis.find('.comment-prompt-text').show();
                isThis.find('input[type=text]').attr("disabled", false);
                isThis.find('input[type=password]').attr("disabled", false);
                $('.footer').show();
                mes = data == "NoAdmin" ? "此账号不具备管理员权限！即将返回首页！" : "用户名或密码错误";
                iziToast.error({
                    title: '登录失败',
                    message: mes,
                    position: 'topCenter',
                    transitionIn: 'fadeInDown',
                    timeout: 2000,
                    zindex: 1100,
                    pauseOnHover: false,
                    onOpening: function () {
                        $('#loginModalUserName').focus();
                    },
                });
                if (data == "NoAdmin") {
                    setTimeout(function () { window.location.replace("/"); }, 2468);
                }
            } else {
                window.location.replace("/Admin")
            }
        }
    });
})

/*注销*/
$("#logoutButton").click(function () {
    $.ajax({
        type: "POST",
        url: "/ajax.php",
        data: "function=Logout",
        cache: false, //不缓存此页面  
        success: function (data) {
            if (data == "true")
                window.location.replace("/")
        }
    });
})

/*站点设置*/
$("#setting").submit(function (event) {
    event.preventDefault();
    var title = $("input[name=title]").val();
    var subtitle = $("input[name=subtitle]").val();
    var Url = $("input[name=Url]").val();
    var Keywords = $("input[name=Keywords]").val();
    var Description = $("textarea[name=Description]").text();
    var email = $("input[name=email]").val();
    var icp = $("input[name=ICP]").val();
    var Copyright = $("input[name=Copyright]").val();
    var LoginOut = $("input[name=LoginOut]").val();
    $.ajax({
        type: "POST",
        url: "/ajax.php",
        data: "function=Setting&age=" + title + "//,//" + subtitle + "//,//" + Url + "//,//" + Keywords + "//,//" + Description + "//,//" + email + "//,//" + icp + "//,//" + Copyright + "//,//" + LoginOut,
        cache: false, //不缓存此页面  
        success: function (data) {
            if (data == "true") {
                iziToast.success({
                    title: '更新成功',
                    message: '已成功更新配置文件!',
                    position: 'bottomRight',
                    transitionIn: 'bounceInLeft',
                    zindex: 1100,
                    pauseOnHover: false,
                });
                setTimeout(function () {
                    iziToast.warning({
                        title: '特殊提醒',
                        message: '‘登录超时’在更新后很有可能无法影响到已登录的用户！',
                        position: 'bottomRight',
                        transitionIn: 'bounceInLeft',
                        zindex: 1100,
                        pauseOnHover: false,
                    });
                }, 500);
            }
        }
    });
})

/*阅读设置*/
$("#read_set").submit(function (event) {
    event.preventDefault();
    var show_num = $("input[name=show_num]").val();
    var page_num = $("input[name=page_num]").val();
    var carousel_num = $("input[name=carousel_num]").val();
    var hot_num = $("input[name=hot_num]").val();
    var category_num = $("input[name=category_num]").val();
    var Live2Ds = $("input[name=Live2Ds]").val();
    var ones = $("input[name=ones]").val();
    $.ajax({
        type: "POST",
        url: "/ajax.php",
        data: "function=ReadSet&age=" + show_num + "//,//" + page_num + "//,//" + carousel_num + "//,//" + hot_num + "//,//" + category_num + "//,//" + Live2Ds + "//,//" + ones,
        cache: false, //不缓存此页面  
        success: function (data) {
            if (data == "true") {
                iziToast.success({
                    title: '更新成功',
                    message: '已成功更新配置文件!',
                    position: 'bottomRight',
                    transitionIn: 'bounceInLeft',
                    zindex: 1100,
                    pauseOnHover: false,
                });
            }
        }
    });
})