<?php

defined('BASEPATH') OR exit('No direct script access allowed');





class Crud extends CI_Controller{

    function __construct(){

        parent::__construct();

        $this->load->model('administrator');

        $this->load->library('grocery_CRUD');    

    }

    public function index(){

        exit('nothing interest here!');

    }

    

    public function edit_admin(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('administrator');

	$crud->set_table('admins');

        $crud->unset_add();

        $crud->unset_delete();

        $crud->unset_export();

        $crud->unset_print();

        $crud->field_type('password', 'password');

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    public function continents(){

        $this->administrator->get();

        $output=array();
		
		$continents=$this->db->query("SELECT kontinent FROM `vets` GROUP BY kontinent")->result_array();
		foreach($continents as $con){
			//print_r($con);
			$this->db->insert('continents',array('continent'=>$con['kontinent']));
		}
		//exit;
		

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('continent');

	$crud->set_table('continents');

        $crud->set_rules('continent','Continent','required');

        $crud->unset_delete();

        $crud->unset_export();

        $crud->unset_print();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    public function countries(){

        $this->administrator->get();

        $output=array();

		$countries=$this->db->query("SELECT land, kontinent 
FROM `vets`
GROUP BY land")->result_array();
		foreach($countries as $con){
			$kon=$this->db->query("SELECT * FROM continents WHERE continent='".$con['kontinent']."'")->result_array();
			$this->db->insert('countries',array('continent'=>$kon[0]['id'],'country'=>$con['land']));
		}

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('country');

	$crud->set_table('countries');

	$crud->set_relation('continent','continents','{continent}');

        $crud->set_rules('continent','Continent','required');

        $crud->set_rules('country','Country','required');

        $crud->set_rules('available','Available','required');

        $crud->unset_delete();

        $crud->unset_export();

        $crud->unset_print();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    

    public function cities(){

        $this->administrator->get();

        $output=array();

		$cities=$this->db->query("SELECT ort
FROM `vets`
GROUP BY ort")->result_array();
		foreach($cities as $cc){
			$this->db->insert('cities',array('country'=>3,'city'=>$cc['ort'],'shipping_price'=>'0.00','available'=>1));
		}

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('city');

	$crud->set_table('cities');

	$crud->set_relation('country','countries','{country}');

        $crud->set_rules('continent','Continent','required');

        $crud->set_rules('country','Country','required');

        $crud->set_rules('available','Available','required');

        $crud->set_rules('city','City','required');

        $crud->set_rules('shipping_price','Shipping price','required|numeric');

        $crud->unset_export();

        $crud->unset_print();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    

    

    public function products(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('product');

	$crud->set_table('products');

        $crud->set_rules('name','Name','required');
        $crud->display_as('name','Name (translation label)');
        $crud->display_as('description','Description (translation label)');

        $crud->set_rules('image','Image','required');

        $crud->set_rules('proprties','Properties','required');

        $crud->set_rules('price','Price','required');

        $crud->set_rules('active','Active','required');

        $crud->set_field_upload('image','themes/front/images/products');
        $crud->display_as('image','Image <script>$("#image_display_as_box").html("Image (must be 345 X 235 px)");</script>');


        $crud->field_type('properties','multiselect',

                                array(

                                    "1"  => "Big dogs", 

                                    "2" => "Middle dogs",

                                    "3" => "Small dogs", 

                                    "4" => "Cats", 

                                    "5" => "Dogs and cats",

                                    ));

        $crud->unset_export();

        $crud->unset_print();

        $crud->unset_delete();
        $crud->unset_add();
        $crud->unset_texteditor('description');

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    

    public function pages(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('page');

	$crud->set_table('static_pages');

        $crud->set_relation('parent_page', 'static_pages', '{title}');

	$crud->unset_texteditor('short_description');
        $crud->columns('id','parent_page','title','short_description','image','active');
        $crud->set_rules('title','Title','required');

        $crud->set_rules('active','Active','required');

        $crud->set_field_upload('image','themes/front/images');

        $crud->unset_export();

        $crud->unset_print();

        $crud->unset_delete();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    public function menu(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('menu item');

	$crud->set_table('menus');

        $crud->set_relation('parent', 'menus', '{name}');

        $crud->set_rules('name','Name','required');

        $crud->set_rules('url','URL','required');
        $crud->display_as('url','url <script>$("#url_display_as_box").html("Url (if you change this, may broke the link)");</script>');

        $crud->set_rules('target','Target','required');

        $crud->set_rules('order','Order','required');

        $crud->set_rules('active','Active','required');

        $crud->unset_export();

        $crud->unset_print();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    public function languages(){

        $this->administrator->get();

        $output=array();
		
		$languages=$this->db->query("SELECT * FROM languages")->result_array();
		$translations=$this->db->query("SELECT * FROM translations WHERE lang=1")->result_array();
		foreach($translations as $label){
			//print_r($label);
			foreach($languages as $lang){
				$check=$this->db->query("SELECT * FROM translations WHERE lang=".$lang['id']." AND label='".$label['label']."'")->result_array();
				if(count($check)){
				}
				else{
					echo $lang['language'].' nema: '.$label['label'].'
';
					$this->db->insert('translations',array('lang'=>$lang['id'],'label'=>$label['label'],'text'=>str_replace('_',' ',$label['label'])));
				}
			}
		}
			
		//exit;

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('language');

	$crud->set_table('languages');

        $crud->set_rules('language','Language','required');

        $crud->set_rules('active','Active','required');

        $crud->unset_export();

        $crud->unset_print();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    public function translations(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('language label');

	$crud->set_table('translations');

	$crud->set_relation('lang','languages','{language}');

	$crud->display_as('lang','Language');

	$crud->display_as('text','Translation');

        $crud->set_rules('lang','Language','required');

        $crud->set_rules('label','Label','required');

        $crud->set_rules('text','Translation','required');

        $crud->unset_export();

        $crud->unset_print();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    

    public function vets(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('vet');

	$crud->set_table('vets');

        $crud->columns('titel','vorname','nachname','strasse','plz','ort','land','kontinent');

        $crud->display_as('titel','Prefix');

        $crud->display_as('vorname','Name');

        $crud->display_as('nachname','Surname');

        $crud->display_as('strasse','Address');

        $crud->display_as('plz','Zip code');

        $crud->display_as('ort','Place');

        $crud->display_as('land','Country');

        $crud->display_as('kontinent','Continent');

        $crud->unset_export();

        $crud->unset_print();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    public function importvets(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

        $crud->callback_before_insert(array($this,'import_vets'));

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('csv(excel) file');

	$crud->set_table('vets_import');

        $crud->set_rules('file','File','required');

        $crud->set_rules('date','Date','required');

        $crud->set_field_upload('file','themes/front/vets');

        $crud->field_type('date', 'hidden', date('Y-m-d H:i:s'));

        $crud->field_type('is_successful', 'hidden', 'yes');

        $crud->display_as('is_successful', 'Successful imported');

        $crud->unset_edit();

        $crud->unset_delete();

        $crud->unset_export();

        $crud->unset_print();

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    public function import_vets($post_array) {

        if(strstr($post_array['file'],'.csv')){

            $for_insert=array();

            $post_array['is_successful'] ='yes';

            $file= str_replace('Cumstomer ID','Cumstomer_ID',file_get_contents('themes/front/vets/'.$post_array['file']));

            $csv_lines=explode("\r\n",$file);

            for($n=1;$n<count($csv_lines)-1;$n++){

                $fields=explode(',',$csv_lines[0]);

                $line=explode(',',$csv_lines[$n]);

                for($i=0;$i<count($fields);$i++){

                    if($i>0){

                        $for_insert[$fields[$i]]=htmlentities($line[$i],ENT_QUOTES | ENT_IGNORE | ENT_SUBSTITUTE | ENT_DISALLOWED | ENT_HTML401 | ENT_XML1 | ENT_XHTML | ENT_HTML5, "ISO-8859-1");

                    }

                }

                $this->db->insert('vets',$for_insert);

            }

        }

        else{

            $post_array['is_successful'] ='no';

        }

        return $post_array;

    } 

    

    

    public function coupons(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('coupon code');

	$crud->set_table('coupon_codes');

        $crud->set_rules('vet','Vet','required|is_unique[coupon_codes.vet]');

        $crud->set_rules('code','Code','required|is_unique[coupon_codes.code]');

        $crud->set_rules('discount','Discount','required|numeric');

        $crud->display_as('discount', 'Discount (%)');

        $crud->set_relation('vet', 'vets', '{vorname} {nachname} - {ort} [{land}]');

        $crud->unset_export();

        $crud->unset_print();

        $crud->unset_delete();

        $crud->edit_fields('discount','active');

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    public function settings(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('item');

	$crud->set_table('settings');

        $crud->set_rules('value','Value','required');

        //$crud->set_rules('code','Code','required|is_unique[coupon_codes.code]');

        //$crud->set_rules('discount','Discount','required|numeric');

        $crud->display_as('setting', '');

        $crud->display_as('value', '');

        //$crud->set_relation('vet', 'vets', '{vorname} {nachname} - {ort} [{land}]');

        $crud->unset_export();

        $crud->field_type('setting', 'readonly');

        $crud->field_type('value', 'string');

        $crud->unset_texteditor('value');

        $crud->unset_print();

        $crud->unset_delete();

        $crud->unset_add();

        //$crud->edit_fields('discount','active');

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    

    

    

    public function users(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('user');

	$crud->set_table('users');

        $crud->columns('id','company','name','surname','street','zip','city','country','email','phone','social_login','social_body','created');

        $crud->unset_export();

        $crud->unset_columns('password');

        $crud->unset_print();

        $crud->unset_texteditor('street','social_body');

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

    

    public function orders(){

        $this->administrator->get();

        $output=array();

        $crud = new grocery_CRUD();

	$crud->set_theme('twitter-bootstrap');

	$crud->set_subject('order');

	$crud->set_table('orders');

        $crud->display_as('vet','Referred by vet');

        //$crud->columns('titel','vorname','nachname','strasse','plz','ort','land','kontinent');

        $crud->unset_export();

        $crud->unset_print();
        $crud->unset_add();

        $crud->set_relation('user', 'users', '{name} {surname}');

        $crud->set_relation('product', 'products', '{name} ({price})');

        $crud->set_relation('vet', 'vets', '{vorname} {nachname} {ort}');

        $crud->field_type('date', 'hidden', date('Y-m-d H-:i:s'));

        $crud->unset_texteditor('shipping_details');

        $crud->unset_delete();

        //$crud->unset_texteditor('street','social_body');

	$output = $crud->render();

	$this->load->view($this->config->item('theme_path').'crud.php',$output);

    }

    

}

