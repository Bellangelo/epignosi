<?php

namespace App\Mail;

/**
 * Handler for email.
 */
class Mail
{
    /**
     * Message to send.
     * 
     * @var string
     */
    protected $message;

    /**
     * Email recipient
     * 
     * @var string
     */
    protected $recipient;

    /**
     * Email subject.
     * 
     * @var string
     */
    protected $subject;

    /**
     * Email headers
     * 
     * @var array
     */
    protected $headers = [];

    /**
     * Sends email.
     * 
     * @return boolean
     */
    protected function sendEmail ()
    {
        return @mail( $this->recipient, $this->subject, $this->message, $this->headers );
    }

}

?>