<script src="lib/ueditor/ueditor.config.js"></script>
<script src="lib/ueditor/ueditor.all.min.js"> </script>
<script src="lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script id="uploadEditor" type="text/plain" style="display:none;"></script>
<script type="text/javascript">
    var editor = UE.getEditor('article-content');
    var _uploadEditor;
    $(function() {
        //重新实例化一个编辑器，防止在上面的editor编辑器中显示上传的图片或者文件
        _uploadEditor = UE.getEditor('uploadEditor');
        _uploadEditor.ready(function() {
            //设置编辑器不可用
            //_uploadEditor.setDisabled();
            //隐藏编辑器，因为不会用到这个编辑器实例，所以要隐藏
            _uploadEditor.hide();
            //侦听图片上传
            _uploadEditor.addListener('beforeInsertImage', function(t, arg) {
                //将地址赋值给相应的input,只去第一张图片的路径
                $("#pictureUpload").attr("value", arg[0].src);
                //图片预览
                //$("#imgPreview").attr("src", arg[0].src);
            })
            //侦听文件上传，取上传文件列表中第一个上传的文件的路径
            _uploadEditor.addListener('afterUpfile', function(t, arg) {
                $("#fileUpload").attr("value", _uploadEditor.options.filePath + arg[0].url);
            })
        });
    });
    //弹出图片上传的对话框
    $('#upImage').click(function() {
        var myImage = _uploadEditor.getDialog("insertimage");
        myImage.open();
    });
    //弹出文件上传的对话框
    function upFiles() {
        var myFiles = _uploadEditor.getDialog("attachment");
        myFiles.open();
    }
</script>