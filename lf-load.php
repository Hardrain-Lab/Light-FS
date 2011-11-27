<?php

/**
 * 载入..
 * 
 * 
 * @author		Abreto
 * @copyleft	Hardrain
 * @package		LightFS;
 * @subpackage	System::Load
 */

if(!defined('IN_LIGHTFS'))
{
	die('Access Denial!');
}

/** 定义当前文件目录为 ABSPATH  */
define( 'ABSPATH', dirname(__FILE__) . '/' );

if( file_exists( ABSPATH . 'lf-config.php' ) ) {
	
	require_once( ABSPATH . 'lf-config.php' );
	
	if( !sys::get_option('installed') )
	{
		/// 如果还未安装
		// 设置安装程序的路径
		if ( strpos($_SERVER['PHP_SELF'], 'lf-admin') !== false )
			$path = '';
		else
			$path = 'lf-admin';
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title>貌似您还未安装</title> 
</head> 
<body>
<p>看起来您还没有安装 轻文件 系统，请点击以下链接开始安装</p>
<p><a href="<?php echo $path; ?>/installer.php">点我开始安装！</a></p>
</body>
</html>
<?php 
		die();
	}
	
	define('LF_LOAD_THEME', true);

	require_once( ABSPATH . LFINC . '/template-loader.php' );
	
} else {
	
	// 如果不存在 lf-config.php 文件
	
	// 设置安装程序的路径
	if ( strpos($_SERVER['PHP_SELF'], 'lf-admin') !== false )
		$path = '';
	else
		$path = 'lf-admin/';
	
	define( 'LFINC', 'lf-includes' );
	
	require_once( ABSPATH . LFINC . '/lf-err.php' );
	
	//echo( '' );
}

?>
