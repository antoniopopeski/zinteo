<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['theme_path'] = '../../themes/admin/';
$config['base_theme_path'] = 'themes/admin/';

//header config
$config['app_id']='vetfriend24';
$config['load_header'] = true;
$config['app_name'] = 'Vet Friend 24';
$config['show_logo'] = false;
$config['load_widget_search'] = false;
$config['load_widget_notifications'] = false;
$config['load_widget_profile_menu'] = true;
$config['profile_menu'] = array(
    array('text' => 'Edit Profile', 'link' => '/admin/crud/edit_admin'),
    //array('text' => '<span class="badge badge-danger pull-right">new</span> Inbox', 'link' => 'admin/inbox'),
    array('separated' => true),
    array('text' => 'Logout', 'link' => '/admin/logout'),
);
$config['crud_titles']=array(
    'edit_admin'=>array(
        'page_title'=>'Edit administrators',
        'page_description'=>'Here you can change administrator info',
        'container_title'=>'List of administrators'
    ),
    'continents'=>array(
        'page_title'=>'Manage continents',
        'page_description'=>'Here you can change add and update continents',
        'container_title'=>'List of continents'
    ),
    'countries'=>array(
        'page_title'=>'Manage countries',
        'page_description'=>'Here you can change add and update countries',
        'container_title'=>'List of countries'
    ),
    'cities'=>array(
        'page_title'=>'Manage cities and shipping price',
        'page_description'=>'Here you can change add and update cities and shipping prices',
        'container_title'=>'List of cities'
    ),
    'pages'=>array(
        'page_title'=>'Manage static pages',
        'page_description'=>'Here you can edit all static pages',
        'container_title'=>'List of pages'
    ),
    'menu'=>array(
        'page_title'=>'Manage menu items',
        'page_description'=>'Here you can add, edit, activate/deactivate and delete menu items',
        'container_title'=>'List of menu items'
    ),
    'languages'=>array(
        'page_title'=>'Manage languages',
        'page_description'=>'Here you can add, edit, activate/deactivate and delete languages',
        'container_title'=>'List of languages for your site'
    ),
    'translations'=>array(
        'page_title'=>'Manage translations',
        'page_description'=>'Here you can add and correct translations',
        'container_title'=>'List of translations for all languages'
    ),
    'products'=>array(
        'page_title'=>'Manage products',
        'page_description'=>'Here you can add and edit products',
        'container_title'=>'List of products'
    ),
    'vets'=>array(
        'page_title'=>'Manage vets',
        'page_description'=>'Here you can add, edit or delete vets',
        'container_title'=>'List of vets'
    ),
    'importvets'=>array(
        'page_title'=>'Import vets',
        'page_description'=>'Here you can import vets',
        'container_title'=>'Import history'
    ),
    'coupons'=>array(
        'page_title'=>'Coupon codes',
        'page_description'=>'Here you can add, edit or delete coupon codes for discount...',
        'container_title'=>'Coupon codes'
    ),
    'settings'=>array(
        'page_title'=>'Settings',
        'page_description'=>'Here you can update yout site settings',
        'container_title'=>'List of site settings'
    ),
    'users'=>array(
        'page_title'=>'Manage users/clients',
        'page_description'=>'Here you can view and update users / clients',
        'container_title'=>'List users/clients'
    ),
    'orders'=>array(
        'page_title'=>'View orders',
        'page_description'=>'Here you can view  and update orders',
        'container_title'=>'Order list'
    ),
    'transactions'=>array(
        'page_title'=>'View transactions',
        'page_description'=>'Here you can view  and update transactions',
        'container_title'=>'List of transactions'
    ),
		'socialnetworks'=>array(
				'page_title'=>'View social networks',
				'page_description'=>'Here you can view  and update social networks',
				'container_title'=>'List of social networks'
		),
		'footerlinks'=>array(
				'page_title'=>'View footer links',
				'page_description'=>'Here you can view  and update footer links',
				'container_title'=>'List of footer links'
		),
		
		'sidebar'=>array(
				'page_title'=>'View social sidebar editor',
				'page_description'=>'Here you can view  and update content sidebar',
				'container_title'=>'List of sidebar elements'
		),
    
);
