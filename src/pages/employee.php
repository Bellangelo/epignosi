<?php

// Disallow direct access and allow only employees to view this.
if ( !@$userData || $userData['user_type'] !== App\Entities\Users::USER_TYPE_EMPLOYEE ) {
    header( 'Location: /epignosi/portal.php' );
}

?>
