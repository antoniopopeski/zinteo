<?php
class send extends MY_Public
{
	function index()
	{
		$data = array("content"=>"p_send", "user"=>$this->user, "info"=>$this->info);
		$data['default_subject'] = "Check Zinteo - Cool social fantazy game, for virtual betting";
		$data['default_message'] = "Your friend ".$this->user->fname." invites you to check Zinteo".
			"<p>Zinteo is Global Social Betting Network - a place where ".
			"bettors from all around the world can compete to each other on real sport matches.</p>".
			"<p>All bets are money-free.</p><p>Most succesfull bettors can earn money and other awards.</p>".
			"<p><a href='http://zinteo.wordpress.com/'>More about Zinteo, on Zinteo Blog.</a></p>".
			"<p><a href='http://zinteo.com/fblogin'>Start Zinteo, here.</a></p>";
		if($this->input->post("email"))
		{
			$user_email = $this->input->post('email');
			$site_email = "bet@zinteo.com";
			$bcc1_email = "toni@tztdevelop.com";
			$mail_subject = $this->input->post('subject');
			$mail_content = $this->input->post('message');
			
			require_once 'application/helpers/class.phpmailer.php';
			$mail = new PHPMailer(TRUE);
			try {
				$mail->IsSMTP();
				$mail->Host = 'skopje.mk-host4.com';
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->Username = 'bet@zinteo.com';
				$mail->Password = '5qo^sa@_ri?&';
				$mail->SMTPSecure = 'ssl';
				$mail->IsHTML(true);
				
				$mail->From = 'bet@zinteo.com';
				$mail->FromName = 'Zinteo';
				$mail->AddAddress($user_email, '');
				//$mail->AddCC('cc@example.com');
				$mail->AddBCC($bcc1_email);
			
				$mail->WordWrap = 50;
				$mail->IsHTML(true);
			
				$mail->Subject = $mail_subject;
				$mail->Body = html_entity_decode($mail_content);
			
				if(!$mail->Send()) {
					$data['error'] = $mail->ErrorInfo;
				}
				else
					$data['error'] = "The message was sent to your friend";
			}
			catch (phpmailerException $e) {
				$data['error'] = $e->errorMessage();
			}
			catch (Exception $e) {
				$data['error'] = $e->getMessage();
			}
		}
		$this->load->view("public_template", $data);
	}
}