<?php
/**
 * RiPro是一个优秀的主题，首页拖拽布局，高级筛选，自带会员生态系统，超全支付接口，你喜欢的样子我都有！
 * 正版唯一购买地址，全自动授权下载使用：https://www.20su.cn/
 * 该WordPress日主题·由&#x642c;&#x7801;&#x0077;&#x0077;&#x0077;&#x002e;&#x0061;&#x0062;&#x006e;&#x006d;&#x0061;&#x002e;&#x0063;&#x006f;&#x006d;「20su.cn」首发分享 
 * 承蒙您对本主题的喜爱，我们愿向小三一样，做大哥的女人，做大哥网站中最想日的一个。
 * 能理解使用盗版的人，但是不能接受传播盗版，本身主题没几个钱，主题自有支付体系和会员体系，盗版风险太高，鬼知道那些人乱动什么代码，无利不起早。
 * 开发者不易，感谢支持，更好的更用心的等你来调教
 */

/**
 * 微信同步回调
 */

header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();
session_start();
if (!empty($_SESSION['wx_session_order_trade_no'])) {
	// 验证成功 $_GET['trade_no']
	$out_trade_no = $_SESSION['wx_session_order_trade_no'];
	$_post_id = 0;
	// 查询本地订单
	$RiProPay = new RiProPay;
	$postData = $RiProPay->get_order_info($out_trade_no);
	if ($postData && $postData['status'] == 1) {
		$_post_id = $postData['post_id'];
		$RiProPay->AddPayPostCookie($postData['user_id'],$_post_id,$postData['order_trade_no']);
	}
	if ($_post_id>0) {
		wp_safe_redirect( get_the_permalink( $_post_id ) );
	}else{
		wp_safe_redirect(home_url('/user'));
	}
	// END
} else {
    wp_safe_redirect(home_url());
}
