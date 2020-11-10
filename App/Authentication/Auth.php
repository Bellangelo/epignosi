<?php

namespace App\Authentication;

use App\Entities\Users;
use App\Entities\Tokens;
use DateTime;

/**
 * Handles the app authentication.
 */
class Auth
{
    /**
     * Cookie name that stores the user authentication token.
     * 
     * @var string
     */
    const COOKIE_NAME = 'token';

    /**
     * Cookie valid days.
     * 
     * @var integer
     */
    const COOKIE_VALID_DAYS = 10;

    /**
     * Database connection.
     * 
     * @var mysqli
     */
    protected $dbConnection;

    /**
     * Token entity.
     * 
     * @var Tokens
     */
    protected $tokenClass;

    /**
     * Current logged in user id.
     * 
     * @var string
     */
    protected $userId;

    /**
     * Construct class.
     * 
     * @param mysqli $dbConnection
     */
    public function __construct( $dbConnection )
    {
        $this->dbConnection = $dbConnection;
        $this->tokenClass = new Tokens( $dbConnection );
        $this->userId = $this->isUserLogged();
    }

    /**
     * Checks if user is logged. If it is it returns the user id.
     * 
     * @return false|int
     */
    public function isUserLogged()
    {
        if ( $this->userId ) {
            return $this->userId;
        }

        $user = $this->tokenClass->find([ Tokens::COLUMN_TOKEN => @$_COOKIE[ self::COOKIE_NAME ] ], 1, 
            [ Tokens::COLUMN_USER_ID, Tokens::COLUMN_EXPIRES ], 'id desc');

        if ( !empty( $user ) ) {
            return $user[0][ Tokens::COLUMN_USER_ID ];
        }

        return false;
        
    }

    /**
     * Returns the current user id.
     * 
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Log user in.
     * 
     * @param string $userId
     * @return boolean
     */
    public function logUser( $userId ) 
    {
        $token = $this->createAuthToken( $userId );
        $storeToken = $this->storeTokenInDatabase( $userId, $token );
        $expirirationDate = $this->getExpirationDate( new DateTime() )->getTimestamp();

        if ( $storeToken ) {
            setcookie( self::COOKIE_NAME, $token, $expirirationDate, '/', '', true, true );
            return true;
        }

        return false;
    }

    /**
     * Creates a authentication token.
     * 
     * @param string $userId
     * @return string
     */
    protected function createAuthToken( $userId )
    {
        return hash( 'sha256', ( date('YmdHis') . rand() . $userId ) );
    }

    /**
     * Stores token in database.
     * 
     * @return boolean
     */
    private function storeTokenInDatabase( $userId, $token )
    {
        $currentDatetime = new DateTime();
        $createdTime = $currentDatetime->format('Y-m-d H:i:s');
        $expiresTime = $this->getExpirationDate( $currentDatetime )->format('Y-m-d H:i:s');
        $this->tokenClass->set( Tokens::COLUMN_USER_ID, $userId );
        $this->tokenClass->set( Tokens::COLUMN_TOKEN, $token );
        $this->tokenClass->set( Tokens::COLUMN_CREATED, $createdTime );
        $this->tokenClass->set( Tokens::COLUMN_EXPIRES, $expiresTime );
        return $this->tokenClass->insert();
    }

    /**
     * Returns the expiration time.
     * 
     * @param \DateTime $date
     * @return \DateTime
     */
    private function getExpirationDate( $date )
    {
        return $date->add( new \DateInterval( 'P' . self::COOKIE_VALID_DAYS . 'D' ) );
    }

}