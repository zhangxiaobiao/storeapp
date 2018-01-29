<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:51:"themes/admin_simpleboot3/store/admin_spec/edit.html";i:1516351410;s:88:"/Users/zhangshibiao/code/php/storeapp/public/themes/admin_simpleboot3/public/header.html";i:1511398688;}*/ ?>
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
        <li><a href="<?php echo url('AdminSpec/index'); ?>">规格管理</a></li>
        <li><a href="<?php echo url('AdminSpec/add'); ?>">添加规格</a></li>
        <li class="active"><a href="#">编辑规格</a></li>
    </ul>
    <div class="row margin-top-20">
        <div class="col-md-6">
            <form class="js-ajax-form" action="<?php echo url('AdminSpec/edit'); ?>" method="post">
                <div class="tab-content">

                    <div class="">
                        <div class="form-group">
                            <label for="input-seo_title">规格名称</label>
                            <div>
                                <input type="hidden" name="id" value="<?php echo $spec['id']; ?>">
                                <input type="text" class="form-control" id="input-seo_title" name="name" value="<?php echo $spec['name']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">所属模型</label>
                            <div>
                                <select name="type_id" id="" class="form-control">
                                    <?php if(is_array($types) || $types instanceof \think\Collection || $types instanceof \think\Paginator): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option <?php if($spec['type_id'] == $vo['id']): ?>selected=selected<?php endif; ?> value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>规格项</label>
                            <div>
                                <textarea class="form-control" name="items"  cols="30" rows="5"><?php echo $spec['add_item']; ?></textarea>
                            </div>
                            <p>一行为一个规格项，多个规格项用换行输入</p>
                        </div>
                        <div class="form-group">
                            <label for="input-seo_title2">排序</label>
                            <div>
                                <input type="number" class="form-control" id="input-seo_title2" value="100" name="list_order" value="<?php echo $spec['list_order']; ?>">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('EDIT'); ?></button>
                    <a class="btn btn-default" href="<?php echo url('AdminSpec/index'); ?>"><?php echo lang('BACK'); ?></a>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/js/admin.js"></script>
</body>
</html>