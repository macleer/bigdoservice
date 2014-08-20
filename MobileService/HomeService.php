<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class HomeService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getTop1() {
		$result = new StdClass ();
		$result->idvideo = '12345';
		$result->score = 10;
		$result->title = '张林老师火爆视频';
		$result->idteacher = '100';
		$result->teacher = '张老师';
		$result->desc = '张老师大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频....';
		$result->paycount = 10000;
		$result->img = 'Video/Img/1.jpg';
		$result->url = 'Video/Img/1.jpg';
		$result->createtime = date ( "Y-m-d H:i:s" );
		$result->updatetime = date ( "Y-m-d H:i:s" );
		$result->__status = 1;
		$result->__stateInfo = '检索到1条数据';
		$result->__result = 1;
		
		return $result;
	}
	public function getTop10() {
		$result = new StdClass ();
		$videos = array ();
		for($i = 0; $i < 10; $i ++) {
			$item = array ();
			$item ['idvideo'] = ($i + 1) . '0';
			$item ['score'] = 10 * ($i + 1);
			$item ['title'] = '张林老师火爆视频' . $i;
			$item ['idteacher'] = '100';
			$item ['teacher'] = '张老师' . $i;
			$item ['desc'] = '张老师' . $i . '------++大师级的视频,大师级的视频,大师级的视频,大师级的视频,,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频....';
			$item ['paycount'] = $i+10;
			$item ['img'] = 'Video/Img/1.jpg';
			$item ['url'] = 'Video/Img/1.jpg';
			$item ['createtime'] = date ( "Y-m-d H:i:s" );
			$item ['updatetime'] = date ( "Y-m-d H:i:s" );
			array_push ( $videos, $item );
		}
		$result->item = $videos;
		$result->__status = 1;
		$result->__stateInfo = '检索到10条数据';
		$result->__result = 1;
		return $result;
	}
}
$bll = new HomeService ();
$bll->on_do ();
?>