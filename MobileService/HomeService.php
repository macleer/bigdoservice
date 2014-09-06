<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class HomeService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getVideo() {
		$dc = 0;
		$result = new StdClass ();
		$videos = array ();
		
		$sql = 'SELECT v.CS_ID,v.CS_CID,v.CS_Cion,v.CS_Name,v.CS_Content,v.CS_Hits,v.CS_Daoy,v.CS_Pic,v.CS_PlayUrl,';
		$sql .= 'v.CS_AddTime,v.CS_PlayTime,v.CS_Yany,t.CS_ID as T_CS_ID,t.CS_Content as T_CS_Content,t.CS_Pic as T_CS_Pic ';
		$sql .= 'FROM dzw_vod as v join dzw_singer as t on v.cs_yany = t.cs_name order by v.cs_hits desc limit 0,50';
		$sql_result = $this->_sql_select ( $sql );
		if ($sql_result) {
			while ( $row = mysql_fetch_array ( $sql_result ) ) {
				$dc ++;
				$item = array ();
				$item ['idvideo'] = $row ['CS_ID'] - 0;
				$item ['idtype'] = $row ['CS_CID'] - 0;
				$item ['idptype'] = 0;
				$item ['score'] = $row ['CS_Cion'] - 0;
				$item ['title'] = $row ['CS_Name'];
				
				$item ['idteacher'] = $row ['T_CS_ID'];
				$item ['teacher'] = $row ['CS_Yany'];
				$item ['taptitudes'] = $row ['T_CS_Content'];
				$item ['timg'] = $row ['T_CS_Pic'];
				
				$item ['desc'] = $row ['CS_Content'];
				$item ['paycount'] = $row ['CS_Hits'] - 0;
				$item ['paytime'] = $row ['CS_Daoy'];
				$item ['img'] = $row ['CS_Pic'];
				$item ['video'] = $row ['CS_PlayUrl'];
				$item ['createtime'] = $row ['CS_AddTime'];
				$item ['updatetime'] = $row ['CS_PlayTime'];
				array_push ( $videos, $item );
			}
		}
		$result->item = $videos;
		/*
		 * $top = new StdClass (); $top->idvideo = '12345'; $top->idtype = '12345'; $top->score = 10; $top->title = '张林老师火爆视频'; $top->idteacher = '100'; $top->teacher = '张老师'; $top->taptitudes = '特牛B的老师，获得多项国际大奖.'; $top->timg = '1.jpg'; $top->desc = '张老师大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频,大师级的视频....'; $top->paycount = 10000; $top->paytime = '00:50:00'; $top->img = '1.jpg'; $top->video = '1.mp4'; $top->createtime = date ( "Y-m-d H:i:s" ); $top->updatetime = date ( "Y-m-d H:i:s" ); $result->top = $top;
		 */
		$result->top = null;
		$result->__status = 1;
		$result->__stateInfo = '检索到' . $dc . '条数据';
		$result->__result = 1;
		$result->__clear = 1;
		$this->_sql_close ();
		return $result;
	}
}
$bll = new HomeService ();
$bll->on_do ();
?>