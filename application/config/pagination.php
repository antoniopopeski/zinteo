<?php
$config['uri_segment'] = 3;

/*
 * The pagination function automatically determines which segment of your URI contains
 * the page number. If you need something different you can specify it.
*/
$config['num_links'] = 6;

/*
 * The number of "digit" links you would like before and after the selected page number.
 * For example, the number 2 will place two digits on either side, as in the example links
 * at the very top of this page.
*/
$config['use_page_numbers'] = FALSE;//TRUE;

/*
 * By default, the URI segment will use the starting index for the items you are paginating.
 * If you prefer to show the the actual page number, set this to TRUE.
*/
$config['page_query_string'] = FALSE;//TRUE;

/*
 *If you would like to surround the entire pagination with some markup you can do it with
 * these two prefs:
*/
$config['full_tag_open'] = '<div class="pagination">';//'<p>';
$config['full_tag_close'] = '</div>';//'</p>';

/*
 * Customizing the First Link
*/
$config['first_link'] = 'почетна';//'First';

//$config['first_tag_open'] = '<div>';
//$config['first_tag_close'] = '</div>';

$config['last_link'] = 'последна';//'Last';

//$config['last_tag_open'] = '<div>';
//$config['last_tag_close'] = '</div>';

$config['next_link'] = 'следна';//'&gt;';

//$config['next_tag_open'] = '<div>';
//$config['next_tag_close'] = '</div>';

$config['prev_link'] = 'претходна';//&lt;';

//$config['prev_tag_open'] = '<div>';
//$config['prev_tag_close'] = '</div>';

$config['cur_tag_open'] = '<b>';
$config['cur_tag_close'] = '</b>';

//$config['num_tag_open'] = '<div>';
//$config['num_tag_close'] = '</div>';
