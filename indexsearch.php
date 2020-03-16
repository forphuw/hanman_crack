<?php
$keyword = $_GET['wd'];
header("Content-Type: text/json;charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
//echo $keyword;

/*	get_search_json()
// @param{url:请求网址，带关键字
          }
   @return 统一返回json格式
*/
function get_search_json($url){
    $headerArray =array("Host: xxmh60.com","Connection: keep-alive","Cache-Control: max-age=0","Upgrade-Insecure-Requests: 1","DNT: 1","User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36","Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8","Accept-Language: zh-CN,zh;q=0.9");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
    $output = curl_exec($ch);
    curl_close($ch);
        //var_dump($output);
		$json = json_decode($output,true);
    return $json;
  }
$kw = urlencode($keyword);
$url="http://xxmh60.com/home/search/books?word=".$kw;
$json = get_search_json($url);
echo json_encode($json);

?>
