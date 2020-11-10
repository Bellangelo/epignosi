<?php

namespace App;

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
    protected $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = new DatabaseConnection( self::DB_SERVER, self::DB_USER, 
            self::DB_PASS, self::DB_DATABASE );
    }
}