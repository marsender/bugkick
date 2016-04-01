<?php

/**
 * Class to send emails using php mail
 */
class PhpMail implements Mail
{

	/**
	 *
	 * @param string $from
	 * @param array|string $to (by default to admin)
	 * @param string $body
	 * @param string $subject
	 * @return bool true if message is sent else false
	 */
	public function send($to, $from = '', $subject = '', $body = '', $reply_to = null)
	{
		if (empty($from)) {
			$from = Yii::app()->params['adminEmail'];
		}

		$headers = '';
		if (!empty($reply_to)) {
			$headers .= "Reply-To: $reply_to\r\n";
		}
		$headers .= "From: $from\r\n";

		$res = @mail($to, $subject, $message, $headers);

		return $res;
	}
}
