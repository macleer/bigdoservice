<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class UserService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	/**
	 * 登录
	 *
	 * @param unknown $data        	
	 * @return StdClass
	 */
	public function lonin($data) {
		$dc = 0;
		$result = new StdClass ();
		$result->__result = 0;
		$result->user = null;
		if (isset ( $data ) && $data !== null && isset ( $data->user ) && $data->user !== null && $data->user !== '' && isset ( $data->pwd ) && $data->pwd !== null && $data->pwd !== '') {
			$sql = 'SELECT CS_ID FROM dzw_user where ';
			$data->pwd = md5 ( $data->pwd );
			$sql .= ' CS_Name = \'' . $this->_sql_param_filter ( $data->user ) . '\' and CS_Pass = \'' . $this->_sql_param_filter ( $data->pwd ) . '\' limit 0,1';
			$sql_result = $this->_sql_select ( $sql );
			if ($sql_result) {
				while ( $row = mysql_fetch_array ( $sql_result ) ) {
					$CS_ID = $row ['CS_ID'] - 0;
					if ($CS_ID > 0) {
						$user_data = new StdClass ();
						$user_data->iduser = $CS_ID;
						$user_result = $this->userInfo ( $user_data );
						if (isset ( $user_result ) && $user_result !== null && isset ( $user_result->user ) && $user_result->user !== null && $user_result->__status === 1 && $user_result->__result === 1) {
							$result->user = $user_result->user;
							$result->__result = 1;
							$dc ++;
						}
					}
				}
			}
		}
		$result->__status = 1;
		$result->__stateInfo = '检索到' . $dc . '条数据';
		// $this->_sql_close ();
		return $result;
	}
	/**
	 * 用户信息-基本
	 *
	 * @param unknown $data        	
	 * @return StdClass
	 */
	public function userInfo($data) {
		$dc = 0;
		$result = new StdClass ();
		$result->user = new StdClass ();
		if (isset ( $data ) && $data !== null && isset ( $data->iduser ) && $data->iduser !== null && $data->iduser !== '' && $data->iduser > 0) {
			$sql = 'SELECT CS_ID,CS_Name,CS_Nichen,CS_Sex,CS_Sr,CS_Email,CS_Gsmc,CS_Tdrs,CS_Level,CS_cion,CS_VipTime,CS_EndTime';
			$sql .= ' FROM dzw_user where CS_ID = ' . $data->iduser . ' limit 0,1';
			
			$sql_result = $this->_sql_select ( $sql );
			if ($sql_result) {
				while ( $row = mysql_fetch_array ( $sql_result ) ) {
					
					$result->user->iduser = $row ['CS_ID'] - 0;
					$result->user->user = $row ['CS_Name'];
					$result->user->alias = $row ['CS_Nichen'];
					$result->user->sex = $row ['CS_Sex'] - 0;
					
					$result->user->birthday = $row ['CS_Sr'];
					
					$result->user->email = $row ['CS_Email'];
					$result->user->company = $row ['CS_Gsmc'];
					$result->user->teamcount = $row ['CS_Tdrs'];
					
					$result->user->level = $row ['CS_Level'] - 0;
					$result->user->score = $row ['CS_cion'] - 0;
					
					$result->user->vip_stime = $row ['CS_VipTime'];
					$result->user->vip_entime = $row ['CS_EndTime'];
					$dc ++;
				}
			}
		}
		$result->__status = 1;
		$result->__stateInfo = '检索到' . $dc . '条数据';
		if ($dc > 0) {
			$result->__result = 1;
		} else {
			$result->__result = 0;
		}
		// $this->_sql_close ();
		return $result;
	}
	/**
	 * 修改用户基本信息
	 *
	 * @param unknown $data        	
	 * @return StdClass
	 */
	public function upadateInfo($data) {
		$result = new StdClass ();
		$isOk = false;
		if (isset ( $data ) && $data !== null && isset ( $data->iduser ) && $data->iduser !== null && $data->iduser !== '' && $data->iduser > 0) {
			$sql = 'update  dzw_user set CS_Name = \'' . $this->_sql_param_filter ( $data->user ) . '\'';
			$sql .= ',CS_Sex = ' . $this->_sql_param_filter ( $data->sex );
			$sql .= ',CS_Sr = \'' . $this->_sql_param_filter ( $data->birthday ) . '\'';
			$sql .= ',CS_Email = \'' . $this->_sql_param_filter ( $data->email ) . '\'';
			$sql .= ',CS_Gsmc = \'' . $this->_sql_param_filter ( $data->company ) . '\'';
			$sql .= ',CS_Tdrs = \'' . $this->_sql_param_filter ( $data->teamcount ) . '\' where CS_ID = ' . $this->_sql_param_filter ( $data->iduser );
			
			$sql_result = $this->_sql_select ( $sql );
			if ($sql_result && mysql_affected_rows () > 0) {
				$isOk = true;
			} else {
				$isOk = false;
			}
		}
		$c = $isOk ? 1 : 0;
		$result->__status = $c;
		$result->__stateInfo = '更新 ' . $c . '条数据';
		$result->__result = $c;
		$this->_sql_close ();
		return $result;
	}
	/**
	 * 注册
	 *
	 * @param unknown $data        	
	 * @return StdClass
	 */
	public function register($data) {
		$result = new StdClass ();
		$isExist = false;
		$isOk = false;
		if (isset ( $data ) && $data !== null && isset ( $data->telcode ) && $data->telcode !== null && $data->telcode !== '' && isset ( $data->pwd ) && $data->pwd !== null && $data->pwd !== '') {
			$data->pwd = md5 ( $data->pwd );
			$sql = 'select count(CS_Name) as c from dzw_user where CS_Name =\'' . $this->_sql_param_filter ( $data->telcode ) . '\' limit 0,1';
			$sql_result = $this->_sql_select ( $sql );
			$count = 0;
			if ($sql_result) {
				while ( $row = mysql_fetch_array ( $sql_result ) ) {
					$count = $row ['c'] - 0;
				}
			}
			if ($count > 0) {
				$isOk = true;
				$isExist = true;
			} else {
				$sql = 'insert  into dzw_user (CS_ID,CS_Name,CS_Pass) values (NULL,\'' . $this->_sql_param_filter ( $data->telcode ) . '\',\'' . $this->_sql_param_filter ( $data->pwd ) . '\')';
				$sql_result = $this->_sql_select ( $sql );
				if ($sql_result && mysql_affected_rows () > 0) {
					$isOk = true;
				} else {
					$isOk = false;
				}
			}
			$c = $isOk ? 1 : 0;
			$result->__status = $c;
			if ($isExist) {
				$result->__result = 0;
				$result->__stateInfo = '该号码已经注册了哦,直接登录吧！';
			} else {
				if ($result->__status === 1) {
					$result->__stateInfo = '注册成功';
				} else {
					$result->__stateInfo = '注册失败';
				}
				$result->__result = $c;
			}
		} else {
			$result->__status = 1;
			$result->__result = 0;
			$result->__stateInfo = '手机号 或  密码为空.';
		}
		$this->_sql_close ();
		return $result;
	}
	/**
	 * 修改密码
	 *
	 * @param unknown $data        	
	 * @return StdClass
	 */
	public function changePwd($data) {
		$result = new StdClass ();
		$isOk = false;
		if (isset ( $data ) && $data !== null && isset ( $data->iduser ) && $data->iduser !== null && $data->iduser !== '' && isset ( $data->pwd ) && $data->pwd !== null && $data->pwd !== '' && isset ( $data->newpwd ) && $data->newpwd !== null && $data->newpwd !== '') {
			$data->pwd = md5 ( $data->pwd );
			$data->newpwd = md5 ( $data->newpwd );
			$sql = 'update  dzw_user set CS_Pass = \'' . $this->_sql_param_filter ( $data->newpwd ) . '\'';
			$sql .= '  where CS_ID = ' . $this->_sql_param_filter ( $data->iduser ) . ' and CS_Pass = \'' . $this->_sql_param_filter ( $data->newpwd ) . '\'';
			
			$sql_result = $this->_sql_select ( $sql );
			if ($sql_result && mysql_affected_rows () > 0) {
				$isOk = true;
			} else {
				$isOk = false;
			}
		}
		$c = $isOk ? 1 : 0;
		$result->__status = $c;
		$result->__stateInfo = $c ? '修改成功' : '修改失败';
		$result->__result = $c;
		$this->_sql_close ();
		return $result;
	}
}

$bll = new UserService ();
$bll->on_do ();
?>
