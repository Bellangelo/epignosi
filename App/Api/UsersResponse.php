<?php

namespace App\Api;

/**
 * Contains error messages about users.
 */
class UsersResponse extends Response
{
    /**
     * User does not exist error message.
     * 
     * @var string
     */
    const MESSAGE_USER_DOES_NOT_EXIST = 'The specific user does not exist.';

    /**
     * Incorrect password error message.
     * 
     * @var string
     */
    const MESSAGE_INCORRECT_PASSWORD = 'Wrong password.';

    /**
     * Password mismatch error message.
     * 
     * @var string
     */
    const MESSAGE_PASSWORD_MISMATCH = 'Passwords are not the same.';

    /**
     * Email already exists error message.
     * 
     * @var string
     */
    const MESSAGE_EMAIL_ALREADY_EXISTS = 'Email already exists.';

    /**
     * Invalid email error message.
     * 
     * @var string
     */
    const MESSAGE_INVALID_EMAIL = 'Invalid email.';
}