<?php
/**
 *loso 
 *2012-9-24
 *clearness框架进程
 */ 
class clearness
{
	public static $instance  = NULL;   #clearness的实例化变量
    public static $core_files= array();#记数核心文件 
	
    public $section_url      = "";   #index.php后面的url  	
	public $root_url         = "";   #到项目名称绝对路径 
	public $action_name      = "";   #控制器类名称
	public $method_name      = "";   #控制器方法
    public $sec_url_array    = "";   #$section_url 转化成数组
	public $param_url_array  = "";   #参数数组

    public function __construct()
	{
		  $this->root_url   = getcwd().'/';  
		  $this->cn_path    = $this->root_url.'clearness/core/';
		  $this->app_path   = $this->root_url.'app/action/';

		  #执行分析进程
          $this->analyse_progress();
		  #执行核心资源进程
		  $this->core_resource();
		  #执行应用进程
		  $this->app_progress(); 
	}
    
	/**
	 *初始化进程
	 */
	static public function instance()
	{
		  if(self::$instance!==NULL)
		  {
               return self::$instance;		  
		  }
	      return  self::$instance = new self();     
	}

	/**
	 *核心资源进程路线
	 */ 
	public function core_resource()
	{
		$core_lists = array
			         (
					    $this->cn_path.'action.class.php',
					 );
        foreach($core_lists as $val)
		{
		   $this->require_file($val);  
		}	
	}

	/**
	 *分析进程路线
	 */ 
	public function analyse_progress()
	{
        $this->section_url     = $_SERVER['PATH_INFO']; 	
        $this->param_url_array = $this->sec_url_array  = explode('/',trim($this->section_url,'/'));
		$this->action_name     = array_shift($this->param_url_array);
		$this->method_name     = array_shift($this->param_url_array);
		$i = 0;
		foreach($this->param_url_array as $key => $val)
		{
			if ($i % 2)
			{
				$this->get_params[$lastval] = $val;
			}
			else
			{
				$this->get_params[$val] = FALSE;
				$lastval = $val;
			}
			$i++;
		}
	} 

	/**
	 *应用进程路线
	 */
	public function app_progress()
	{
		$app_filename = $this->action_name.'.class.php';
		$this->require_file($this->app_path.$app_filename);
	}

	/**
	 *核心资源加载函数
	 */ 
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
} 
$cn = clearness::instance();
$action = new $cn->action_name();
$action->{$cn->method_name}();
