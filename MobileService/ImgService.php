<?php
include_once (dirname ( __FILE__ ) . '/BaseService.php');
class ImgService extends BaseService {
	public function on_get() {
	}
	public function on_post($param = null) {
	}
	public function getImg($imgObj = null) {
		$result = new StdClass ();
		$result->data = '';
		$result->__status = 0;
		$result->__stateInfo = '检索到0条数据';
		$result->__result = 0;
		if (isset ( $imgObj ) && $imgObj !== null && isset ( $imgObj->img ) && $imgObj->img !== null) {
			$img_dir = dirname ( dirname ( __FILE__ ) ) . '/MResource/Img/';
			$s = strpos ( $imgObj->img, '.' );
			if ($s && $s > 0) {
				$img_s_suffix = substr ( $imgObj->img, $s );
				$img_s_prefix = substr ( $imgObj->img, 0, $s );
				$img_path = $img_dir . $imgObj->img;
				$img_path_l = $img_path;
				$img_path_s = $img_dir . $img_s_prefix . '_s' . $img_s_suffix;
				$zip_result = $this->resizeImage ( $img_path_l, 120, 80, $img_path_s );
				
				$data = file_get_contents ( $img_path_s );
				if ($data !== null && $data !== '') {
					$data = base64_encode ( $data );
					if ($data !== null && $data !== '') {
						$result->data = $data;
						$result->__status = 1;
						$result->__stateInfo = '检索到1条数据';
						$result->__result = 1;
					}
				}
			}
		}
		return $result;
	}
	
	/**
	 *
	 * 等比例压缩图片
	 *
	 *
	 * @param String $src_imagename
	 *        	源文件名
	 * @param int $maxwidth
	 *        	压缩后最大宽度
	 * @param int $maxheight
	 *        	压缩后最大高度
	 * @param String $savename
	 *        	保存的文件名
	 * @author Yovae <yovae@qq.com>
	 * @version 1.0
	 *         
	 */
	function resizeImage($src_imagename, $maxwidth, $maxheight, $savename) {
		if (! file_exists ( $savename )) {
			$im = imagecreatefromjpeg ( $src_imagename );
			$current_width = imagesx ( $im );
			$current_height = imagesy ( $im );
			
			if (($maxwidth && $current_width > $maxwidth) || ($maxheight && $current_height > $maxheight)) {
				if ($maxwidth && $current_width > $maxwidth) {
					$widthratio = $maxwidth / $current_width;
					$resizewidth_tag = true;
				}
				
				if ($maxheight && $current_height > $maxheight) {
					$heightratio = $maxheight / $current_height;
					$resizeheight_tag = true;
				}
				
				if ($resizewidth_tag && $resizeheight_tag) {
					if ($widthratio < $heightratio) {
						$ratio = $widthratio;
					} else {
						$ratio = $heightratio;
					}
				}
				
				if ($resizewidth_tag && ! $resizeheight_tag) {
					$ratio = $widthratio;
				}
				if ($resizeheight_tag && ! $resizewidth_tag) {
					$ratio = $heightratio;
				}
				
				$newwidth = $current_width * $ratio;
				$newheight = $current_height * $ratio;
				
				if (function_exists ( "imagecopyresampled" )) {
					$newim = imagecreatetruecolor ( $newwidth, $newheight );
					imagecopyresampled ( $newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $current_width, $current_height );
				} else {
					$newim = imagecreate ( $newwidth, $newheight );
					imagecopyresized ( $newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $current_width, $current_height );
				}
				imagejpeg ( $newim, $savename, 60 );
				imagedestroy ( $newim );
				return 1;
			} else {
				imagejpeg ( $im, $savename, 60 );
				return 2;
			}
		}
		return 3;
	}
}
$bll = new ImgService ();
$bll->on_do ();
?>