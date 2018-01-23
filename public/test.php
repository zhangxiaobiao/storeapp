<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>System Error</title>
    <meta name="robots" content="noindex,nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <style>
        /* Base */
        body {
            color: #333;
            font: 14px Verdana, "Helvetica Neue", helvetica, Arial, 'Microsoft YaHei', sans-serif;
            margin: 0;
            padding: 0 20px 20px;
            word-break: break-word;
        }
        h1{
            margin: 10px 0 0;
            font-size: 28px;
            font-weight: 500;
            line-height: 32px;
        }
        h2{
            color: #4288ce;
            font-weight: 400;
            padding: 6px 0;
            margin: 6px 0 0;
            font-size: 18px;
            border-bottom: 1px solid #eee;
        }
        h3.subheading {
            color: #4288ce;
            margin: 6px 0 0;
            font-weight: 400;
        }
        h3{
            margin: 12px;
            font-size: 16px;
            font-weight: bold;
        }
        abbr{
            cursor: help;
            text-decoration: underline;
            text-decoration-style: dotted;
        }
        a{
            color: #868686;
            cursor: pointer;
        }
        a:hover{
            text-decoration: underline;
        }
        .line-error{
            background: #f8cbcb;
        }

        .echo table {
            width: 100%;
        }

        .echo pre {
            padding: 16px;
            overflow: auto;
            font-size: 85%;
            line-height: 1.45;
            background-color: #f7f7f7;
            border: 0;
            border-radius: 3px;
            font-family: Consolas, "Liberation Mono", Menlo, Courier, monospace;
        }

        .echo pre > pre {
            padding: 0;
            margin: 0;
        }
        /* Layout */
        .col-md-3 {
            width: 25%;
        }
        .col-md-9 {
            width: 75%;
        }
        [class^="col-md-"] {
            float: left;
        }
        .clearfix {
            clear:both;
        }
        @media only screen
        and (min-device-width : 375px)
        and (max-device-width : 667px) {
            .col-md-3,
            .col-md-9 {
                width: 100%;
            }
        }
        /* Exception Info */
        .exception {
            margin-top: 20px;
        }
        .exception .message{
            padding: 12px;
            border: 1px solid #ddd;
            border-bottom: 0 none;
            line-height: 18px;
            font-size:16px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            font-family: Consolas,"Liberation Mono",Courier,Verdana,"微软雅黑";
        }

        .exception .code{
            float: left;
            text-align: center;
            color: #fff;
            margin-right: 12px;
            padding: 16px;
            border-radius: 4px;
            background: #999;
        }
        .exception .source-code{
            padding: 6px;
            border: 1px solid #ddd;

            background: #f9f9f9;
            overflow-x: auto;

        }
        .exception .source-code pre{
            margin: 0;
        }
        .exception .source-code pre ol{
            margin: 0;
            color: #4288ce;
            display: inline-block;
            min-width: 100%;
            box-sizing: border-box;
            font-size:14px;
            font-family: "Century Gothic",Consolas,"Liberation Mono",Courier,Verdana;
            padding-left: 56px;
        }
        .exception .source-code pre li{
            border-left: 1px solid #ddd;
            height: 18px;
            line-height: 18px;
        }
        .exception .source-code pre code{
            color: #333;
            height: 100%;
            display: inline-block;
            border-left: 1px solid #fff;
            font-size:14px;
            font-family: Consolas,"Liberation Mono",Courier,Verdana,"微软雅黑";
        }
        .exception .trace{
            padding: 6px;
            border: 1px solid #ddd;
            border-top: 0 none;
            line-height: 16px;
            font-size:14px;
            font-family: Consolas,"Liberation Mono",Courier,Verdana,"微软雅黑";
        }
        .exception .trace ol{
            margin: 12px;
        }
        .exception .trace ol li{
            padding: 2px 4px;
        }
        .exception div:last-child{
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        /* Exception Variables */
        .exception-var table{
            width: 100%;
            margin: 12px 0;
            box-sizing: border-box;
            table-layout:fixed;
            word-wrap:break-word;
        }
        .exception-var table caption{
            text-align: left;
            font-size: 16px;
            font-weight: bold;
            padding: 6px 0;
        }
        .exception-var table caption small{
            font-weight: 300;
            display: inline-block;
            margin-left: 10px;
            color: #ccc;
        }
        .exception-var table tbody{
            font-size: 13px;
            font-family: Consolas,"Liberation Mono",Courier,"微软雅黑";
        }
        .exception-var table td{
            padding: 0 6px;
            vertical-align: top;
            word-break: break-all;
        }
        .exception-var table td:first-child{
            width: 28%;
            font-weight: bold;
            white-space: nowrap;
        }
        .exception-var table td pre{
            margin: 0;
        }

        /* Copyright Info */
        .copyright{
            margin-top: 24px;
            padding: 12px 0;
            border-top: 1px solid #eee;
        }

        /* SPAN elements with the classes below are added by prettyprint. */
        pre.prettyprint .pln { color: #000 }  /* plain text */
        pre.prettyprint .str { color: #080 }  /* string content */
        pre.prettyprint .kwd { color: #008 }  /* a keyword */
        pre.prettyprint .com { color: #800 }  /* a comment */
        pre.prettyprint .typ { color: #606 }  /* a type name */
        pre.prettyprint .lit { color: #066 }  /* a literal value */
        /* punctuation, lisp open bracket, lisp close bracket */
        pre.prettyprint .pun, pre.prettyprint .opn, pre.prettyprint .clo { color: #660 }
        pre.prettyprint .tag { color: #008 }  /* a markup tag name */
        pre.prettyprint .atn { color: #606 }  /* a markup attribute name */
        pre.prettyprint .atv { color: #080 }  /* a markup attribute value */
        pre.prettyprint .dec, pre.prettyprint .var { color: #606 }  /* a declaration; a variable name */
        pre.prettyprint .fun { color: red }  /* a function name */
    </style>
</head>
<body>
<div class="echo">
</div>
<div class="exception">
    <div class="message">

        <div class="info">
            <div>
                <h2>[8] <abbr title="think\exception\ErrorException">ErrorException</abbr> in <a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/app/store/controller/AdminProductOrderController.php line 118">AdminProductOrderController.php line 118</a></h2>
            </div>
            <div><h1>Array to string conversion</h1></div>
        </div>

    </div>
    <div class="source-code">
            <pre class="prettyprint lang-php"><ol start="109"><li class="line-109"><code>        $order-&gt;admin_note = $post['admin_note'];
</code></li><li class="line-110"><code>        $order-&gt;status = 2;
</code></li><li class="line-111"><code>        $order-&gt;save();
</code></li><li class="line-112"><code>
</code></li><li class="line-113"><code>        //更新发货表
</code></li><li class="line-114"><code>        $shipping['order_id'] = $order-&gt;id;
</code></li><li class="line-115"><code>        $shipping['order_sn'] = $order-&gt;product_order_no;
</code></li><li class="line-116"><code>        $shipping['user_id'] = $order-&gt;user_id;
</code></li><li class="line-117"><code>        $shipping['admin_id'] = cmf_get_current_admin_id();
</code></li><li class="line-118"><code>        $address = json_decode(&quot;$order-&gt;snap_address&quot;, true);
</code></li><li class="line-119"><code>        $shipping['consignee'] = $address['name'];
</code></li><li class="line-120"><code>        $shipping['mobile'] = $address['mobile'];
</code></li><li class="line-121"><code>        $shipping['province'] = $address['province'];
</code></li><li class="line-122"><code>        $shipping['city'] = $address['city'];
</code></li><li class="line-123"><code>        $shipping['district'] = $address['country'];
</code></li><li class="line-124"><code>        $shipping['address'] = $address['detail'];
</code></li><li class="line-125"><code>        $shipping['shipping_price'] = $order-&gt;shipping_price;
</code></li><li class="line-126"><code>
</code></li><li class="line-127"><code>        DeliveryModel::create($shipping);
</code></li></ol></pre>
    </div>
    <div class="trace">
        <h2>Call Stack</h2>
        <ol>
            <li>in <a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/app/store/controller/AdminProductOrderController.php line 118">AdminProductOrderController.php line 118</a></li>
            <li>
                at <abbr title="think\Error">Error</abbr>::appError(8, '<a class="toggle" title="Array to string conversion">Array to string conv...</a>', '<a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/app/store/controller/AdminProductOrderController.php">/Users/zhangshibiao/...</a>', 118, ['post' => ['admin_note' => '', 'id' => '3'], 'order' => <em>object</em>(<abbr title="app\store\model\ProductOrderModel">ProductOrderModel</abbr>), 'shipping' => ['order_id' => 3, 'order_sn' => 'B120308723933766', 'user_id' => ['mobile' => '', 'user_nickname' => '☞♛☜'], ...]]) in <a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/app/store/controller/AdminProductOrderController.php line 118">AdminProductOrderController.php line 118</a>                </li>
            <li>
                at <abbr title="app\store\controller\AdminProductOrderController">AdminProductOrderController</abbr>->confirm()                </li>
            <li>
                at <abbr title="ReflectionMethod">ReflectionMethod</abbr>->invokeArgs(<em>object</em>(<abbr title="app\store\controller\AdminProductOrderController">AdminProductOrderController</abbr>), []) in <a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/simplewind/thinkphp/library/think/App.php line 197">App.php line 197</a>                </li>
            <li>
                at <abbr title="think\App">App</abbr>::invokeMethod([<em>object</em>(<abbr title="app\store\controller\AdminProductOrderController">AdminProductOrderController</abbr>), 'confirm'], []) in <a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/simplewind/thinkphp/library/think/App.php line 411">App.php line 411</a>                </li>
            <li>
                at <abbr title="think\App">App</abbr>::module(['store', 'admin_product_order', 'confirm'], ['app_host' => '', 'app_debug' => <em>true</em>, 'app_trace' => <em>true</em>, ...], <em>true</em>) in <a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/simplewind/thinkphp/library/think/App.php line 296">App.php line 296</a>                </li>
            <li>
                at <abbr title="think\App">App</abbr>::exec(['type' => 'module', 'module' => ['store', 'admin_product_order', 'confirm']], ['app_host' => '', 'app_debug' => <em>true</em>, 'app_trace' => <em>true</em>, ...]) in <a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/simplewind/thinkphp/library/think/App.php line 124">App.php line 124</a>                </li>
            <li>
                at <abbr title="think\App">App</abbr>::run() in <a class="toggle" title="/Users/zhangshibiao/code/php/storeapp/public/index.php line 41">index.php line 41</a>                </li>
        </ol>
    </div>
</div>

<div class="exception-var">
    <h2>Exception Datas</h2>
    <table>
        <caption>Error Context</caption>
        <tbody>
        <tr>
            <td>post</td>
            <td>
                {
                &quot;admin_note&quot;: &quot;&quot;,
                &quot;id&quot;: &quot;3&quot;
                }                    </td>
        </tr>
        <tr>
            <td>order</td>
            <td>
                {
                &quot;id&quot;: 3,
                &quot;product_order_no&quot;: &quot;B120308723933766&quot;,
                &quot;user_id&quot;: {
                &quot;mobile&quot;: &quot;&quot;,
                &quot;user_nickname&quot;: &quot;\u261e\u265b\u261c&quot;
                },
                &quot;total_price&quot;: &quot;0.01&quot;,
                &quot;status&quot;: {
                &quot;status&quot;: 2,
                &quot;status_info&quot;: &quot;\u5df2\u786e\u8ba4&quot;
                },
                &quot;snap_img&quot;: &quot;http:\/\/storeapp.com\/upload\/store\/20171209\/55ececd9698e0f41af2fb73013c3dd7d.jpg&quot;,
                &quot;snap_name&quot;: &quot;\u5b63\u5ea6\u8fd0\u8425\u670d\u52a1\u8d39\u7528&quot;,
                &quot;snap_subname&quot;: &quot;&quot;,
                &quot;total_count&quot;: 1,
                &quot;pay_time&quot;: &quot;\u672a\u4ed8\u6b3e&quot;,
                &quot;create_time&quot;: 1516430872,
                &quot;send_time&quot;: null,
                &quot;done_time&quot;: null,
                &quot;snap_items&quot;: [
                {
                &quot;id&quot;: 4,
                &quot;haveStock&quot;: true,
                &quot;counts&quot;: &quot;1&quot;,
                &quot;price&quot;: &quot;0.01&quot;,
                &quot;title&quot;: &quot;\u5b63\u5ea6\u8fd0\u8425\u670d\u52a1\u8d39\u7528&quot;,
                &quot;thumb&quot;: &quot;http:\/\/storeapp.com\/upload\/store\/20171209\/55ececd9698e0f41af2fb73013c3dd7d.jpg&quot;,
                &quot;totalPrice&quot;: 0.01
                }
                ],
                &quot;snap_address&quot;: {
                &quot;name&quot;: &quot;\u5f20\u4e09&quot;,
                &quot;mobile&quot;: &quot;020-81167888&quot;,
                &quot;province&quot;: &quot;\u5e7f\u4e1c\u7701&quot;,
                &quot;city&quot;: &quot;\u5e7f\u5dde\u5e02&quot;,
                &quot;street&quot;: null,
                &quot;detail&quot;: &quot;\u65b0\u6e2f\u4e2d\u8def397\u53f7&quot;,
                &quot;country&quot;: &quot;\u6d77\u73e0\u533a&quot;,
                &quot;district&quot;: null,
                &quot;address&quot;: null
                },
                &quot;note&quot;: &quot;&quot;,
                &quot;prepay_id&quot;: &quot;&quot;,
                &quot;user_note&quot;: &quot;&quot;,
                &quot;admin_note&quot;: &quot;&quot;,
                &quot;delete_time&quot;: 0,
                &quot;invoice_info&quot;: &quot;&quot;,
                &quot;shipping_code&quot;: &quot;&quot;,
                &quot;shipping_name&quot;: &quot;&quot;,
                &quot;shipping_price&quot;: &quot;0.00&quot;
                }                    </td>
        </tr>
        <tr>
            <td>shipping</td>
            <td>
                {
                &quot;order_id&quot;: 3,
                &quot;order_sn&quot;: &quot;B120308723933766&quot;,
                &quot;user_id&quot;: {
                &quot;mobile&quot;: &quot;&quot;,
                &quot;user_nickname&quot;: &quot;\u261e\u265b\u261c&quot;
                },
                &quot;admin_id&quot;: 1
                }                    </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="exception-var">
    <h2>Environment Variables</h2>
    <div>
        <div class="clearfix">
            <div class="col-md-3"><strong>GET Data</strong></div>
            <div class="col-md-9"><small>empty</small></div>
        </div>
    </div>
    <div>
        <h3 class="subheading">POST Data</h3>
        <div>
            <div class="clearfix">
                <div class="col-md-3"><strong>admin_note</strong></div>
                <div class="col-md-9"><small>
                    </small></div>
            </div>
        </div>
    </div>
    <div>
        <div class="clearfix">
            <div class="col-md-3"><strong>Files</strong></div>
            <div class="col-md-9"><small>empty</small></div>
        </div>
    </div>
    <div>
        <h3 class="subheading">Cookies</h3>
        <div>
            <div class="clearfix">
                <div class="col-md-3"><strong>thinkphp_show_page_trace</strong></div>
                <div class="col-md-9"><small>
                        0|0                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>PHPSESSID</strong></div>
                <div class="col-md-9"><small>
                        1hg6fs99r37bl69o3pe3j407c2                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>admin_username</strong></div>
                <div class="col-md-9"><small>
                        admin                    </small></div>
            </div>
        </div>
    </div>
    <div>
        <h3 class="subheading">Session</h3>
        <div>
            <div class="clearfix">
                <div class="col-md-3"><strong>think</strong></div>
                <div class="col-md-9"><small>
                        {
                        &quot;__SP_ADMIN_LOGIN_PAGE_SHOWED_SUCCESS__&quot;: true,
                        &quot;ADMIN_ID&quot;: 1,
                        &quot;name&quot;: &quot;admin&quot;,
                        &quot;token&quot;: &quot;fdd94c7e07c53dcf0811b00298098b07f091371b0eefc300d2f0c63756ff30fd&quot;,
                        &quot;admin_menu_index&quot;: &quot;Menu\/lists&quot;
                        }                    </small></div>
            </div>
        </div>
    </div>
    <div>
        <h3 class="subheading">Server/Request Data</h3>
        <div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REDIRECT_UNIQUE_ID</strong></div>
                <div class="col-md-9"><small>
                        WmVbSn8AAAEAAIZLNeEAAAAF                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REDIRECT_STATUS</strong></div>
                <div class="col-md-9"><small>
                        200                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>UNIQUE_ID</strong></div>
                <div class="col-md-9"><small>
                        WmVbSn8AAAEAAIZLNeEAAAAF                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_HOST</strong></div>
                <div class="col-md-9"><small>
                        storeapp.com                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_CONNECTION</strong></div>
                <div class="col-md-9"><small>
                        keep-alive                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CONTENT_LENGTH</strong></div>
                <div class="col-md-9"><small>
                        11                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_ACCEPT</strong></div>
                <div class="col-md-9"><small>
                        application/json, text/javascript, */*; q=0.01                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_ORIGIN</strong></div>
                <div class="col-md-9"><small>
                        http://storeapp.com                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_X_REQUESTED_WITH</strong></div>
                <div class="col-md-9"><small>
                        XMLHttpRequest                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_USER_AGENT</strong></div>
                <div class="col-md-9"><small>
                        Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CONTENT_TYPE</strong></div>
                <div class="col-md-9"><small>
                        application/x-www-form-urlencoded; charset=UTF-8                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_REFERER</strong></div>
                <div class="col-md-9"><small>
                        http://storeapp.com/store/admin_product_order/detail/id/3.html                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_ACCEPT_ENCODING</strong></div>
                <div class="col-md-9"><small>
                        gzip, deflate                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_ACCEPT_LANGUAGE</strong></div>
                <div class="col-md-9"><small>
                        zh-CN,zh;q=0.9                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTTP_COOKIE</strong></div>
                <div class="col-md-9"><small>
                        thinkphp_show_page_trace=0|0; thinkphp_show_page_trace=0|0; PHPSESSID=1hg6fs99r37bl69o3pe3j407c2; admin_username=admin                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>PATH</strong></div>
                <div class="col-md-9"><small>
                        /usr/bin:/bin:/usr/sbin:/sbin                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>DYLD_LIBRARY_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Applications/XAMPP/xamppfiles/lib                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SERVER_SIGNATURE</strong></div>
                <div class="col-md-9"><small>
                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SERVER_SOFTWARE</strong></div>
                <div class="col-md-9"><small>
                        Apache/2.4.18 (Unix) OpenSSL/1.0.2f PHP/7.0.2 mod_perl/2.0.8-dev Perl/v5.16.3                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SERVER_NAME</strong></div>
                <div class="col-md-9"><small>
                        storeapp.com                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SERVER_ADDR</strong></div>
                <div class="col-md-9"><small>
                        127.0.0.1                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SERVER_PORT</strong></div>
                <div class="col-md-9"><small>
                        80                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REMOTE_ADDR</strong></div>
                <div class="col-md-9"><small>
                        127.0.0.1                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>DOCUMENT_ROOT</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REQUEST_SCHEME</strong></div>
                <div class="col-md-9"><small>
                        http                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CONTEXT_PREFIX</strong></div>
                <div class="col-md-9"><small>
                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CONTEXT_DOCUMENT_ROOT</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SERVER_ADMIN</strong></div>
                <div class="col-md-9"><small>
                        you@example.com                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SCRIPT_FILENAME</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/index.php                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REMOTE_PORT</strong></div>
                <div class="col-md-9"><small>
                        57599                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REDIRECT_URL</strong></div>
                <div class="col-md-9"><small>
                        /store/admin_product_order/confirm/id/3.html                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REDIRECT_QUERY_STRING</strong></div>
                <div class="col-md-9"><small>
                        s=store/admin_product_order/confirm/id/3.html                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>GATEWAY_INTERFACE</strong></div>
                <div class="col-md-9"><small>
                        CGI/1.1                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SERVER_PROTOCOL</strong></div>
                <div class="col-md-9"><small>
                        HTTP/1.1                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REQUEST_METHOD</strong></div>
                <div class="col-md-9"><small>
                        POST                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>QUERY_STRING</strong></div>
                <div class="col-md-9"><small>
                        s=store/admin_product_order/confirm/id/3.html                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REQUEST_URI</strong></div>
                <div class="col-md-9"><small>
                        /store/admin_product_order/confirm/id/3.html                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>SCRIPT_NAME</strong></div>
                <div class="col-md-9"><small>
                        /index.php                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>PHP_SELF</strong></div>
                <div class="col-md-9"><small>
                        /index.php                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REQUEST_TIME_FLOAT</strong></div>
                <div class="col-md-9"><small>
                        1516591946.279                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>REQUEST_TIME</strong></div>
                <div class="col-md-9"><small>
                        1516591946                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>PATH_INFO</strong></div>
                <div class="col-md-9"><small>
                        store/admin_product_order/confirm/id/3.html                    </small></div>
            </div>
        </div>
    </div>
    <div>
        <div class="clearfix">
            <div class="col-md-3"><strong>Environment Variables</strong></div>
            <div class="col-md-9"><small>empty</small></div>
        </div>
    </div>
    <div>
        <h3 class="subheading">ThinkPHP Constants</h3>
        <div>
            <div class="clearfix">
                <div class="col-md-3"><strong>APP_DEBUG</strong></div>
                <div class="col-md-9"><small>
                        true                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CMF_ROOT</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>APP_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../app/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CMF_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../simplewind/cmf/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>PLUGINS_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/plugins/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>EXTEND_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../simplewind/extend/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>VENDOR_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../simplewind/vendor/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>RUNTIME_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../data/runtime/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>THINKCMF_VERSION</strong></div>
                <div class="col-md-9"><small>
                        5.0.170927                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>THINK_VERSION</strong></div>
                <div class="col-md-9"><small>
                        5.0.11                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>THINK_START_TIME</strong></div>
                <div class="col-md-9"><small>
                        1516591946.2801                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>THINK_START_MEM</strong></div>
                <div class="col-md-9"><small>
                        394856                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>EXT</strong></div>
                <div class="col-md-9"><small>
                        .php                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>DS</strong></div>
                <div class="col-md-9"><small>
                        /                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>THINK_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/simplewind/thinkphp/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>LIB_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/simplewind/thinkphp/library/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CORE_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/simplewind/thinkphp/library/think/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>TRAIT_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/simplewind/thinkphp/library/traits/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>ROOT_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>LOG_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../data/runtime/log/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CACHE_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../data/runtime/cache/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>TEMP_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../data/runtime/temp/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CONF_PATH</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/public/../app/                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>CONF_EXT</strong></div>
                <div class="col-md-9"><small>
                        .php                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>ENV_PREFIX</strong></div>
                <div class="col-md-9"><small>
                        PHP_                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>IS_CLI</strong></div>
                <div class="col-md-9"><small>
                        false                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>IS_WIN</strong></div>
                <div class="col-md-9"><small>
                        false                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>HTMLPURIFIER_PREFIX</strong></div>
                <div class="col-md-9"><small>
                        /Users/zhangshibiao/code/php/storeapp/simplewind/vendor/ezyang/htmlpurifier/library                    </small></div>
            </div>
            <div class="clearfix">
                <div class="col-md-3"><strong>QINIU_FUNCTIONS_VERSION</strong></div>
                <div class="col-md-9"><small>
                        7.2.1                    </small></div>
            </div>
        </div>
    </div>
</div>

<div class="copyright">
    <a title="官方网站" href="http://www.thinkphp.cn">ThinkPHP</a>
    <span>V5.0.11</span>
    <span>{ 十年磨一剑-为API开发设计的高性能框架 }</span>
</div>
<script>
    var LINE = 118;

    function $(selector, node){
        var elements;

        node = node || document;
        if(document.querySelectorAll){
            elements = node.querySelectorAll(selector);
        } else {
            switch(selector.substr(0, 1)){
                case '#':
                    elements = [node.getElementById(selector.substr(1))];
                    break;
                case '.':
                    if(document.getElementsByClassName){
                        elements = node.getElementsByClassName(selector.substr(1));
                    } else {
                        elements = get_elements_by_class(selector.substr(1), node);
                    }
                    break;
                default:
                    elements = node.getElementsByTagName();
            }
        }
        return elements;

        function get_elements_by_class(search_class, node, tag) {
            var elements = [], eles,
                pattern  = new RegExp('(^|\\s)' + search_class + '(\\s|$)');

            node = node || document;
            tag  = tag  || '*';

            eles = node.getElementsByTagName(tag);
            for(var i = 0; i < eles.length; i++) {
                if(pattern.test(eles[i].className)) {
                    elements.push(eles[i])
                }
            }

            return elements;
        }
    }

    $.getScript = function(src, func){
        var script = document.createElement('script');

        script.async  = 'async';
        script.src    = src;
        script.onload = func || function(){};

        $('head')[0].appendChild(script);
    }

    ;(function(){
        var files = $('.toggle');
        var ol    = $('ol', $('.prettyprint')[0]);
        var li    = $('li', ol[0]);

        // 短路径和长路径变换
        for(var i = 0; i < files.length; i++){
            files[i].ondblclick = function(){
                var title = this.title;

                this.title = this.innerHTML;
                this.innerHTML = title;
            }
        }

        // 设置出错行
        var err_line = $('.line-' + LINE, ol[0])[0];
        err_line.className = err_line.className + ' line-error';

        $.getScript('//cdn.bootcss.com/prettify/r298/prettify.min.js', function(){
            prettyPrint();

            // 解决Firefox浏览器一个很诡异的问题
            // 当代码高亮后，ol的行号莫名其妙的错位
            // 但是只要刷新li里面的html重新渲染就没有问题了
            if(window.navigator.userAgent.indexOf('Firefox') >= 0){
                ol[0].innerHTML = ol[0].innerHTML;
            }
        });

    })();
</script>
</body>
</html>
