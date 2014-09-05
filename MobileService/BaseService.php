<?php
define ( '_db_name_', 'dzw_data' );
define ( '_db_server_', '192.168.1.125' );
define ( '_db_user_', 'root' );
define ( '_db_pwd_', '' );
/**
 * 服务基类,简单封装
 *
 * @author axx
 *        
 */
abstract class BaseService {
	public $con = null;
	/**
	 * 处理请求
	 */
	public function on_do() {
		header ( 'Accept:application/json' );
		header ( 'Content-Type:application/json' );
		header ( 'Accept-Charset:UTF-8' );
		$method = $_SERVER ['REQUEST_METHOD'];
		$request = explode ( '/', substr ( @$_SERVER ['PATH_INFO'], 1 ) );
		$request_func = '';
		if (isset ( $request ) && $request !== null && $request !== '') {
			$lg = count ( $request );
			if ($lg > 0) {
				$request_func = $request [0];
			}
		}
		$result = '';
		
		switch ($method) {
			case 'GET' :
				if (! isset ( $request_func ) || $request_func === null || $request_func === '') {
					$request_func = 'on_get';
				}
				if (isset ( $request_func ) && $request_func !== null && $request_func !== '') {
					
					$result = $this->{$request_func} ();
				}
				
				// $result = $this->on_get ();
				break;
			case 'POST' :
				if (! isset ( $request_func ) || $request_func === null || $request_func === '') {
					$request_func = 'on_post';
				}
				$post_param = null;
				$request_body = file_get_contents ( 'php://input' );
				if (isset ( $request_body ) && $request_body !== null && $request_body !== '') {
					$post_param = json_decode ( $request_body );
				}
				if (isset ( $request_func ) && $request_func !== null && $request_func !== '') {
					$result = $this->{$request_func} ( $post_param );
					// echo $result;
				}
				// $result = $this->on_post ( $post_param );
				break;
		}
		if (isset ( $result ) && $result !== null && $result !== '') {
			
			$result = json_encode ( $result );
			// print_r ( json_last_error_msg () );
			echo $result;
		}
	}
	/**
	 * 数据库连接
	 */
	public function _sql_connect() {
		$this->con = mysql_connect ( _db_server_, _db_user_, _db_pwd_ );
		mysql_query ( "SET NAMES 'UTF8'", $this->con );
	}
	/**
	 * 关闭数据库连接
	 */
	public function _sql_close() {
		if ($this->con) {
			mysql_close ( $this->con );
			$this->con = null;
		}
	}
	/**
	 * 查询数据库连接
	 */
	public function _sql_select($sql) {
		if (! $this->con) {
			$this->_sql_connect ();
		}
		$result = null;
		if ($this->con !== null) {
			
			mysql_select_db ( _db_name_, $this->con );
			$result = mysql_query ( $sql );
		} else {
			$result = false;
		}
		return $result;
	}
	public function __destruct() {
		$this->_sql_close ();
	}
	public abstract function on_get();
	public abstract function on_post($param = null);
}

?>