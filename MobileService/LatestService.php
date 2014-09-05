<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class LatestService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getVideo($data) {
		$dc = 0;
		$result = new StdClass ();
		$videos = array ();
		if (isset ( $data ) && $data !== null) {
			$op = $data->__op__;
			$_idvideo = $data->_idvideo;
			$idvideo_ = $data->idvideo_;
			$c = $data->__c__;
			
			$sql = 'SELECT v.CS_ID,v.CS_CID,v.CS_Cion,v.CS_Name,v.CS_Content,v.CS_Hits,v.CS_Daoy,v.CS_Pic,v.CS_PlayUrl,';
			$sql .= 'v.CS_AddTime,v.CS_PlayTime,v.CS_Yany,t.CS_ID as T_CS_ID,t.CS_Content as T_CS_Content,t.CS_Pic as T_CS_Pic ';
			$sql .= 'FROM dzw_vod as v join dzw_singer as t on v.cs_yany = t.cs_name ';
			$now = new DateTime ();
			$now = new DateTime ( $now->format ( 'Y-m-d 0:0:0' ) );
			$now->modify ( '-7 day' );
			$now = $now->format ( 'Y-m-d H:i:s' );
			
			$sql_result = $this->_sql_select ( $sql . ' where  v.CS_ID >= \'' . $_idvideo . '\'  order by v.CS_ID desc limit 0,1000' );
			if ($sql_result) {
				while ( $row = mysql_fetch_array ( $sql_result ) ) {
					$t_idvideo = $row ['CS_ID'] - 0;
					if ($t_idvideo == $_idvideo) {
						break;
					}
					$item = array ();
					$item ['idvideo'] = $row ['CS_ID'] - 0;
					$item ['idtype'] = $row ['CS_CID'];
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
					$dc ++;
				}
			}
			if ($c <= 0 && $dc < 50) {
				$_dc = 50 - $dc;
				$sql_result = $this->_sql_select ( $sql . ' where v.CS_ID < \'' . $_idvideo . '\'  order by v.CS_ID desc limit 0,' . $_dc );
				if ($sql_result) {
					while ( $row = mysql_fetch_array ( $sql_result ) ) {
						$item = array ();
						$item ['idvideo'] = $row ['CS_ID'] - 0;
						$item ['idtype'] = $row ['CS_CID'];
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
						$dc ++;
					}
				}
			}
		}
		$result->item = $videos;
		$result->__status = 1;
		$result->__stateInfo = '检索到' . $dc . '条数据';
		$result->__result = 1;
		if ($dc > 0) {
			$result->__clear = 1;
		}
		$this->_sql_close ();
		return $result;
	}
}
$bll = new LatestService ();
$bll->on_do ();
?>