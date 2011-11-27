<?php

/**
 * 加载所有文件夹和文件
 * 
 */

require_once( ABSPATH . LFINC . '/class/folder.class.php' );
require_once( ABSPATH . LFINC . '/class/file.class.php' );

global $LF;

$LF['FOLDER'] = new Folder_Set();
$LF['FILE'] = new Files();

function in_dir($path, $parent)
{
	global $LF;
	
	if( $handle = @opendir($path) )
	{
		while( $item = readdir($handle) )
		{
			if($item == '.' || $item == '..' || $item == '#.conf.php') continue;
			
			$file = "{$path}/{$item}";
			
			if( is_dir($file) )
			{
				if( !file_exists( $file . '/#.conf.php' ) )		// 如果此目录不在 轻文件 之下,
					continue;
				$f = new Folder($item, $file, $parent);
				$LF['FOLDER']->insert($f);
				in_dir($file, $f);
			} else if ( is_file($file) ) {
				$f = new File($item, $parent);
				$LF['FILE']->insert($f);
			}
		}
	}
}

in_dir(ABSPATH.LFUFS, Folder_Set::$_ROOT_);

?>
