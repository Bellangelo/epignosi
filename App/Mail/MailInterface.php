<?php

namespace App\Mail;

/**
 * Basic mail interface for all emails.
 */
interface MailInterface
{
    /**
     * Sends the email.
     * 
     * @param string $email
     */
    public function send( $email );
}

?>