<?php
/**
 * Class to send emails using SwiftMail
 */
class SwiftMail implements Mail
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
		// Load library
		$libraryPath = isset(Yii::app()->params['swiftMailSettings']['libraryPath']) ? Yii::app()->params['swiftMailSettings']['libraryPath'] : null;
		if (empty($libraryPath)) {
			return false;
		}
		require_once($libraryPath . '/lib/Swift.php');
		require_once($libraryPath . '/lib/Swift/Connection/SMTP.php');

		// Set host
		$smtpHost = isset(Yii::app()->params['swiftMailSettings']['smtpHost']) ? Yii::app()->params['swiftMailSettings']['smtpHost'] : 'localhost';

		if (empty($from)) {
			$from = Yii::app()->params['adminEmail'];
		}
		$tabRecipient = array($to);

		$res = $this->SendMail($smtpHost, $from, $tabRecipient, $subject, null, $body);

		return $res;
	}

	/**
	 * Send text / html mail
	 *
	 * @param string From email
	 * @param array Recipient email list
	 * @param string Subject
	 * @param string Text content
	 * @param string Html content
	 * @param array Attachment list
	 * @param array Embed list
	 *
	 * @return bool true if mail is sent, else false
	 */
	private function SendMail($inSmtpHost, $inSendFrom, $inTabRecipient, $inSubject,
		$inMessageTxt = null, $inMessageHtml = null, $inTabAttachment = null, $inTabEmbed = null)
	{
		try {
			// Create the smtp connexion
			$smtp = new Swift_Connection_SMTP($inSmtpHost);
			// Connect to smtp server on port 25
			$swift = new Swift($smtp);

			// Create swift message
			$message = new Swift_Message($inSubject);

			// Use disk caching
			Swift_CacheFactory::setClassName('Swift_Cache_Disk');
			Swift_Cache_Disk::setSavePath();

			// Build html content
			if (isset($inMessageHtml)) {
				$inMessageHtml = html_entity_decode($inMessageHtml, ENT_COMPAT, 'utf-8');
			}

			// Build text content if needed
			if (isset($inMessageTxt)) {
				$textContent = $inMessageTxt;
			}
			else {
				$search = array(
					"\t",
					"\r",
					"\n",
					'<br/>',
					'<br />',
					'</p>',
					'</li>'
					);
					$replace = array(
					'',
					'',
					'',
					"\n",
					"\n",
					"\n",
					"\n"
					);
					$textContent = str_replace($search , $replace, $inMessageHtml);
					$textContent = strip_tags($textContent);
			}

			// Add embeded images
			if (isset($inTabEmbed)) {
				$search = array();
				$replace = array();
				foreach ($inTabEmbed as $value) {
					$path = $value['path']; // Full file name
					$pattern = $value['pattern']; // Full file name
					$img = $value['img']; // Full file name
					$swiftFile = new Swift_File($path);
					$swiftImage = new Swift_Message_Image($swiftFile);
					$imgSrc = $message->attach($swiftImage);
					$search[] = sprintf($pattern, $img);
					$replace[] = sprintf($pattern, $imgSrc);
				}
				$inMessageHtml = str_replace($search, $replace, $inMessageHtml);
			}

			// Add textual parts
			$messageTxt = new Swift_Message_Part($textContent, 'text/plain', '8bit', 'utf-8');
			if (isset($inMessageHtml)) {
				$messageHtml = new Swift_Message_Part($inMessageHtml, 'text/html', '8bit', 'utf-8');
				//$messageCss = new Swift_Message_Part('body { color: #2F4769; } p { margin : 0;}', 'text/css', '8bit', 'utf-8');
			}

			// Create the multipart message
			$message->attach($messageTxt, 'id_message_txt');
			if (isset($inMessageHtml)) {
				$message->attach($messageHtml, 'id_message_html');
				//$message->attach($messageCss);
			}

			// Add attachments
			if (isset($inTabAttachment)) {
				foreach ($inTabAttachment as $value) {
					if (!is_array($value) || empty($value['path']) || empty($value['name'])) {
						$error = 'Incorrect attachment info';
						throw new Exception($error);
					}
					$path = $value['path']; // Full file name
					$name = $value['name']; // File name only
					$type = $value['type']; // Ex: text/plain
					switch ($type) {
					case 'message/rfc822':
						$encoding='7bit';
						break;
					default:
						$encoding='base64';
						break;
					}
					$swiftFile = new Swift_File($path);
					$swiftAttachment = new Swift_Message_Attachment($swiftFile, $name, $type, $encoding);
					$message->attach($swiftAttachment);
				}
			}

			// Init the sender (from email and name)
			$sender = null;
			if (is_string($inSendFrom)) {
				$sender = new Swift_Address($inSendFrom);
			}
			else if (is_array($inSendFrom) || count($inSendFrom) != 1) {
				foreach ($inSendFrom as $name => $email) {
					$sender = new Swift_Address($email, $name);
				}
			}
			if (!isset($sender)) {
				$error = 'Incorrect sender adress';
				throw new Exception($error);
			}

			// Add the recipients
			// Note that Cc and Bcc recipients are ignored in a batch send
			$recipients = new Swift_RecipientList();
			foreach ($inTabRecipient as $key => $value) {
				if ((int)$key === $key) {
					$recipients->addTo($value); // email
				}
				else {
					$recipients->addTo($value, $key); // email - name
				}
			}

			// Init log
			$log = Swift_LogContainer::getLog();
			$log->setLogLevel(Swift_Log::LOG_FAILURES); // LOG_FAILURES LOG_EVERYTHING

			// Create the batch mailer
			//   http://swiftmailer.org/wikidocs/v3/sending/batch
			$batch = new Swift_BatchMailer($swift);
			$batch->setMaxTries(2); // Setting the maximum retries
			$batch->setMaxSuccessiveFailures(3); // Setting the maximum successive failure allowance
			$batch->setSleepTime(5); // Sleep for x seconds if an error occurs

			// Send mail
			$nbSent = $batch->send($message, $recipients, $sender);

			// Check errors
			$swiftError = $log->dump(true);
			if (!empty($swiftError)) {
				//throw new Exception($swiftError);
				return false;
			}
			$arrayFailed = $batch->getFailedRecipients();
			if (count($arrayFailed)) {
				$error = sprintf('Swift Mailer failed recipients: %s', print_r($arrayFailed, true));
				//throw new Exception($error);
				return false;
			}
			if ($nbSent != count($inTabRecipient)) {
				$error = sprintf('Swift Mailer incorrect recipient count: %s', print_r($inTabRecipient, true));
				//throw new Exception($error);
				return false;
			}
		}
		catch (Exception $e) {
			$error = $e->getMessage();
			throw new Exception($error);
		}

		return true;
	}
}
