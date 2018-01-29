<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:55:"themes/admin_simpleboot3/store/admin_delivery/send.html";i:1516597170;s:88:"/Users/zhangshibiao/code/php/storeapp/public/themes/admin_simpleboot3/public/header.html";i:1511398688;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/",
            APP: '<?php echo \think\Request::instance()->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/wind.js"></script>
    <script src="/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip();
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>
<style type="text/css">
    .pic-list li {
        margin-bottom: 5px;
    }
</style>
</head>
<body>
<div class="wrap js-check-wrap">

    <form class="js-ajax-form" action="<?php echo url('AdminDelivery/send',array('id'=>$delivery['id'])); ?>" method="post">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">

                <tr>
                    <th  width="100">收货地址</th>
                    <td colspan="4">
                        收货人：<?php echo $delivery['order_sn']; ?><br/>
                        电话：<?php echo $delivery['create_time']; ?><br/>
                        配送方式:
                        <select name="shipping_code" id="" style="width: 100px">
                            <?php if(is_array($shippings) || $shippings instanceof \think\Collection || $shippings instanceof \think\Paginator): if( count($shippings)==0 ) : echo "" ;else: foreach($shippings as $key=>$vo): ?>
                                <option <?php if($delivery['shipping_code'] == $vo['shipping_code']): ?>selected=selected<?php endif; ?> value="<?php echo $vo['shipping_code']; ?>"><?php echo $vo['shipping_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>

                        </select>
                    </td>
                    <td colspan="3">
                        配送费用：<?php echo $delivery['shipping_price']; ?><br/>
                        快递单号：
                        <input style="width: 150px" type="text" name="invoice_no" value="<?php echo $delivery['invoice_no']; ?>">
                    </td>
                </tr>
                <tr>
                    <th width="100">收货地址</th>
                    <td colspan="7">
                        收货人：<?php echo $delivery['delivery_order']['snap_address']['name']; ?><br/>
                        电话：<?php echo $delivery['delivery_order']['snap_address']['mobile']; ?><br/>
                        地址：<?php echo $delivery['delivery_order']['snap_address']['province']; ?><?php echo $delivery['delivery_order']['snap_address']['city']; ?><?php echo $delivery['delivery_order']['snap_address']['country']; ?><?php echo $delivery['delivery_order']['snap_address']['detail']; ?>
                    </td>
                </tr>
                <tr>
                    <th width="100">留言</th>
                    <td colspan="7">
                        <?php echo (isset($delivery['delivery_order']['user_note']) && ($delivery['delivery_order']['user_note'] !== '')?$delivery['delivery_order']['user_note']:"无"); ?>
                    </td>
                </tr>
                <tr>
                    <th width="100">管理员备注</th>
                    <td colspan="7">
                        <?php echo $delivery['delivery_order']['admin_note']; ?>
                    </td>
                </tr>
                <tr>
                    <th width="100">发货备注</th>
                    <td colspan="7">
                            <div class="form-group">
                                <textarea name="note" class="form-control"><?php echo $delivery['note']; ?></textarea>
                            </div>




                    </td>
                </tr>
            </table>

        </div>

    </div>
    <table class="table table-hover table-bordered table-list">
        <thead>
        <tr>
            <th width="200">商品id</th>
            <th width="200">商品名称</th>
            <th width="200">购买个数</th>
            <th width="50">价格</th>
        </tr>
        </thead>
        <?php if(is_array($delivery['delivery_order']['snap_items']) || $delivery['delivery_order']['snap_items'] instanceof \think\Collection || $delivery['delivery_order']['snap_items'] instanceof \think\Paginator): if( count($delivery['delivery_order']['snap_items'])==0 ) : echo "" ;else: foreach($delivery['delivery_order']['snap_items'] as $key=>$vo): ?>
            <tr>
                <td>
                    <?php echo $vo['id']; ?>
                </td>
                <td>
                    <?php echo $vo['title']; ?>
                </td>
                <td>
                    <?php echo $vo['counts']; ?>
                </td>
                <td>
                    ￥<?php echo $vo['totalPrice']; ?>
                </td>

            </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>


    </table>
        <?php if(empty($delivery['shipping_code']) || (($delivery['shipping_code'] instanceof \think\Collection || $delivery['shipping_code'] instanceof \think\Paginator ) && $delivery['shipping_code']->isEmpty())): ?>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary js-ajax-submit">确定发货</button>
            </div>
        <?php endif; ?>

    </form>

</div>
<script type="text/javascript" src="/static/js/admin.js"></script>


</body>
</html>