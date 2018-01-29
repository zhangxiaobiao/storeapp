<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:55:"themes/admin_simpleboot3/store/admin_product/index.html";i:1516417802;s:88:"/Users/zhangshibiao/code/php/storeapp/public/themes/admin_simpleboot3/public/header.html";i:1511398688;}*/ ?>
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
        <li class="active"><a href="javascript:;">所有产品</a></li>
        <li><a href="<?php echo url('AdminProduct/add'); ?>">添加产品</a></li>
    </ul>
    <form class="well form-inline margin-top-20" method="post" action="<?php echo url('AdminProduct/index'); ?>">
        分类:
        <select class="form-control" name="category" style="width: 140px;">
            <option value='0'>全部</option>
            <?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option <?php if($vo['id'] == $cur_category): ?>selected=selected<?php endif; ?> value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select> &nbsp;&nbsp;
         <!--&nbsp;-->
        <!--关键字:-->
        <!--<input type="text" class="form-control" name="keyword" style="width: 200px;"-->
               <!--value="<?php echo (isset($keyword) && ($keyword !== '')?$keyword:''); ?>" placeholder="请输入关键字...">-->
        <input type="submit" class="btn btn-primary" value="搜索"/>
        <!--<a class="btn btn-danger" href="<?php echo url('AdminArticle/index'); ?>">清空</a>-->
    </form>
    <form class="js-ajax-form" action="" method="post">
        <div class="table-actions">
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/listOrder'); ?>"><?php echo lang('SORT'); ?>
            </button>
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/publish',array('yes'=>1)); ?>" data-subcheck="true">上架
            </button>
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/publish',array('no'=>1)); ?>" data-subcheck="true">下架
            </button>
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/recommend',array('yes'=>1)); ?>" data-subcheck="true">推荐
            </button>
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/recommend',array('no'=>1)); ?>" data-subcheck="true">取消推荐
            </button>

            <button class="btn btn-danger btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/delete'); ?>" data-subcheck="true" data-msg="您确定删除吗？">
                <?php echo lang('DELETE'); ?>
            </button>
        </div>
        <table class="table table-hover table-bordered table-list">
            <thead>
            <tr>
                <th width="15">
                    <label>
                        <input type="checkbox" class="js-check-all" data-direction="x" data-checklist="js-check-x">
                    </label>
                </th>
                <th width="50"><?php echo lang('SORT'); ?></th>
                <th width="50">ID</th>
                <th>标题</th>
                <!--<th>分类</th>-->
                <th width="160">缩略图</th>
                <th width="130">上架时间</th>
                <th width="70">状态</th>
                <th width="90">操作</th>
            </tr>
            </thead>
            <?php if(is_array($products) || $products instanceof \think\Collection || $products instanceof \think\Paginator): if( count($products)==0 ) : echo "" ;else: foreach($products as $key=>$vo): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="js-check" data-yid="js-check-y" data-xid="js-check-x" name="ids[]"
                               value="<?php echo $vo['id']; ?>" title="ID:<?php echo $vo['id']; ?>">
                    </td>
                        <td>
                            <input name="list_orders[<?php echo $vo['id']; ?>]" class="input-order" type="text"
                                   value="<?php echo $vo['list_order']; ?>">
                        </td>
                    <td><b><?php echo $vo['id']; ?></b></td>
                    <td>
                        <?php echo $vo['title']; ?>
                    </td>

                    <td>
                        <?php if(!(empty($vo['thumb']['photos']) || (($vo['thumb']['photos'] instanceof \think\Collection || $vo['thumb']['photos'] instanceof \think\Paginator ) && $vo['thumb']['photos']->isEmpty()))): if(is_array($vo['thumb']['photos']) || $vo['thumb']['photos'] instanceof \think\Collection || $vo['thumb']['photos'] instanceof \think\Paginator): if( count($vo['thumb']['photos'])==0 ) : echo "" ;else: foreach($vo['thumb']['photos'] as $key=>$v): ?>
                            <a href="javascript:parent.imagePreviewDialog('<?php echo cmf_get_image_preview_url($v['url']); ?>');">
                                <i class="fa fa-photo fa-fw"></i>
                            </a>
                            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </td>
                    <td>
                        <?php if(empty($vo['published_time']) || (($vo['published_time'] instanceof \think\Collection || $vo['published_time'] instanceof \think\Paginator ) && $vo['published_time']->isEmpty())): ?>
                            未上架
                            <?php else: ?>
                            <?php echo date('Y-m-d H:i',$vo['published_time']); endif; ?>

                    </td>
                    <td>
                        <?php if(!(empty($vo['publish']) || (($vo['publish'] instanceof \think\Collection || $vo['publish'] instanceof \think\Paginator ) && $vo['publish']->isEmpty()))): ?>
                            <a data-toggle="tooltip" title="已上架"><i class="fa fa-check"></i></a>
                            <?php else: ?>
                            <a data-toggle="tooltip" title="未上架"><i class="fa fa-close"></i></a>
                        <?php endif; if(!(empty($vo['recommended']) || (($vo['recommended'] instanceof \think\Collection || $vo['recommended'] instanceof \think\Paginator ) && $vo['recommended']->isEmpty()))): ?>
                            <a data-toggle="tooltip" title="已推荐"><i class="fa fa-thumbs-up"></i></a>
                            <?php else: ?>
                            <a data-toggle="tooltip" title="未推荐"><i class="fa fa-thumbs-down"></i></a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo url('AdminProduct/edit',array('id'=>$vo['id'])); ?>"><?php echo lang('EDIT'); ?></a>
                        <a href="<?php echo url('AdminProduct/delete',array('id'=>$vo['id'])); ?>" class="js-ajax-delete"><?php echo lang('DELETE'); ?></a>
                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <tfoot>
            <tr>
                <th width="15"><label><input type="checkbox" class="js-check-all" data-direction="x"
                                             data-checklist="js-check-x"></label></th>

                <th width="50"><?php echo lang('SORT'); ?></th>
                <th width="50">ID</th>
                <th>标题</th>
                <!--<th>分类</th>-->
                <th width="160">缩略图</th>
                <th width="130">上架时间</th>
                <th width="70">状态</th>
                <th width="90">操作</th>
            </tr>
            </tfoot>
        </table>
        <div class="table-actions">
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/listOrder'); ?>"><?php echo lang('SORT'); ?>
            </button>
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/publish',array('yes'=>1)); ?>" data-subcheck="true">上架
            </button>
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/publish',array('no'=>1)); ?>" data-subcheck="true">下架
            </button>
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/recommend',array('yes'=>1)); ?>" data-subcheck="true">推荐
            </button>
            <button class="btn btn-primary btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/recommend',array('no'=>1)); ?>" data-subcheck="true">取消推荐
            </button>

            <button class="btn btn-danger btn-sm js-ajax-submit" type="submit"
                    data-action="<?php echo url('AdminProduct/delete'); ?>" data-subcheck="true" data-msg="您确定删除吗？">
                <?php echo lang('DELETE'); ?>
            </button>
        </div>
        <ul class="pagination"><?php echo ($products->render() ?: ''); ?></ul>
    </form>
</div>
<script src="/static/js/admin.js"></script>
<script>

    function reloadPage(win) {
        win.location.reload();
    }


</script>
</body>
</html>