<?php //提交短信
$post_data = array();
$post_data['userid'] = 107;
$post_data['account'] = 'SDK00112';
$post_data['password'] = '425514';
$post_data['content'] = urlencode('测试php提交'); //短信内容需要用urlencode编码下
$post_data['mobile'] = '13261656810';//13905792605
//$post_data['sendtime'] = ''; //不定时发送，值为0，定时发送，输入格式YYYYMMDDHHmmss的日期值
$url='http://118.244.213.21:8888/sms.aspx?action=send';
$o='';
foreach ($post_data as $k=>$v)
{
   $o.="$k=".urlencode($v).'&';
}
$post_data=substr($o,0,-1);
echo  $post_data;
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
$result = curl_exec($ch);
echo  '===='.$result;
?>