<?php

use think\Route;





//获取用户地址
Route::rule('store/address','store/address/getUserAddress');

//获取个人信息
Route::rule('store/userinfo','store/user/getUserInfo');
//商城banner
///home/slides/2


//商城


//获取所有服务费商品
Route::rule('store/allproduct', 'store/product/getAllProducts');
//获取一个商品的详情
Route::rule('store/product/:id', 'store/product/getOneProduct');

//token
Route::rule('store/verifytoken', 'store/token/verifyActoken');


//提交订单
Route::post('store/order', 'store/productOrder/pleaceOrder');
//获取订单列表
Route::get('order/by_user/[:type]', 'store/productOrder/getSummarySByUser');
//获取个分类订单数量
Route::get('order/order_num', 'store/productOrder/statusNum');
//获取订单详情
Route::get('store/order/:id', 'store/productOrder/getDetail',[],['id'=>'\d+']);
//获取预订单
Route::post('store/pre_order', 'store/pay/getPreOrder');
//微信回调的api地址
Route::post('store/notify', 'store/payReceive/receiveNotify');