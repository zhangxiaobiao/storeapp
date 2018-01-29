<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:56:"themes/admin_simpleboot3/store/admin_delivery/index.html";i:1516601948;s:88:"/Users/zhangshibiao/code/php/storeapp/public/themes/admin_simpleboot3/public/header.html";i:1511398688;}*/ ?>
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
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="javascript:;">发货管理</a></li>
    </ul>
    <form class="well form-inline margin-top-20" method="post" action="<?php echo url('AdminDelivery/index'); ?>">
        订单号:
        <input type="text" class="form-control" name="keyword" style="width: 200px;"
               value="<?php echo (isset($keyword) && ($keyword !== '')?$keyword:''); ?>" placeholder="请输入订单号...">
        发货状态:
        <select class="form-control" name="status" style="width: 140px;">
            <option value='999'>全部</option>
            <option value="2">待发货</option>
            <option value="3">已发货</option>
        </select>
        <input type="submit" class="btn btn-primary" value="搜索"/>
        <a class="btn btn-danger" href="<?php echo url('AdminDelivery/index'); ?>">清空</a>
    </form>

        <table class="table table-hover table-bordered table-list">
            <thead>
            <tr>
                <th width="200">订单编号</th>
                <th width="200">收货人</th>
                <th width="100">发货状态/物流</th>
                <th width="50">物流费用</th>
                <th width="50">订单总价</th>
                <th width="130">下单时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <?php if(is_array($delivery) || $delivery instanceof \think\Collection || $delivery instanceof \think\Paginator): if( count($delivery)==0 ) : echo "" ;else: foreach($delivery as $key=>$vo): ?>
                <tr>
                    <td><?php echo $vo['order_sn']; ?></td>
                    <td>
                        <i class="fa fa-user"></i>:<?php echo $vo['delivery_order']['snap_address']['name']; ?><br/>
                        <i class="fa fa-mobile"></i>:<?php echo $vo['delivery_order']['snap_address']['mobile']; ?><br/>
                    </td>
                    <td>
                        <?php echo $vo['shipping_name']; ?>
                    </td>
                    <td>
                        <?php echo $vo['shipping_price']; ?>
                    </td>
                    <td>
                        <?php echo $vo['delivery_order']['total_price']; ?>
                    </td>
                    <td>
                        <?php echo date("Y-m-d H:i:s",$vo['create_time']); ?>
                    </td>
                    <td>
                        <a href="javascript:parent.openIframeLayer('<?php echo url("AdminDelivery/send",array("id"=>$vo["order_id"])); ?>','发货详情')" >
                        <?php if(empty($vo['shipping_code']) || (($vo['shipping_code'] instanceof \think\Collection || $vo['shipping_code'] instanceof \think\Paginator ) && $vo['shipping_code']->isEmpty())): ?>
                            发货
                            <?php else: ?>
                            详情
                        <?php endif; ?></a>
                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <tfoot>
            <tr>
                <th width="200">订单编号</th>
                <th width="200">收货人</th>
                <th width="100">所选物流</th>
                <th width="50">物流费用</th>
                <th width="50">订单总价</th>
                <th width="130">下单时间</th>
                <th width="100">操作</th>
            </tr>
            </tfoot>
        </table>

        <ul class="pagination"><?php echo ($delivery->render() ?: ''); ?></ul>
</div>
<script src="/static/js/admin.js"></script>
<script>

    function reloadPage(win) {
        win.location.reload();
    }


</script>
</body>
</html>