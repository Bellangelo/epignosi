<?php

namespace App;

use App\Authentication\Auth;

/**
 * Main class that includes all the important files.
 */
class App
{
    /**
     * Database server
     * 
     * @var string
     */
    private const DB_SERVER = 'localhost';

    /**
     * Database user
     * 
     * @var string
     */
    private const DB_USER = 'root';

    /**
     * Database user password.
     * 
     * @var string|null
     */
    private const DB_PASS = '';

    /**
     * Database to connect
     * 
     * @var string|null
     */
    private const DB_DATABASE = 'epignosi';

    /**
     * Database class.
     * 
     * @var DatabaseConnection
     */
    protected $databaseConnectionClass;

    /**
     * Authentication class.
     * 
     * @var Auth
     */
    protected $authClass;

    /**
     * Database connection.
     * 
     * @var mysqli
     */
    protected $dbConnection;

    public function __construct()
    {
        $this->databaseConnectionClass = new DatabaseConnection( self::DB_SERVER, self::DB_USER, 
            self::DB_PASS, self::DB_DATABASE );
        $this->dbConnection = $this->databaseConnectionClass->getConnection();
        $this->authClass = new Auth( $this->dbConnection );
    }

    /**
     * Returns the authentication class.
     * 
     * @return Auth
     */
    public function getAuth()
    {
        return $this->authClass;
    }

    /**
     * Returns the database connection.
     * 
     * @return mysqli
     */
    public function getDatabaseConnection()
    {
        return $this->dbConnection;
    }

}