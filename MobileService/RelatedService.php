<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class RelatedService extends BaseService {
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
			// $idrelate = $data->idrelate;
			$idrtype = $data->idrtype;
			$_idvideo = $data->_idvideo;
			$idvideo_ = $data->idvideo_;
			$c = $data->__c__;
			$sql = 'SELECT v.CS_ID,v.CS_CID,v.CS_Cion,v.CS_Name,v.CS_Content,v.CS_Hits,v.CS_Daoy,v.CS_Pic,v.CS_PlayUrl,';
			$sql .= 'v.CS_AddTime,v.CS_PlayTime,v.CS_Yany,t.CS_ID as T_CS_ID,t.CS_Content as T_CS_Content,t.CS_Pic as T_CS_Pic ';
			$sql .= 'FROM dzw_vod as v join dzw_singer as t on v.cs_yany = t.cs_name ';
			
			if ($op === 'refresh') {
				$sql .= ' where   v.CS_ID >' . $_idvideo . ' and v.CS_CID like \'%' . $idrtype . '\' order by v.CS_ID asc limit 0,20 ';
			} else {
				$sql .= ' where v.CS_ID <' . $idvideo_ . ' and v.CS_CID like \'%' . $idrtype . '\'  order by v.CS_ID desc limit 0,20 ';
			}
			$sql_result = $this->_sql_select ( $sql );
			
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
		$result->item = $videos;
		$result->__status = 1;
		$result->__stateInfo = '检索到' . $dc . '条数据';
		$result->__result = 1;
		$this->_sql_close ();
		return $result;
	}
}
$bll = new RelatedService ();
$bll->on_do ();
?>