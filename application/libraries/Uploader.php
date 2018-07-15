<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*	Class To deal with File Uploads
*	Improved with Exceptions for better error management.
*/
class Uploader
{	
	private $uploadPath = './uploads/';
	private $newName = '';
	private $maxSize = 2000;
	private $maxHeight = 4000;
	private $maxWidth = 7000;
	private $minHeigth = 0;
	private $minWidth = 0;
	private $fileType = 'image';

	const FATAL_ERROR_UPLOAD = 1;
	const WARNING_ERROR_UPLOAD = 2;
	
	public function doUpload($formFile, $returnValue = 'path', $overWrite = true)
	{
		if(!is_uploaded_file($_FILES[$formFile]['tmp_name']))
		{
			$this->_errorDelete($formFile);
			throw new Exception('Фајлот не е аплодиран фајл', self::FATAL_ERROR_UPLOAD);
		}
		$extension = $this->_isCorrectFile($_FILES[$formFile]['type'], $this->fileType, $formFile);
		if(!$extension)
		{
			$this->_errorDelete($formFile);
			throw new Exception('Фајлот кој пробавте да го аплоадирате не е '.$this->fileType.' фајл', self::FATAL_ERROR_UPLOAD);
		}
		if($_FILES[$formFile]['error'] != 0)
		{
			$this->_errorDelete($formFile);
			throw new Exception('Грешка во аплоадирањето на фајлот', self::FATAL_ERROR_UPLOAD);
		}
		if($_FILES[$formFile]['size'] > $this->maxSize * 1024)
		{
			$this->_errorDelete($formFile);
			throw new Exception('Големината на фајлот е поголема од дозволената', self::FATAL_ERROR_UPLOAD);
		}
		$extension = $this->_isCorrectFile($_FILES[$formFile]['type'], $this->fileType, $formFile);
		if($this->_isExtImg($extension))
		{
			$isImg = 1;
			$dimension = getimagesize($_FILES[$formFile]['tmp_name']);
			$sirina = $dimension[0];
			$visina = $dimension[1];
			//throw new Exception("dimenzii: ".$sirina."x".$visina.", minimalni: ".$this->minWidth."x".$this->minHeigth, self::FATAL_ERROR_UPLOAD);
			if($sirina > $this->maxWidth)
			{
				$this->_errorDelete($formFile);
				throw new Exception('Ширината на сликата е поголема од дозволената', self::FATAL_ERROR_UPLOAD);
			}
			elseif($sirina < $this->minWidth)
			{
				$this->_errorDelete($formFile);
				throw new Exception('Ширината на сликата е помала од дозволената ('.$this->minWidth.')', self::FATAL_ERROR_UPLOAD);
			}
			if($visina > $this->maxHeight)
			{
				$this->_errorDelete($formFile);
				throw new Exception('Висината на сликата е поголема од дозволената', self::FATAL_ERROR_UPLOAD);
			}
			elseif($visina < $this->minHeigth)
			{
				$this->_errorDelete($formFile);
				throw new Exception('Висината на сликата е помала од дозволената ('.$this->minHeigth.')', self::FATAL_ERROR_UPLOAD);
			}
		}
		else
		{
			$dimension[0] = 0;
			$dimension[1] = 0;
			$isImg = 0;
		}
		$_FILES[$formFile]['name'] = $this->_cleanFileName($_FILES[$formFile]['name']);
		if($_FILES[$formFile]['name'] == '')
		{
			$this->_errorDelete($formFile);
			throw new Exception('Невалиден фајл аплоадиран', self::FATAL_ERROR_UPLOAD);
		}
		//if($extension!="png")
		//	throw new Exception('PNG фајл е потребен', self::FATAL_ERROR_UPLOAD);
		//$this->removeNaslovna();
		if($overWrite)
		{
			if(file_exists($this->uploadPath.$this->newName.'.'.$extension))
			{
				@unlink($this->uploadPath.$this->newName.'.'.$extension);
			}
		}
		if(!@copy($_FILES[$formFile]['tmp_name'], $this->uploadPath.$this->newName.'.'.$extension))
		{
			if(!@move_uploaded_file($_FILES[$form_file]['tmp_name'], $this->uploadPath.$this->newName.'.'.$extension))
			{
				//echo $this->uploadPath.$this->newName.'.'.$extension;
				$this->_errorDelete($formFile);
				throw new Exception('Фајлот неможеше да биде аплоадиран', self::FATAL_ERROR_UPLOAD);
			}
		}
		if(file_exists($this->uploadPath.$this->newName.'.'.$extension))
		{
			chmod($this->uploadPath.$this->newName.'.'.$extension, 0777);
		}
		switch($returnValue)
		{
			case 'path':
				return $this->uploadPath.$this->newName.'.'.$extension;
			break;
			case 'ext':
				return $extension;
			break;
		}
		return FALSE;
	}
	
	public function swfUpload($formFile, $returnValue = 'path', $overWrite = true)
	{
		if(!is_uploaded_file($_FILES[$formFile]['tmp_name']))
		{
			$this->_errorDelete($formFile);
			throw new Exception('Фајлот не е аплодиран фајл', self::FATAL_ERROR_UPLOAD);
		}
		$extension = $this->_isCorrectFile($_FILES[$formFile]['type'], 'swf', $formFile);
		if(!$extension)
		{
			$this->_errorDelete($formFile);
			throw new Exception('Фајлот кој пробавте да го аплоадирате не е swf фајл', self::FATAL_ERROR_UPLOAD);
		}
		if($_FILES[$formFile]['error'] != 0)
		{
			$this->_errorDelete($formFile);
			throw new Exception('Грешка во аплоадирањето на фајлот', self::FATAL_ERROR_UPLOAD);
		}
		$_FILES[$formFile]['name'] = $this->_cleanFileName($_FILES[$formFile]['name']);
		if($_FILES[$formFile]['name'] == '')
		{
			$this->_errorDelete($formFile);
			throw new Exception('Невалиден фајл аплоадиран', self::FATAL_ERROR_UPLOAD);
		}
		if($overWrite)
		{
			if(file_exists($this->uploadPath.$this->newName.'.'.$extension))
			{
				@unlink($this->uploadPath.$this->newName.'.'.$extension);
			}
		}
		if(!@copy($_FILES[$formFile]['tmp_name'], $this->uploadPath.$this->newName.'.'.$extension))
		{
			if(!@move_uploaded_file($_FILES[$form_file]['tmp_name'], $this->uploadPath.$this->newName.'.'.$extension))
			{
				//echo $this->uploadPath.$this->newName.'.'.$extension;
				$this->_errorDelete($formFile);
				throw new Exception('Фајлот неможеше да биде аплоадиран', self::FATAL_ERROR_UPLOAD);
			}
		}
		if(file_exists($this->uploadPath.$this->newName.'.'.$extension))
		{
			chmod($this->uploadPath.$this->newName.'.'.$extension, 0777);
		}
		switch($returnValue)
		{
			case 'path':
				return $this->uploadPath.$this->newName.'.'.$extension;
				break;
			case 'ext':
				return $extension;
				break;
		}
		return FALSE;
	}
	
	//Public setter methods for more flexibility.
	public function setPath($path)
	{
		$this->uploadPath = $path;
		return $this->uploadPath;
	}
	
	public function setNewName($name)
	{
		if($name != '')
			$this->newName = $name;
		return $this->newName;
	}
	
	public function setMaxSize($size)
	{
		if($size != '' AND $size != 0)
			$this->maxSize = $size;
		return $this->maxSize;
	}
	
	public function setMaxWidth($width)
	{
		if($width != '' AND $width != 0)
			$this->maxWidth = $width;
		return $this;
	}
	
	public function setMinWidth($width)
	{
		if($width != '' AND $width != 0)
			$this->minWidth = $width;
		return $this;
	}
	
	public function setMaxHeight($height)
	{
		if($height != '' AND $height != 0)
			$this->maxHeight = $height;
		return $this;
	}
	
	public function setMinHeight($height)
	{
		if($height != '' AND $height != 0)
			$this->minHeigth = $height;
		return $this;
	}
	
	public function setFileType($type)
	{
		if($type != '')
			$this->fileType = $type;
		return $this;
	}
	
	
	//Private methods.
	
	//Try to delete the file without throwing error.
	private function _errorDelete($formFile)
	{
		@unlink($_FILES[$formFile]['tmp_name']);
	}
	
	//If you want to add more types, extend this method.
	private function _isCorrectFile($file, $type = 'image', $formFile)
	{
		switch($type)
		{
			case 'image':
				return $this->_isImage($file);
			break;
			
			case 'png':
				return $this->_isPng($file);
			break;
			
			case 'xml':
				return $this->_isXml($formFile);
			break;
			
			case 'pdf':
				return $this->_isPdf($file);
			break;
			
			case 'swf':
				return $this->_isSwf($file);
			break;
		}
	}
	
	//Methods to check if the file is xml. Return is xml
	private function _isXml($formFile)
	{
		$extension = end(explode('.', $_FILES[$formFile]['name']));
		if($extension == 'xml')
		{
			return 'xml';
		}
		return false;
	}
	
	//Possible returns are: png, jpeg, gif or false. Taken from CI.
	private function _isImage($file)
	{
		$pngMimes  = array('image/x-png', 'image/png');
		$jpegMimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');
		$gifMimes = array('image/gif');
		if(in_array($file, $pngMimes))
		{
			$file = 'png';
		}
		elseif(in_array($file, $jpegMimes))
		{
			$file = 'jpeg';
		}
		elseif(in_array($file, $gifMimes))
		{
			$file = 'gif';
		}
		$imgMimes = array(
			'gif',
			'jpeg',
			'png',
		);
		return (in_array($file, $imgMimes)) ? $file : FALSE;
	}
	
	private function _isPng($file)
	{
		$pngMimes  = array('image/x-png', 'image/png');
		if(in_array($file, $pngMimes))
		{
			$file = 'png';
		}
		return ($file=='png') ? $file : FALSE;
	}
	
	private function _isPdf($file)
	{
		$pdfMimes = array('application/pdf', 'application/x-download');
		return (in_array($file, $pdfMimes))? 'pdf' : false;
	}
	
	private function _isSwf($file)
	{
		$swfMimes = array('application/x-shockwave-flash');
		return (in_array($file, $swfMimes))? 'swf' : false;
	}
	
	//Check if the extension is image one.
	private function _isExtImg($ext)
	{
		$imgs = array('png', 'jpeg', 'gif');
		if(in_array($ext, $imgs))
		{
			return true;
		}
		return false;
	}
	
	//CI method to clean the file name.
	private function _cleanFileName($filename)
	{
		$bad = array(
						"<!--",
						"-->",
						"'",
						"<",
						">",
						'"',
						'&',
						'$',
						'=',
						';',
						'?',
						'/',
						"%20",
						"%22",
						"%3c",		// <
						"%253c", 	// <
						"%3e", 		// >
						"%0e", 		// >
						"%28", 		// (
						"%29", 		// )
						"%2528", 	// (
						"%26", 		// &
						"%24", 		// $
						"%3f", 		// ?
						"%3b", 		// ;
						"%3d"		// =
					);
					
		$filename = str_replace($bad, '', $filename);
		return stripslashes($filename);
	}
	
	function removeNaslovna()
	{
		$dir = $this->uploadPath;//"./gallery/$godina/$id
		$id = trim(substr($dir, 15), '/');
		
		if(file_exists($dir."vnatresna_".$id.".jpeg"))
			unlink($dir."default_".$id.".jpeg");
		if(file_exists($dir."vnatresna_".$id.".png"))
			unlink($dir."vnatresna_".$id.".png");
		
		if(file_exists($dir."default_".$id.".jpeg"))
			unlink($dir."default_".$id.".jpeg");
		if(file_exists($dir."default_".$id.".png"))
			unlink($dir."default_".$id.".png");
		
		if(file_exists($dir."normal_".$id.".jpeg"))
			unlink($dir."normal_".$id.".jpeg");
		if(file_exists($dir."normal_".$id.".png"))
			unlink($dir."normal_".$id.".png");
		
		if(file_exists($dir."arhiva_".$id.".jpeg"))
			unlink($dir."arhiva_".$id.".jpeg");
		if(file_exists($dir."arhiva_".$id.".png"))
			unlink($dir."arhiva_".$id.".png");
		
		if(file_exists($dir."top_".$id.".jpeg"))
			unlink($dir."top_".$id.".jpeg");
		if(file_exists($dir."top_".$id.".png"))
			unlink($dir."top_".$id.".png");
		
		if(file_exists($dir."naj_top_".$id.".jpeg"))
			unlink($dir."naj_top_".$id.".jpeg");
		if(file_exists($dir."naj_top_".$id.".png"))
			unlink($dir."naj_top_".$id.".png");
		
		if(file_exists($dir."mala_".$id.".jpeg"))
			unlink($dir."mala_".$id.".jpeg");
		if(file_exists($dir."mala_".$id.".png"))
			unlink($dir."mala_".$id.".png");
	}
}