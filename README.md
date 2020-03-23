## 方便阅读一个韩国漫画平台![logo](https://github.com/forphuw/hanman_crack/blob/master/images/logo.png)
通过不断创建新用户（新用户有余额可以购买一章）来购买章节，对已购买章节，系统会将json数据文件存入manhua目录，下次直接点用json数据，不再购买。
### index.php : 主界面，截图如下
使用了bootstrap，ajax，jquery
![indeximg](https://github.com/forphuw/hanman_crack/blob/master/images/index.jpg)
### indexsearch.php : 主页的搜索，通过index.php中的ajax返回数据给主页
curl `$url="http://xxmh60.com/home/search/books?word=".$kw`，但是关键词需要编码：`$kw = urlencode($keyword);`
### php_fun.php : php公用函数
现在只有 检查并创建目录
### query.php : 请求网页
curl ` $url="http://xxmh60.com/home/query/directory/?bookId=".$kw;`，但关键字是数字，无需编码。
保存得到的目录json到manhua目录
### readmh.php : 读取并显示漫画目录
因为考虑更新原因，每次都直接用网上获取json数据，在存储到manhua目录
### readsingle.php : 漫画单页显示
先是查看是否已经保存来json数据，如有直接读取调用；如无，通过注册，获取cookie，购买，获取单页，显示

## 更新状态：
2020-03-16 14:02 - 添加了阅读界面下拉到底再持续加载图片，增加网络不好时候的阅读体验。
2020-03-23 16:20 - 添加了签到，这样新账户就有50+30=80金币，可以购买59金币的漫画了
