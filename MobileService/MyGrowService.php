<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class MyGrowService extends BaseService {
	public function on_get() {
	}
	public function on_post($data = null) {
	}
	public function grow($data) {
		$dc = 0;
		$result = new StdClass ();
		$grows = array ();
		$type_result = null;
		if (isset ( $data ) && $data !== null) {
			$user = $data->user;
			if (isset ( $user ) && $user !== null && $user !== '' && $user > 0) {
				$sql = 'SELECT CS_ID,CS_Name,CS_Content,CS_AddTime FROM dzw_news  where CS_User =\'' . $this->_sql_param_filter ( $user ) . '\'';
				
				$sql_result = $this->_sql_select ( $sql );
				if ($sql_result) {
					while ( $row = mysql_fetch_array ( $sql_result ) ) {
						$item = array ();
						$item ['idgrow'] = $row ['CS_ID'] - 0;
						$item ['title'] = $row ['CS_Name'];
						$item ['content'] = $row ['CS_Content'];
						$item ['createtime'] = $row ['CS_AddTime'];
						array_push ( $grows, $item );
						$dc ++;
					}
				}
			}
		}
		$result->item = $grows;
		$result->__status = 1;
		$result->__stateInfo = '检索到' . $dc . '条数据';
		$result->__result = 1;
		$this->_sql_close ();
		return $result;
	}
	public function addGrow($data) {
		$dc = 0;
		$result = new StdClass ();
		$result->item = null;
		$result->__status = 0;
		$result->__stateInfo = '';
		$result->__result = 0;
		
		$types = array ();
		if (isset ( $data ) && $data !== null) {
			if (! isset ( $data->title ) || $data->title === null || $data->title === '') {
				$result->__stateInfo = '标题不能为空';
				return $result;
			}
			if (! isset ( $data->content ) || $data->content === null || $data->content === '') {
				$result->__stateInfo = '内容不能为空';
				return $result;
			}
			$now = new DateTime ();
			$now = new DateTime ( $now->format ( 'Y-m-d 0:0:0' ) );
			$now->modify ( '-7 day' );
			$now = $now->format ( 'Y-m-d H:i:s' );
			$sql = 'insert into  dzw_news (CS_ID,CS_Name,CS_Content,CS_AddTime ) values';
			$sql .= ' (null,\'' . $this->_sql_param_filter ( $data->title ) . '\',\'' . $this->_sql_param_filter ( $data->content ) . '\',\'' . $now . '\')';
			$sql_result = $this->_sql_select ( $sql );
			if ($sql_result && mysql_affected_rows () > 0) {
				$isOk = true;
			} else {
				$isOk = false;
			}
		}
		$result->item = $types;
		$result->__status = $isOk ? 1 : 0;
		$result->__stateInfo = $isOk ? '新增成功' : '新增失败';
		$result->__result = $isOk ? 1 : 0;
		$this->_sql_close ();
		return $result;
	}
}

$bll = new MyGrowService ();
$bll->on_do ();
?>