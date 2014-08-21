<?php
/**
 *服务基类,简单封装
 *@author axx
 *
 */
abstract class BaseService {
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
					//echo $result;
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
	public abstract function on_get();
	public abstract function on_post($param = null);
}
?>