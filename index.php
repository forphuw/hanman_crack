<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <!--声明文档兼容模式，表示使用IE浏览器的最新模式-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--设置视口的宽度(值为设备的理想宽度)，页面初始缩放值<理想宽度/可见宽度>-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <title>hello·hanman</title>
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

  <style type="text/css">
.pwd-box{  
        width: 270px;
      margin: 0 auto;
      border: 1px solid #cccccc;
      font-size: 0px;
      border-radius: 3px; 
overflow:hidden  
    }  
    .pwd-box input[type="tel"]{  
        width: 99%;  
        height: 45px;  
        color: transparent;  
        position: absolute;  
        top: 0;  
        left: 0;  
        border: none;  
        font-size: 18px;  
        opacity: 0;  
        z-index: 1;  
        letter-spacing: 35px;  
    }  
    .fake-box input{  
        width: 44px;  
        height: 48px;  
        border: none;  
        border-right: 1px solid #e5e5e5;  
        text-align: center;  
        font-size: 30px;  
    }  
    .fake-box input:nth-last-child(1){  
        border:none;  
    }  
    </style>
</head>
<body>
 
<div class="container">
   <div class="row">
     <h1 class ="text-center"><img src="https://lzyxcf.com/banner/My/b_szy.jpg" height="100px"></h1>
   </div>   
    <div class="row">
          <span>请在此输入搜索·韩漫·关键字/词：</span>
            <div class="input-group">
                <input class="form-control col-xs-8" id="urlinput" type="text" value="弱点" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-primary" onclick="search()" id='getDaan'>获取漫画</button>
                </span>
            </div>
          <span class="help-block">使用过程中如果遇到问题请联系：forphuw@gmail.com - <span>收集于http://xxmh60.com</span><div style="display:none;"><script type="text/javascript" src="https://s9.cnzz.com/z_stat.php?id=1278632238&web_id=1278632238"></script></div></span>
    </div>
  <div class="row">
         <div id="showSearch">
           <div style="display:none" id="loading">
           <img id="loading-img"  src="https://lzyxcf.com/res/loading.svg">
          韩漫获取中，请耐心等待...</div>
    </div>
    </div>
</div>

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
  $("body").keydown(function() {
	             if (event.keyCode == "13"&&$("#urlinput").val()!="") {//keyCode=13是回车键
	                 $('#getDaan').click();//换成按钮的id即可
	             }
	         });
  
  function search(){
    $('#showSearch').html('<div style="display:block" id="loading"><img id="loading-img" src="https://lzyxcf.com/res/loading.svg">视频获取中，请耐心等待...</div>');
    //$('#getDaan').attr('disabled',true);
    //$('#loading-img').css('display','block');
    val = $('#urlinput').val();
    
    $.ajax({
        type: "GET",
        url: "indexsearch.php?wd="+val,
        success: function(data) {
            //alert(data.code);
            if(data.code==200){
                resultStr = '';
                for(i=0;i<data.content.length;i++){
                    urlm = data.content[i].id;
                    namem = data.content[i].name;
                    desm = data.content[i].description
                    imgm = data.content[i].coverUrl
                    chapterCount = data.content[i].chapterCount
                    readCount = data.content[i].readCount
                    resultStr = resultStr + '<div class="panel panel-success" >';
                    resultStr = resultStr + '<div class="panel-heading"  onclick="go2play(\''+urlm+'&name='+namem+'\');"><h3 class="panel-title">'+namem+' - 更新到：'+chapterCount+'</h3></div><div class="panel-body"><div class="media"><span class="media-left">';
                    resultStr = resultStr + '<img height="250px;" id="imgcover" onclick="go2play(\''+urlm+'\');" src="'+imgm+'" alt=""></span><div class="media-body"><p>阅读：'+readCount+'</p><p>简介：';
                    resultStr = resultStr + desm.slice(0,86)+'</p></div></div></div></div>';
                }
            }
             $('#showSearch').html(resultStr);
            
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
    
  }
  function go2play(value){
  	window.open("readmh.php?url="+value);
    //window.open("//cn.gimy.tv/video/"+value);
  }
      </script>
  

</body>
</html>
