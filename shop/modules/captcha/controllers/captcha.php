<?php

Class Captcha extends Controller {

    function __construct()
    {
        parent::__construct();
        
        loader::database();
    }
    
    public function create()
    {
        $query = $this->db->query("SELECT * FROM ob_captcha WHERE ip_address ='".i_ip_address()."'");

        if($query->num_rows() > 10)  // Delete captchas after ten records ..
        {
            $this->db->where('ip_address', i_ip_address());
            $this->db->delete('ob_captcha');
        }

        $vals = array(
            'max_char'   => 5,
            'img_path'   => MODULES.'captcha'. DS .config('public_folder'). DS .'images'. DS,
            'img_url'    => base_url().'modules/captcha/'.config('public_folder').'/images/',
            'font_path'  => 'modules/captcha/'.config('public_folder').'/fonts/AHGBold.ttf',
            'font_size'  => 10,
            'img_width'  => 150,
            'img_height' => 40,
            'expiration' => 40,
            'background' => '#FFFFFF',
            'border'     => '#CCCCCC',
            'text'       => '#000000',
            'grid'       => '#000000',
            'shadow'     => '#CCCCCC',
            'pool'       => '0123456789',
            'points'     => '32'
        );

        $data['cap'] = captcha_create($vals);

        $cap_data = array(   // Insert captcha value to database
            'captcha_time'  => $data['cap']['time'], 
            'ip_address'    => i_ip_address(),
            'word'          => $data['cap']['word'],
        );

        $this->db->insert('ob_captcha', $cap_data);
        
        if(i_ajax())  // Ajax support
        {
            echo json_encode(array('image' => $data['cap']['image']));
            return;
        }
        
        echo json_encode(array(
            'view' => view('view_captcha', $data['cap']),
            'javascript' => view('view_javascript')
            ));  
    }

    // -------------------------------------------------------------------- 
    
    /**
    * Validator function
    *
    * return string
    */
    public function check()
    {
        $validator = lib('ob/Validator');

        // We use Global POST variable instead of HMVC.
        $word =  i_get_post('captcha_answer', $xss = TRUE, $use_global_var = TRUE);

        log_me('debug', 'Wrong security word attempt: ' . $word);

        if(empty($word) OR $word == '')
        {
           $validator->set_message('request', 'The security code you entered not valid, please try again.');

           echo '0';  // wrong answer
           
           return;
        }

        // First, delete old captchas
        $expiration = time()-7200;
        $this->db->query("DELETE FROM ob_captcha WHERE captcha_time < ".$expiration);

        // Check captcha
        $this->db->where('word', $word);
        $this->db->where('ip_address', i_ip_address());
        $this->db->where('captcha_time >', $expiration);

        $query = $this->db->get('ob_captcha');

        if ($query->num_rows() == 0)
        {
            $validator->set_message('request', 'The security code you entered not valid, please try again.');

            echo '0';  // wrong answer

        } else
        {
            echo '1';  // right answer
        }
    }

}

/* End of file captcha.php */
/* Location: .modules/captcha/controllers/captcha.php */