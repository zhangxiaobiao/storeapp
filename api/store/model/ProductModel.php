<?php
/**
 * Created by PhpStorm.
 * User: zhangshibiao
 * Date: 2017/12/10
 * Time: 下午1:01
 */

namespace api\store\model;


use think\Model;

class ProductModel extends Model
{
    public function productSpec()
    {
        return $this->belongsTo('SpecModel', 'product_type', 'type_id');
    }

    public function getThumbAttr($value)
    {
        if (!empty($value)){
            $data = json_decode($value, true);
            if (is_array($data)){
                foreach ($data['photos'] as $k=>&$v){
                    $v['image'] = cmf_get_asset_url($v['url']);
                    unset($data['photos'][$k]['url']);
                }
                return $data['photos'];
            }
        }
        return $value;

    }

    public function getDetailsAttr($value)
    {
        return cmf_get_content_images(cmf_replace_content_file_url(htmlspecialchars_decode($value)));
    }

    public function getPriceAttr($value)
    {
        return number_format($value/100, 2, '.', '')+0;
    }

    public function getOrgpriceAttr($value)
    {
        return number_format($value/100, 2,'.', '')+0;
    }

    public function getInitpriceAttr($value)
    {
        return number_format($value/100, 2,'.', '')+0;
    }

    public function getShippingPriceAttr($value)
    {
        return number_format($value/100, 2,'.', '')+0;
    }
}