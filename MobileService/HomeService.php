<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class HomeService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getVideo() {    
		//sleep(1*10);
		$result = new StdClass ();
		$videos = array ();
		for($i = 0; $i < 10; $i ++) {
			$item = array ();
			$item ['idvideo'] = ($i + 1) . '0';
			$item ['idtype'] = ($i + 1) . '0';
			$item ['score'] = 10 * ($i + 1);
			$item ['title'] = '张林老师火爆视频' . $i;
			$item ['idteacher'] = '100';
			$item ['teacher'] = '张老师' . $i;
			$item ['desc'] = '张老师' . $i . '大师级的视频,大师级的视频,大师级的视频,大师级的视频,,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频....';
			$item ['paycount'] = $i + 10;
			$item ['paytime'] = '00:'.$i.'0:00';
			$item ['img'] = '1.jpg';
			$item ['url'] = 'Video/Img/1.jpg';
			$item ['createtime'] = date ( "Y-m-d H:i:s" );
			$item ['updatetime'] = date ( "Y-m-d H:i:s" );
			array_push ( $videos, $item );
		}
		$result->top10 = $videos;
		
		$top = new StdClass ();
		$top->idvideo = '12345';
		$top->idtype = '12345';
		$top->score = 10;
		$top->title = '张林老师火爆视频';
		$top->idteacher = '100';
		$top->teacher = '张老师';
		$top->desc = '张老师大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频....';
		$top->paycount = 10000;
		$top->paytime = '00:50:00';
		$top->img = '1.jpg';
		$top->url = 'Video/Img/1.jpg';
		$top->createtime = date ( "Y-m-d H:i:s" );
		$top->updatetime = date ( "Y-m-d H:i:s" );
		$result->top = $top;
		
		$result->__status = 1;
		$result->__stateInfo = '检索到10条数据';
		$result->__result = 1;
		return $result;
	}
	public function getImg($imgObj = null) {
		$result = new StdClass ();
		$result->data = '';
		$result->__status = 0;
		$result->__stateInfo = '检索到0条数据';
		$result->__result = 0;
		if (isset ( $imgObj ) && $imgObj !== null && isset ( $imgObj->img ) && $imgObj->img !== null) {
			$data = file_get_contents ( dirname ( dirname ( __FILE__ ) ) . '/Video/Img/' . $imgObj->img );
			if ($data !== null && $data !== '') {
				$data = base64_encode ( $data );
				if ($data !== null && $data !== '') {
					$result->data = $data;
					$result->__status = 1;
					$result->__stateInfo = '检索到1条数据';
					$result->__result = 1;
				}
			}
		}
		return $result;
	}
}
$bll = new HomeService ();
$bll->on_do ();
?>