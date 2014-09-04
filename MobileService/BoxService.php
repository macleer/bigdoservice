<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class HomeService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getVideo($param = null) {
		$op = '';
		if (array_key_exists ( '__op__', $_GET )) {
			$op = $_GET ['__op__'];
		}
		$result = new StdClass ();
		$videos = array ();
		for($i = 1; $i <= 50; $i ++) {
			$item = array ();
			$item ['idvideo'] = ($i) . '0';
			$item ['idtype'] = ($i) . '0';
			$item ['score'] = 10 * ($i);
			$item ['title'] = '张林老师火爆视频' . $i;
			$item ['idteacher'] = '100';
			$item ['teacher'] = '张老师' . $i;
			$item ['taptitudes'] = '特牛B的老师，获得多项国际大奖.';
			$item ['timg'] = '1.jpg';
			$item ['desc'] = '张老师' . $i . '大师级的视频,大师级的视频,大师级的视频,大师级的视频,,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频....';
			$item ['paycount'] = $i;
			$item ['paytime'] = '00:' . $i . '0:00';
			$item ['img'] = '1.jpg';
			$item ['video'] = '1.mp4';
			$item ['createtime'] = date ( "Y-m-d H:i:s" );
			$item ['updatetime'] = date ( "Y-m-d H:i:s" );
			array_push ( $videos, $item );
		}
		$result->item = $videos;
		
		$result->__status = 1;
		$result->__stateInfo = '检索到51条数据';
		$result->__result = 1;
		$result->__clear = 1;
		return $result;
	}
}
?>