<?php

namespace App\Mail;

use App\Security\Security;

/**
 * Handles the notification of a vacation submission.
 */
class VacationSubmissionNotification extends Mail implements MailInterface
{
    /**
     * Endpoint for approving a vacation.
     * 
     * @var string
     */
    const APPROVE_ENDPOINT = 'http://localhost/epignosi/actions/approve-vacation.php?id=';

    /**
     * Endpoint for rejecting a vacation.
     * 
     * @var string
     */
    const REJECT_ENDPOINT = 'http://localhost/epignosi/actions/reject-vacation.php?id=';

    /**
     * Subject
     * 
     * @var string
     */
    const EMAIL_SUBJECT = 'New vacation submission.';

    /**
     * Construct function.
     * 
     * @param string $userName
     * @param string $vacationStart
     * @param string $vacationEnd
     * @param string $vacationReason
     * @param string $vacationId
     */
    public function __construct( $userName, $vacationStart, $vacationEnd, $vacationReason, $vacationId )
    {
        $this->subject = self::EMAIL_SUBJECT;
        $this->message = $this->createMessage( $userName, $vacationStart, $vacationEnd, $vacationReason, $vacationId );
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
     * @param string $userName
     * @param string $vacationStart
     * @param string $vacationEnd
     * @param string $vacationReason
     * @param string $vacationId
     * @return string $message
     */
    private function createMessage ( $userName, $vacationStart, $vacationEnd, $vacationReason, $vacationId )
    {
        $security = new Security();
        $userName = $security->preventXSS( $userName );
        $vacationStart = $security->preventXSS( $vacationStart );
        $vacationEnd = $security->preventXSS( $vacationEnd );
        $vacationReason = $security->preventXSS( $vacationReason );
        $vacationId = $security->preventXSS( $vacationId );

        $approveLink = '<a href="' . self::APPROVE_ENDPOINT . $vacationId . '">Approve</a>';
        $rejectLink = '<a href="' . self::REJECT_ENDPOINT . $vacationId . '">Reject</a>';
        $message = 'Dear supervisor, employee ' . $userName . ' requested for some time off, starting on
            ' . $vacationStart . ' and ending on ' . $vacationEnd . ', stating the reason:
            ' . $vacationReason . '
            Click on one of the below links to approve or reject the application:
            ' . $approveLink . ' - ' . $rejectLink;

        return $message;
    }
}