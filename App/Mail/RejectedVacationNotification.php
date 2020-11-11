<?php

namespace App\Mail;

use App\Security\Security;

/**
 * Handles the notification of a rejected vacation submission.
 */
class RejectedVacationNotification extends Mail implements MailInterface
{
    /**
     * Subject
     * 
     * @var string
     */
    const EMAIL_SUBJECT = 'Rejected Vacation.';

    /**
     * Construct function.
     * 
     * @param string $vacationCreated
     */
    public function __construct( $vacationCreated )
    {
        $this->subject = self::EMAIL_SUBJECT;
        $this->message = $this->createMessage( $vacationCreated );
    }

    /**
     * Sends the email.
     * 
     * @param string $email
     * @return boolean
     */
    public function send( $email )
    {
        $this->recipient = $email;
        return $this->sendEmail();
    }

    /**
     * Create the message body.
     * 
     * @param string $vacationCreated
     * @return string $message
     */
    private function createMessage ( $vacationCreated )
    {
        $security = new Security();
        $vacationCreated = $security->preventXSS( $vacationCreated );

        $message = 'Dear employee, your supervisor has rejected your application
            submitted on ' . $vacationCreated . '.';

        return $message;
    }
}