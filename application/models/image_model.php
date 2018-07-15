<?php 
class Image_model extends CI_Model
{
	private $config;
	private $basePath;
	private $filePathDiff;
	
	function __construct()
    {
        parent::__construct();
    	//$this->load->library('ftp');
    	//$this->load->model('sliki_model');
		if(strpos(base_url(), ".dev")!== false)
		{
			$this->config['hostname'] = 'ftp.guru.mk';
			$this->config['username'] = 'sliki_guru@guru.mk';
			$this->config['password'] = 'V7z6AuVZXHNC';
			$this->basePath = "/gallery";
			$this->config['debug'] = FALSE;
			$this->filePathDiff = "";
		} else {
			$this->config['hostname'] = 'localhost';
			$this->config['username'] = 'toni';
			$this->config['password'] = 'tzt123';
			$this->config['debug'] = TRUE;
			$this->basePath = "/guru/gallery";
			$this->filePathDiff = "/store/webs";
		}
    }
	
	function resizeImg($path, $image_name, $width, $height)
	{
		$mode = 0777;
		//pravi slike spored definiran model i plus thumb
		$fullPath = './'.$path.'/'.$image_name;
		if(!file_exists($fullPath))
		{
			throw new Exception('The picture '.$fullPath.' don\'t exist');
		}
		$dim = getimagesize($fullPath);
		$ration = $dim[0]/$dim[1];
		//za svite tipovi:
		//vnatresna 327x000
		$reziseConfig['source_image'] = $fullPath;
		$reziseConfig['image_library'] = 'gd2';
		$reziseConfig['quality'] = '100%';
		$reziseConfig['new_image'] = str_replace("osnova_", "item_", $image_name);
		$reziseConfig['maintain_ratio'] = TRUE;
		if($ration < $width/$height)
		{
			$reziseConfig['width'] = $width;
			$reziseConfig['height'] = $width/$ration;
			$newWidth = $width;
			$newHeight = $width/$ration;
		} else {
			$reziseConfig['width'] = $height*$ration;
			$reziseConfig['height'] = $height;
			$newWidth = $height*$ration;
			$newHeight = $height;
		}
		$this->load->library('image_lib');
		$this->image_lib->initialize($reziseConfig);
		$this->image_lib->resize();
		$this->image_lib->clear();
		chmod('./'.$path.'/'.$reziseConfig['new_image'], $mode);
		$cropConfig['source_image'] = './'.$path.'/'.$reziseConfig['new_image'];
		unset($reziseConfig);
		$cropConfig['maintain_ratio'] = FALSE;
		$cropConfig['width'] = $width;
		$cropConfig['height'] = $height;
		$cropConfig['x_axis'] = ($newWidth - $width)/2;
		$cropConfig['y_axis'] = ($newHeight - $height)/2;
		$this->image_lib->initialize($cropConfig);
		$this->image_lib->crop();
		$this->image_lib->clear();
		chmod($cropConfig['source_image'], $mode);
		unset($cropConfig);
		unlink($fullPath);
		return TRUE;
	}
}
