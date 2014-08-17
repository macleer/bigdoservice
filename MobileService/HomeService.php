<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class HomeService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getTop1() {
		$result = new StdClass ();
		$result->title = '张林老师火爆视频';
		$result->teacher = '张老师';
		$result->desc = '张老师大师级的视频....';
		$result->img = 'Video/Img/1.jpg';
		$result->video = 'Video/Img/1.jpg';
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
			$item ['title'] = '张林老师火爆视频' . $i;
			$item ['teacher'] = '张老师' . $i;
			$item ['desc'] = '张老师' . $i . '大师级的视频....';
			$item ['img'] = 'Video/Img/1.jpg';
			$item ['video'] = 'Video/Img/1.jpg';
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