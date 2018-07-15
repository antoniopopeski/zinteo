<?php
class Translate extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		set_language();
		
	}
	
	public function index() {
		
		$lang = lib ( 'ob/Lang' );
		$translate = $lang->language;
	
	
	}
	
	public function lang($l) {
	
		if (i_post()) {
			$current_lang = i_post('current_language');
		
			$lang_file = APP . "lang" .DIRECTORY_SEPARATOR. "language" . DIRECTORY_SEPARATOR . $current_lang . ".php";
	
			$fh = fopen($lang_file, 'w');
				
			fwrite($fh,"<?php \n");
			foreach ($_POST as $k=>$v){
				if (strpos($k,"lang_original_")!==FALSE){
					if (mb_strlen($v)>0){
						$v=addslashes($v);
						fwrite($fh,  "\$lang['$v'] = \"");
						fwrite($fh, addslashes(i_post(str_replace("_original_","_translated_",$k))));
						fwrite($fh, "\";\n");
					}
				}
			}
		
			redirect('/admin/translate/lang/' . $current_lang);
		
		}
		
		$lang = lib ( 'ob/Lang' );
		loader::lang ( 'app/' . $l, 'language' );
		$translate = $lang->language;
		
		$data['current_language'] = $l;
 		$data['main'] = 'translate/lang';
 	
 		$data['page_title'] = lang("Language management");
 		$data['translate'] = $translate;
		

 		
 		
		return view ( "../theme/admin", $data, false );
	}
	
	
	
}