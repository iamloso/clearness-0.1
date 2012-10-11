<?php
class common
{
   static public $instance      = "";           #公共类实例化变量
   static public $core_files    = array();      #记数核心文件 

   public function require_file($file_name)
   {
		if (!isset(self::$core_files[$file_name])) 
		{
			if (file_exists($file_name))
		   	{
				require $file_name;
				self::$core_files[$file_name] = true;
			} 
			else
		   	{
				self::$core_files[$file_name] = false;
			}
		}
		return self::$core_files;
   }

   	/**
	 *初始公共类
	 */
	static public function instance()
	{
	      return  common::$instance = new self();     
	}
}

