<?php

class PayPal extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function success() {
		die("success");
	}

	public function error() {
		die("error");
	}

	public function cancel(){
		die("cancel");
	}

	public function buy() {

		$html = '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="WTK6LSA5WQFLY">
<table>
<tr><td><input type="hidden" name="on0" value="Packages">Packages</td></tr><tr><td><select name="os0">
	<option value="Starter">Starter €1.00 EUR</option>
	<option value="Begginer">Begginer €2.00 EUR</option>
	<option value="Master">Master €3.00 EUR</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="EUR">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>';

	echo $html;
	}
}

?>