<?php

Class Start extends Controller {    
                                      
    function __construct()
    {   
        parent::__construct();
        
        loader::helper('ob/request');
        
        if(db_item('username') == '')
        {
            show_error('<b>SETUP ERROR</b> - Please create a test database called <b>obullo</b> 
                and configure it from <b>/app/config/database.php</b>, then run the <b>test.sql</b> which is located in 
                your <b>/modules/welcome/</b> folder');
        }

        $folder = MODULES .'captcha'. DS .config('public_folder'). DS . 'images'. DS;

        if( ! is_really_writable($folder .'index.html'))
        {
            show_error('SETUP ERROR - Please set chmod settings to 777 for /modules/captcha folder: '. $folder);
        }
    }         

    public function index()
    {
        view_var('title', 'Welcome to Obullo Validation Model !');
                        
        $data['user'] = array();
        
        ## ----- HMVC CALL -----
        
        $data['row'] = request('captcha/create')->decode('json')->exec();
        
        view('view_vmodel', $data, false);
    }
    
    function ajax_example()
    {
        view_var('title', 'Welcome to Obullo Validation Model (AJAX) !');
        
        ## ----- HMVC CALL -----
          
        $data['row'] = request('captcha/create')->decode('json')->exec();
        
        view('view_vmodel_ajax', $data, false);
    }
    
    function do_post()
    {
        loader::model('user', false);  // Include user model
        
        $user = new User();
        $user->user_password = i_get_post('user_password');
        $user->user_email    = i_get_post('user_email');
        
        $data['user'] = $user;  // User object for none ajax request
  
        if($user->save())
        {
            if($this->uri->extension() == 'json')  // Ajax support
            {
                echo form_send_success($user);
                return;
            }
            else
            {
                sess_set_flash('notice', 'Form saved succesfully !');
                
                redirect('/welcome/start');
            }
        } 
        else
        {
            if($this->uri->extension() == 'json') // Ajax support 
            {
                echo form_send_error($user);
                return;
            }
            
            // debug On / Off
            // print_r($user->errors());
            
            //------ Hmvc call for none ajax requests -----//
        
            $data['row'] = request('captcha/create')->decode('json')->exec();
        }
        
        view('view_vmodel', $data, false);
        
    }
    
    
    public function delete()
    {
        loader::model('user', false);  // Include user model
        
        $user = new User();
        $user->where('usr_id', 1);
        
        if($user->delete())
        {
            echo 'User Deleted Successfuly !';
        } 
        else // SQL debug
        {
            echo $user->last_query();
        }
        
        print_r($user->errors());
    }
    
}

/* End of file start.php */
/* Location: .modules/test/controllers/start.php */