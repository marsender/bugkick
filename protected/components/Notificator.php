<?php

class Notificator
{

	private static $emailSubject = 'Notification System Bugkick';

	private static $headers = "Content-type: text/html; charset=utf-8 \r\n";

	/**
	 *
	 * @param Comment $comment
	 */
	public static function newComment(Comment $comment)
	{
		$ticketUrl = Yii::app()->params['siteUrl'] . '/' . $comment->bug->project->project_id . '/' . $comment->bug->number;

		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.newComment') . '.php', array(
			'comment' => $comment,
			'viewBugUrl' => $ticketUrl
		));
		//$subject = 'Ticket #' . $comment->bug->number . ' Comment Added by ' . $comment->user->name . ' ' . $comment->user->lname;
		$subject = Yii::t('main', 'New comment to ticket') . '#' . $comment->bug->number;
		$replyToAddress = self::getReplyToAddress($comment->bug);
		$users = User::model()->bugRelated($comment->bug)->findAll();
		if (!empty($comment->bug->owner)) {
			$users[] = $comment->bug->owner;
		}
		foreach ($users as $user) {
			// Skip the notification sending to comment initiator
			if (Yii::app()->params['skipEmailIfUserInitiator']) {
				if ($user->user_id == $comment->user_id) {
					continue;
				}
			}
			// Send instant notification
			$instNotifRes = InstantMessage::instance()->send($user->user_id, MessageType::NEW_COMMENT, $comment->bug, $ticketUrl);
			if ((is_array($instNotifRes) && !empty($instNotifRes['success'])) && Yii::app()->params['skipEmailIfNodeReceived']) {
				continue;
			}
			if (self::checkEmailPreferences($user->user_id, EmailPreference::NEW_COMMENT)) {
				self::sendEmail($user->email, '', $subject, $message, self::$headers, $replyToAddress);
			}
		}
		//	replace end
	}

	protected static function getReplyToAddress(BugBase $bug)
	{
		return 'notifications-' . $bug->id . '@bugkick.com';
	}

	public static function newBug(BugBase $bug)
	{
		$ticketUrl = Yii::app()->createAbsoluteUrl('bug/view', array('id' => $bug->number));
		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.newBug') . '.php', array(
			'bug' => $bug
		));
		$subject = Yii::t('main', 'New ticket') . '#' . $bug->number;
		$replyToAddress = self::getReplyToAddress($bug);
		$users = User::model()->bugRelated($bug)->findAll();
		foreach ($users as $user) {
			// Skip the notification sending to new bug initiator
			if (Yii::app()->params['skipEmailIfUserInitiator']) {
				if ($user->user_id == Yii::app()->user->id) {
					continue;
				}
			}
			// Send instant notification
			$instNotifRes = InstantMessage::instance()->send($user->user_id, MessageType::NEW_TICKET, $bug, $ticketUrl);
			if ((is_array($instNotifRes) && !empty($instNotifRes['success'])) && Yii::app()->params['skipEmailIfNodeReceived']) {
				continue;
			}
			// Otherwise send an e-mail message to this assigned user:
			$sendResult = null;
			if ((self::checkEmailPreferences($user->user_id, EmailPreference::NEW_TICKET))) {
				$sendResult = self::sendEmail($user->email, '', $subject, $message, self::$headers, $replyToAddress);
			}
			Yii::app()->logger->saveLog(0, 'mail::newBug', "Bug #{$bug->number}", $sendResult);
		}
	}

	protected static function inviteExistingUser(User $user, Invite $invite)
	{
		self::inviteUser($user, array(
			't' => $invite->token,
			'u' => $invite->user_id,
			'p' => $invite->project_id,
			'c' => $invite->company_id
		));
		self::$emailSubject = '[' . Yii::app()->name . '] ' . User::current()->getUserName() . ' invites you to join the team for "' . Yii::app()->user->company_name . '"';
	}

	protected static function inviteNewUser(User $user)
	{
		self::inviteUser($user, array(
			't' => $user->inviteToken
		));
		self::$emailSubject = 'Invite from ' . User::current()->getUserName() . ' to join Bugkick';
	}

	protected static function inviteUser(User $user, $urlParams)
	{
		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.inviteMember') . '.php', array(
			'acceptUrl' => Yii::app()->createAbsoluteUrl('user/confirmInvite', $urlParams),
			'rejectUrl' => Yii::app()->createAbsoluteUrl('user/rejectInvite', $urlParams)
		));

		$sendResult = self::sendEmail($user->email, '', self::$emailSubject, $message, self::$headers);
		Yii::app()->logger->saveLog(Yii::app()->user->id, 'mail::newInvite', "Company - " . Yii::app()->user->company_name . ", user email - {$user->email}", $sendResult);
	}

	public static function newInvite(User $user, Invite $invite = null)
	{
		if (!empty($invite)) {
			self::inviteExistingUser($user, $invite);
		}
		else {
			self::inviteNewUser($user);
		}
	}

	public static function newRegistration(User $user)
	{
		$appName = Yii::app()->name;
		$subject = 'User Registration';
		$appUrl = Yii::app()->createAbsoluteUrl('/');
		$veryficationUrl = Yii::app()->createAbsoluteUrl('/registration/verify', array(
			't' => $user->registration_token
		));
		$message = <<<MSG
	<p>Thank you for your registration at <a href="{$appUrl}/">{$appName}</a>.</p>
	<p>Please click <a href="{$veryficationUrl}"><b>this link</b></a> to complete your registration.</p>
	<p>Best regards. {$appName}.</p>
MSG;
		$sendResult = self::sendEmail($user->email, '', $subject, $message, self::$headers);
	}

	public static function resetPassword(User $user)
	{
		$subject = 'Instructions for reset password';

		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.resetPassword') . '.php', array(
			'user' => $user
		));

		self::sendEmail($user->email, '', $subject, $message, self::$headers);
	}

	/*
	 public static function exportBug($exportFile)
	 {
	 if (file_exists($exportFile)) {
	 //Yii::app()->mailer->From = 'wei@pradosoft.com';
	 //Yii::app()->mailer->FromName = 'Wei';
	 $message = Renderer::renderInternal(
	 Yii::getPathOfAlias('application.views.mailTemplate.exportBug') . '.php'
	 );
	 Yii::app()->mailer->AddAttachment($exportFile, 'BugsList.csv');
	 Yii::app()->mailer->AddAddress(Yii::app()->user->email);
	 Yii::app()->mailer->Subject = self::$emailSubject;
	 Yii::app()->mailer->IsHTML(true);
	 Yii::app()->mailer->Body = $message;
	 Yii::app()->mailer->Send();
	 unlink($exportFile);
	 return true;
	 }
	 return false;
	 }
	 */
	public static function updateBug(BugBase $model, $changes)
	{
		//        $ch = 'New ' . $changes[0]['name'] . ': ' .  $changes[0]['value'];
		//        $subject = 'Ticket #' . $model->number . ' ' . $ch ;

		$ticketUrl = Yii::app()->createAbsoluteUrl('bug/view', array('id' => $model->number));
		$subject = Yii::t('main', 'Update to ticket') . '#' . $model->number;
		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.updateBug') . '.php', array(
			'model' => $model,
			'changes' => $changes
		));
		$replyToAddress = self::getReplyToAddress($model);
		$users = User::model()->bugRelated($model)->findAll();
		if (!empty($model->owner)) {
			$users[] = $model->owner;
		}
		foreach ($users as $user) {
			// Skip the notification sending to update initiator
			if (Yii::app()->params['skipEmailIfUserInitiator']) {
				if ($user->user_id == Yii::app()->user->id) {
					continue;
				}
			}
			// Send instant notification
			$instNotifRes = InstantMessage::instance()->send($user->user_id, MessageType::TICKET_CHANGED, $model, $ticketUrl);
			if ((is_array($instNotifRes) && !empty($instNotifRes['success'])) && Yii::app()->params['skipEmailIfNodeReceived']) {
				continue;
			}
			//send an e-mail message if user is off-line and didn't got an instant notification:
			$sendResult = null;
			if (self::checkEmailPreferences($user->user_id, EmailPreference::TICKET_UPDATE)) {
				$sendResult = self::sendEmail($user->email, '', $subject, $message, self::$headers, $replyToAddress);
			}
		}
		Yii::app()->logger->saveLog(Yii::app()->user->id, 'mail::updateBug', "Bug #{$model->number} '{$model->title}': " . serialize($changes), isset($sendResult) ? $sendResult : '');
	}

	public static function sendEmail($to, $from = '', $subject = '', $message = '', $headers = '', $reply_to = null)
	{
		$subject = Yii::app()->name . ': ' . $subject;
		$service = Yii::app()->params['emailService'];

		switch ($service) {
		case 'php':
			$phpMail = new PhpMail();
			$sent = $phpMail->send($to, $from, $subject, $message, $reply_to);
			break;
		case 'swift':
			$swiftMail = new SwiftMail();
			$sent = $swiftMail->send($to, $from, $subject, $message, $reply_to);
			break;
		case 'ses':
			$sesMail = new SESMail();
			$sent = $sesMail->send($to, $from, $subject, $message, $reply_to);
			break;
		case 'sqs':
			$sqsMail = new SQSMail();
			$res = $sqsMail->send($to, $from, $subject, $message, $reply_to);
			$sent = $res->isOK();
			break;
		default:
			$sent = true;
			break;
		}

		return $sent;
	}

	/*
	 * @param $notificationType is one of these:
	 *
	 const EmailPreference::NEW_TICKET = 1;
	 const EmailPreference::TICKET_UPDATE = 2;
	 const EmailPreference::NEW_COMMENT = 3;
	 const EmailPreference::DUE_DATE = 4;
	 *
	 * */
	public static function checkEmailPreferences($userID, $notificationType = null)
	{
		$user = User::model()->findByPk($userID);
		$currentProject = Project::getCurrent();
		$isUserBelongsToProject = Project::isProjectAccessAllowed($currentProject->project_id, $user->id);
		// Send notifications also for current user
		$isNotCurrentUser = true;
		//$isNotCurrentUser = (Yii::app() instanceof CConsoleApplication) || (Yii::app()->user->id != $userID);


		if (($user->email_notify == 1) && $isNotCurrentUser && $isUserBelongsToProject) {
			if ($notificationType) {
				if (is_array($user->emailPreferences)) {
					foreach ($user->emailPreferences as $pref) {
						if ($notificationType == $pref->email_preference_id) {
							return true;
						}
					}
				}
			}
			else {
				return true;
			}
		}
		return false;
	}

	/*
	 * @param $data array in format returned by Bug::getOutdatedTickets()
	 * */
	public static function sendDueDateNotification($data)
	{
		foreach ($data as $key => $value) {
			$user = User::model()->findByPk($key);

			foreach ($value as $ticket) {
				InstantMessage::instance()->send($key, MessageType::TICKET_DEADLINE_REACHED, $ticket, Yii::app()->params['siteUrl'] . '/' . $ticket->project->project_id . '/' . $ticket->number);
			}

			//Sending emails
			if (is_array($user->emailPreferences) && is_array($value)) {
				foreach ($user->emailPreferences as $pref) {
					if ($pref->email_preference_id == EmailPreference::DUE_DATE) {
						$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.dueDate') . '.php', array(
							'tickets' => $value,
							'name' => $user->name,
							'lname' => $user->lname
						));
						self::sendEmail($user->email, '', self::$emailSubject, $message, self::$headers);
					}
				}
			}

			Bug::markTicketsAsNotified($value);
		}
	}

	/*
	 * Notify users about outdated Stripe payment
	 * @param $customers - array of customers from {{stripe_customer}}
	 * */
	public static function outdatedPayment($customers)
	{
		$subject = 'Your Payment is Outdated';
		if (!empty($customers)) {
			foreach ($customers as $value) {
				$user = $value->user;

				$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.outdatedPayment') . '.php', array(
					'model' => $value,
					'user' => $user
				));

				self::sendEmail($user->email, '', $subject, $message, self::$headers);
			}
		}
	}

	public static function restoreUser(User $user)
	{
		$subject = 'Your account on ' . Yii::app()->name . ' was restored';
		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.restoreMember') . '.php', array(
			'user' => $user
		));
		return self::sendEmail($user->email, '', $subject, $message, self::$headers);
	}

	public static function invitePeople(User $user, $invitedUserEmail)
	{
		$subject = $user->getUserName() . ' invites you to join "' . Yii::app()->name . '"';

		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.invitePeople') . '.php', array(
			'user' => $user,
			'registerUrl' => Yii::app()->createAbsoluteUrl('/signup')
		));

		return self::sendEmail($invitedUserEmail, '', $subject, $message, self::$headers);
	}

	public static function forumMessage(BKUser $user, BKPost $post)
	{
		$subject = 'New message on Bugkick Forum';
		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.forumMessage') . '.php', array(
			'user' => $user,
			'post' => $post
		));
		return self::sendEmail($user->email, '', $subject, $message, self::$headers);
	}

	public static function successfulSubscription(User $user)
	{
		$subject = 'Successful Upgrade';
		$message = Renderer::renderInternal(Yii::getPathOfAlias('application.views.mailTemplate.plainEmail') . '.php', array(
			'user' => $user,
			'message' => 'Your Bugkick account has been successfully upgraded. Thank you for your purchase.'
		));
		return self::sendEmail($user->email, '', $subject, $message, self::$headers);
	}
}