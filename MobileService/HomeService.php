<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class HomeService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getVideo($data) {
		// sleep(1*10);		 
		$op = '';
		if (array_key_exists ( '__op__', $_GET )) {
			$op = $_GET ['__op__'];
		}		
		$result = new StdClass ();
		$videos = array ();
		$sql = 'SELECT v.CS_ID,v.CS_CID,v.CS_Cion,v.CS_Name,v.CS_Content,v.CS_Hits,v.CS_Daoy,v.CS_Pic,v.CS_PlayUrl,v.CS_AddTime,v.CS_PlayTime,v.CS_Yany,t.CS_ID as T_CS_ID,t.CS_Content as T_CS_Content,t.CS_Pic as T_CS_Pic FROM dzw_vod as v join dzw_singer as t on v.cs_yany = t.cs_name order by v.cs_hits desc limit 0,50 ';
		$sql_result = $this->_sql_select ( 'dzw_vod', $sql );
		if ($sql_result) {
			while ( $row = mysql_fetch_array ( $sql_result ) ) {
				$item = array ();
				$item ['idvideo'] = $row ['CS_ID'];
				$item ['idtype'] = $row ['CS_CID'];
				$item ['score'] = $row ['CS_Cion'];
				$item ['title'] = $row ['CS_Name'];
				
				$item ['idteacher'] = $row ['T_CS_ID'];
				$item ['teacher'] = $row ['CS_Yany'];
				$item ['taptitudes'] = $row ['T_CS_Content'];
				$item ['timg'] = $row ['T_CS_Pic'];
				
				$item ['desc'] = $row ['CS_Content'];
				$item ['paycount'] = $row ['CS_Hits'];
				$item ['paytime'] = $row ['CS_Daoy'];
				$item ['img'] = $row ['CS_Pic'];
				$item ['video'] = $row ['CS_PlayUrl'];
				$item ['createtime'] = $row ['CS_AddTime'];
				$item ['updatetime'] = $row ['CS_PlayTimedate'];
				array_push ( $videos, $item );
			}
		}
		
		$result->item = $videos;
		if ($op === 'refresh') {
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
		$result->__clear = 1;
		return $result;
	}
}
$bll = new HomeService ();
$bll->on_do ();
?>