<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:61:"themes/admin_simpleboot3/store/admin_product_order/index.html";i:1516601531;s:88:"/Users/zhangshibiao/code/php/storeapp/public/themes/admin_simpleboot3/public/header.html";i:1511398688;}*/ ?>
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
        <li class="active"><a href="javascript:;">所有订单</a></li>
    </ul>
    <form class="well form-inline margin-top-20" method="post" action="<?php echo url('AdminProductOrder/index'); ?>">
        订单号:
        <input type="text" class="form-control" name="keyword" style="width: 200px;"
               value="<?php echo (isset($keyword) && ($keyword !== '')?$keyword:''); ?>" placeholder="请输入订单号...">
        订单状态:
        <select class="form-control" name="status" style="width: 140px;">
            <option value='999'>全部</option>
            <?php if(is_array($status) || $status instanceof \think\Collection || $status instanceof \think\Paginator): $i = 0; $__LIST__ = $status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option <?php if($current_status == $key): ?>selected=selected<?php endif; ?> value="<?php echo $key; ?>"><?php echo $vo; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <input type="submit" class="btn btn-primary" value="搜索"/>
        <a class="btn btn-danger" href="<?php echo url('AdminProductOrder/index'); ?>">清空</a>
    </form>

        <table class="table table-hover table-bordered table-list">
            <thead>
            <tr>
                <th width="200">订单编号</th>
                <th width="200">下单人</th>
                <th width="200">标题</th>
                <th width="100">总金额</th>
                <th width="50">订单状态</th>
                <th width="130">下单时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <?php if(is_array($orders) || $orders instanceof \think\Collection || $orders instanceof \think\Paginator): if( count($orders)==0 ) : echo "" ;else: foreach($orders as $key=>$vo): ?>
                <tr>
                    <td><?php echo $vo['product_order_no']; ?></td>
                    <td>
                        <i class="fa fa-user"></i>:<?php echo $vo['user_id']['user_nickname']; ?><br/>
                        <i class="fa fa-mobile"></i>:<?php echo $vo['user_id']['mobile']; ?>
                    </td>
                    <td>
                        <?php echo $vo['snap_name']; ?>
                    </td>
                    <td>
                        <?php echo $vo['total_price']; ?>
                    </td>
                    <td>
                        <?php echo $vo['status']['status_info']; ?>
                    </td>
                    <td>
                        <?php echo date("Y-m-d H:i:s",$vo['create_time']); ?>
                    </td>
                    <td>
                        <a href="javascript:parent.openIframeLayer('<?php echo url("AdminProductOrder/detail",array("id"=>$vo["id"])); ?>','订单详情')">查看</a>
                       |
                        <?php if($vo['done_time'] == 0): ?>
                            <a href="<?php echo url('AdminProductOrder/done',array('id'=>$vo['id'])); ?>" class="js-ajax-dialog-btn">完成</a>
                            <?php else: ?>
                            已读
                        <?php endif; ?>
                        |
                        <a href="<?php echo url('AdminProductOrder/delete',array('id'=>$vo['id'])); ?>" class="js-ajax-delete"><?php echo lang('DELETE'); ?></a>
                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <tfoot>
            <tr>
                <th >订单编号</th>
                <th>下单人</th>
                <th>标题</th>
                <th>总金额</th>
                <th>订单状态</th>
                <th width="130">下单时间</th>
                <th width="90">操作</th>
            </tr>
            </tfoot>
        </table>

        <ul class="pagination"><?php echo ($orders->render() ?: ''); ?></ul>
</div>
<script src="/static/js/admin.js"></script>
<script>

    function reloadPage(win) {
        win.location.reload();
    }


</script>
</body>
</html>