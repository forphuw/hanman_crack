<?php if(!isset($_GET['url'])){echo "error no url(id)";exit;}?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <!--声明文档兼容模式，表示使用IE浏览器的最新模式-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--设置视口的宽度(值为设备的理想宽度)，页面初始缩放值<理想宽度/可见宽度>-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <title><?php echo $_GET['name']; ?> - 目录</title>
  <link href="./images/logo.png" rel="icon" type="image/x-ico">
 
  <!-- 引入Bootstrap核心样式文件 -->
  <!-- 新 Bootstrap 核心 CSS 文件 -->
  <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?011528a62aaa2933a3a62bbe1af55f44";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</head>
<body>
 
<div class="container">
    <div class="row">
    <p class="text-center"><?php echo $_GET['name']; ?><font id="loading"> - 正在加载中...</font></p>
         <div id="app">
         <div  v-for="(content,index) in contents">
            <a :href="'readsingle.php?oid=<?php echo $_GET['url']; ?>&id='+content.id" target="_blank" class="list-group-item">
                <img v-bind:src="content.coverUrl" style="max-width:30%;"><img><font style="font-size:22px;margin-left:5px">{{content.title}}</font>
            </a>
        </div>
           
         </div>
    </div>
</div>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>

<script>
    window.onload=function(){
        var val = <?php echo $_GET['url'];?>;
        var contents ;
        $.ajax({
        type: "GET",
        url: "query.php?tp=ml&wd="+val,
        async:false,
        success: function(data) {
            
            if(data.code==200){
                
                contents = data.content;
                $("#loading").text("");
            }
      },
        error: function (xhr, textStatus, errorThrown) {
            /*错误信息处理*/
　　　　　　　　alert("进入error---");
　　　　　　　　alert("状态码："+xhr.status);
　　　　　　　　alert("状态:"+xhr.readyState);//当前状态,0-未初始化，1-正在载入，2-已经载入，3-数据进行交互，4-完成。
　　　　　　　　alert("错误信息:"+xhr.statusText );
　　　　　　　　alert("返回响应信息："+xhr.responseText );//这里是详细的信息
　　　　　　　　alert("请求状态："+textStatus); 　　　　　　　　
　　　　　　　　alert(errorThrown); 　　　　　　　　
　　　　　　　　alert("请求失败"); 
　　　　} });
        
        console.log(contents)
    new Vue({
        el: '#app',
        data: {
            contents: contents
        }
        })
    }
    

      </script>
  

</body>
</html>
