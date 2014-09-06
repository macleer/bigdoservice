<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class BoxService extends BaseService {
	public function on_get() {
	}
	public function on_post($data = null) {
	}
	public function getVideo($data) {
		$dc = 0;
		$result = new StdClass ();
		$videos = array ();
		$type_result = null;
		if (isset ( $data ) && $data !== null) {
			$op = $data->__op__;
			$idtype = $data->idtype;
			$_idvideo = $data->_idvideo;
			$idvideo_ = $data->idvideo_;
			if (! isset ( $idtype ) || $idtype === null || $idtype === '' || $idtype <= 0) {
				$type_result = $this->getType ( $data );
				if (isset ( $type_result ) && $type_result !== null && isset ( $type_result->item ) && $type_result->item !== null) {
					
					$idtype = $type_result->item [0] ['idtype'];
				}
			}
			if (isset ( $idtype ) && $idtype !== null && $idtype !== '' && $idtype > 0) {
				$sql = 'SELECT v.CS_ID,v.CS_CID,v.CS_Cion,v.CS_Name,v.CS_Content,v.CS_Hits,v.CS_Daoy,v.CS_Pic,v.CS_PlayUrl,';
				$sql .= 'v.CS_AddTime,v.CS_PlayTime,v.CS_Yany,t.CS_ID as T_CS_ID,t.CS_Content as T_CS_Content,t.CS_Pic as T_CS_Pic,';
				$sql .= 'vc.CS_FID as VC_CS_FID FROM dzw_vod as v join dzw_singer as t on v.cs_yany = t.cs_name join dzw_vlist as  vc on v.CS_CID = vc.CS_ID ';
				if ($op === 'refresh') {
					$sql .= ' where   v.CS_ID >' . $_idvideo . ' and (v.CS_FID = ' . $idtype . ' or v.CS_CID = ' . $idtype . ' ) order by v.CS_ID asc limit 0,20 ';
				} else {
					$sql .= ' where v.CS_ID <' . $idvideo_ . ' and (v.CS_FID =' . $idtype . ' or v.CS_CID = ' . $idtype . ')  order by v.CS_ID desc limit 0,20 ';
				}
				 
				$sql_result = $this->_sql_select ( $sql );
				if ($sql_result) {
					while ( $row = mysql_fetch_array ( $sql_result ) ) {
						$item = array ();
						$item ['idvideo'] = $row ['CS_ID'] - 0;
						$item ['idtype'] = $row ['CS_CID'] - 0;
						$item ['idptype'] = $row ['VC_CS_FID'] - 0;
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
		$result->titem = $type_result;
		$result->__status = 1;
		$result->__stateInfo = '检索到' . $dc . '条数据';
		$result->__result = 1;
		$this->_sql_close ();
		return $result;
	}
	public function getType($data) {
		$dc = 0;
		$result = new StdClass ();
		$types = array ();
		if (isset ( $data ) && $data !== null) {
			//$op = $data->__op__;
			//$_idtype = $data->_idtype;
			//$idtype_ = $data->idtype_;
			$sql = 'SELECT CS_ID,CS_Name,CS_FID FROM dzw_vlist order by CS_FID asc,CS_ID asc ';
			//if ($op === 'refresh') {
			//	$sql .= ' where CS_ID >' . $_idtype . '  order by CS_FID asc,CS_ID asc limit 0,50 ';
			//} else {
			//	$sql .= ' where CS_ID <' . $idtype_ . '  order by CS_FID desc,CS_ID asc limit 0,50 ';
			//}
			$sql_result = $this->_sql_select ( $sql );
			if ($sql_result) {
				while ( $row = mysql_fetch_array ( $sql_result ) ) {
					$item = array ();
					$item ['idtype'] = $row ['CS_ID'] - 0;
					$item ['typename'] = $row ['CS_Name'];
					$item ['idptype'] = $row ['CS_FID'] - 0;
					array_push ( $types, $item );
					$dc ++;
				}
			}
		}
		$result->item = $types;
		$result->__status = 1;
		$result->__stateInfo = '检索到' . $dc . '条数据';
		$result->__result = 1;
		// $this->_sql_close ();
		return $result;
	}
}

$bll = new BoxService ();
$bll->on_do ();
?>