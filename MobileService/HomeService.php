<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class HomeService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getVideo($data) {
		$max_count = 500;
		// sleep(1*10);
		$c = 0;
		$op = '';
		if (isset ( $data ) && $data !== null) {
			$c = $data->__c__;
			$op = $data->__op__;
		}
		$si = 0;
		if ($op === 'latest') {
			$si = $c + 1;
			$ei = $si + 20;
		} else {
			$si = $c + 1;
			$ei = $si + 20;
		}
		
		$result = new StdClass ();
		$videos = array ();
		for($i = $si; $i < $ei; $i ++) {
			$item = array ();
			$item ['idvideo'] = ($i) . '0';
			$item ['idtype'] = ($i) . '0';
			$item ['score'] = 10 * ($i);
			$item ['title'] = $op . '[' . $c . ']张林老师火爆视频' . $i;
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
		if ($op === 'latest') {
			$top = new StdClass ();
			$top->idvideo = '12345';
			$top->idtype = '12345';
			$top->score = 10;
			$top->title = '张林老师火爆视频';
			$top->idteacher = '100';
			$top->teacher = '张老师';
			$top->taptitudes = '特牛B的老师，获得多项国际大奖.';
			$top->timg = '1.jpg';
			$top->desc = '张老师大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频....';
			$top->paycount = 10000;
			$top->paytime = '00:50:00';
			$top->img = '1.jpg';
			$top->video = '1.mp4';
			$top->createtime = date ( "Y-m-d H:i:s" );
			$top->updatetime = date ( "Y-m-d H:i:s" );
			$result->top = $top;
		} else {
			$result->top = null;
		}
		$result->__status = 1;
		$result->__stateInfo = '检索到51条数据';
		$result->__result = 1;
		return $result;
	}
}
$bll = new HomeService ();
$bll->on_do ();
?>