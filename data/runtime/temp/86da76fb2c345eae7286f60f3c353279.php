<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"themes/admin_simpleboot3/store/admin_product/edit.html";i:1516429067;s:88:"/Users/zhangshibiao/code/php/storeapp/public/themes/admin_simpleboot3/public/header.html";i:1511398688;}*/ ?>
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
<script type="text/html" id="photos-item-tpl">
    <li id="saved-image{id}">
        <input id="photo-{id}" type="hidden" name="photo_urls[]" value="{filepath}">
        <input class="form-control" id="photo-{id}-name" type="text" name="photo_names[]" value="{name}"
               style="width: 200px;" title="图片名称">
        <img id="photo-{id}-preview" src="{url}" style="height:36px;width: 36px;"
             onclick="imagePreviewDialog(this.src);">
        <a href="javascript:uploadOneImage('图片上传','#photo-{id}');">替换</a>
        <a href="javascript:(function(){$('#saved-image{id}').remove();})();">移除</a>
    </li>
</script>
<script type="text/html" id="files-item-tpl">
    <li id="saved-file{id}">
        <input id="file-{id}" type="hidden" name="file_urls[]" value="{filepath}">
        <input class="form-control" id="file-{id}-name" type="text" name="file_names[]" value="{name}"
               style="width: 200px;" title="文件名称">
        <a id="file-{id}-preview" href="{preview_url}" target="_blank">下载</a>
        <a href="javascript:uploadOne('图片上传','#file-{id}','file');">替换</a>
        <a href="javascript:(function(){$('#saved-file{id}').remove();})();">移除</a>
    </li>
</script>
</head>
<body>
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">通用信息</a></li>
        <li><a href="#B" data-toggle="tab">商品模型</a></li>
        <!--<li><a href="#C" data-toggle="tab"><?php echo lang('URL_SETTING'); ?></a></li>-->
        <!--<li><a href="#E" data-toggle="tab"><?php echo lang('COMMENT_SETTING'); ?></a></li>-->
        <li><a href="#F" data-toggle="tab">商品物流</a></li>
    </ul>
    <form action="<?php echo url('AdminProduct/edit'); ?>" method="post" class="form-horizontal js-ajax-form margin-top-20">
        <fieldset>
            <div class="tabbable">
                <div class="tab-content">
                    <div class="tab-pane active" id="A">
        <div class="row">
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr>
                        <th width="120">分类<span class="form-required">*</span></th>
                        <td>
                            <select class="form-control" name="category" >
                                <?php if(is_array($categories) || $categories instanceof \think\Collection || $categories instanceof \think\Paginator): if( count($categories)==0 ) : echo "" ;else: foreach($categories as $key=>$vo): ?>
                                    <option value="<?php echo $vo['id']; ?>" <?php if($product['product_type'] == $vo['name']): ?>selected<?php endif; ?> ><?php echo $vo['name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th width="120">标题<span class="form-required">*</span></th>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input class="form-control" type="text" name="title"
                                   id="title" required value="<?php echo $product['title']; ?>" placeholder="请输入标题"/>
                        </td>
                    </tr>
                    <tr>
                        <th>副标题</th>
                        <td>
                            <input class="form-control" type="text" name="subtitle" id="subtitle" value="<?php echo $product['subtitle']; ?>"
                                   placeholder="请输入副标题">
                        </td>
                    </tr>
                    <tr>
                        <th>现价</th>
                        <td><input class="form-control" type="number" name="price" id="source" value="<?php echo $product['price']; ?>"
                                   placeholder="请输入现价">   <p class="help-block">单位（分）</p></td>


                    </tr>
                    <tr>
                        <th>原价</th>
                        <td><input class="form-control" type="number" name="orgprice"  value="<?php echo $product['orgprice']; ?>"
                                   placeholder="请输入原价"><p class="help-block">单位（分）</p></td>


                    </tr>
                    <tr>
                        <th>成本价</th>
                        <td><input class="form-control" type="number" name="initprice" id="" value="<?php echo $product['initprice']; ?>"
                                   placeholder="请输入起步价"><p class="help-block">单位（分）</p></td>


                    </tr>
                    <tr>
                        <th>库存量</th>
                        <td>
                            <input class="form-control" type="number" name="store_count"  value="<?php echo $product['store_count']; ?>"
                                   placeholder="请输入库存量">
                        </td>
                    </tr>
                    <tr>
                        <th>商品轮播图</th>
                        <td>
                            <ul id="photos" class="pic-list list-unstyled form-inline">
                                <?php if(!(empty($product['thumb']['photos']) || (($product['thumb']['photos'] instanceof \think\Collection || $product['thumb']['photos'] instanceof \think\Paginator ) && $product['thumb']['photos']->isEmpty()))): if(is_array($product['thumb']['photos']) || $product['thumb']['photos'] instanceof \think\Collection || $product['thumb']['photos'] instanceof \think\Paginator): if( count($product['thumb']['photos'])==0 ) : echo "" ;else: foreach($product['thumb']['photos'] as $key=>$vo): $img_url=cmf_get_image_preview_url($vo['url']); ?>
                                        <li id="saved-image<?php echo $key; ?>">
                                            <input id="photo-<?php echo $key; ?>" type="hidden" name="photo_urls[]"
                                                   value="<?php echo $vo['url']; ?>">
                                            <input class="form-control" id="photo-<?php echo $key; ?>-name" type="text"
                                                   name="photo_names[]"
                                                   value="<?php echo (isset($vo['name']) && ($vo['name'] !== '')?$vo['name']:''); ?>" style="width: 200px;" title="图片名称">
                                            <img id="photo-<?php echo $key; ?>-preview"
                                                 src="<?php echo cmf_get_image_preview_url($vo['url']); ?>"
                                                 style="height:36px;width: 36px;"
                                                 onclick="parent.imagePreviewDialog(this.src);">
                                            <a href="javascript:uploadOneImage('图片上传','#photo-<?php echo $key; ?>');">替换</a>
                                            <a href="javascript:(function(){$('#saved-image<?php echo $key; ?>').remove();})();">移除</a>
                                        </li>
                                    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </ul>
                            <a href="javascript:uploadMultiImage('图片上传','#photos','photos-item-tpl');"
                               class="btn btn-sm btn-default">选择图片</a>
                        </td>
                    </tr>
                    <tr>
                        <th>商品详情<br/>(宽750px)</th>
                        <td>
                            <script type="text/plain" id="content" name="details"><?php echo $product['details']; ?></script>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="col-md-3">
                <table class="table table-bordered">

                    <?php 
                        $publish_yes=$product['publish']==1?"checked":"";

                        $recommended_yes=$product['recommended']==1?"checked":"";
                     ?>
                    <tr>
                        <th><b>上架时间</b></th>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control js-bootstrap-datetime" type="text" name="published_time"
                                   value="<?php echo date('Y-m-d H:i:s',$product['published_time']); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><b>状态</b></th>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" name="publish" value="1" <?php echo $publish_yes; ?>>上架</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" name="recommended" value="1" <?php echo $recommended_yes; ?>>推荐</label>
                            </div>
                        </td>
                    </tr>


                </table>
            </div>
        </div>


                    </div>
                    <div class="tab-pane" id="B">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="120">所属模型<span class="form-required">*</span></th>
                                            <td>
                                                <select class="form-control" name="product_type">
                                                    <?php if(is_array($types) || $types instanceof \think\Collection || $types instanceof \think\Paginator): if( count($types)==0 ) : echo "" ;else: foreach($types as $key=>$vo): ?>
                                                        <option <?php if($product['product_type'] == $vo['id']): ?>selected=selected<?php endif; ?> value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>

                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="F">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="120">运费<span class="form-required">*</span></th>
                                            <td>
                                                <input class="form-control" type="text" name="shipping_price" value="<?php echo $product['shipping_price']; ?>">
                                                <p>'0'代表包邮（单位：分）</p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('EDIT'); ?></button>
                            <a class="btn btn-default" href="<?php echo url('AdminProduct/index'); ?>"><?php echo lang('BACK'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="/static/js/admin.js"></script>
<script type="text/javascript">
    //编辑器路径定义
    var editorURL = GV.WEB_ROOT;
</script>
<script type="text/javascript" src="/static/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/static/js/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">
    $(function () {

        editorcontent = new baidu.editor.ui.Editor();
        editorcontent.render('content');
        try {
            editorcontent.sync();
        } catch (err) {
        }

        $('.btn-cancel-thumbnail').click(function () {
            $('#thumbnail-preview').attr('src', '/themes/admin_simpleboot3/public/assets/images/default-thumbnail.png');
            $('#thumbnail').val('');
        });

    });


</script>
</body>
</html>
