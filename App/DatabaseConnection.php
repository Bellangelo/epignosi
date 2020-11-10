<?php

namespace App;

/**
 * Handles the connection with the database.
 */
class DatabaseConnection
{
    /**
     * Stores the connection to the database.
     */
    protected $dbConnection;

    /**
     * Conctuct function of the class.
     * 
     * @param string $server
     * @param string $user
     * @param string $password
     * @param string $database
     */
    public function __construct( $server, $user, $password = null, $database = null )
    {
        $this->createConnection( $server, $user, $password, $database );
    }

    /**
     * Creates a connection with the database.
     * 
     * @param string $server
     * @param string $user
     * @param string $password
     * @param string $database
     */
    public function createConnection( $server, $user, $password = null, $database = null )
    {
        $this->dbConnection = mysqli_connect( $server, $user, $password, $database );
    }

    /**
     * Returns the current database connection.
     */
    public function getConnection()
    {
        return $this->dbConnection;
    }
}