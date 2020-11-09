<?php

/**
 * Abstraction to handle a user in the database.
 */
class Users implements Entity
{
    /**
     * Default user values.
     * 
     * @var array
     */
    const DEFAULT_USER_VALUES = [
        'id' => null,
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'user_type' => null,
        'password' => null,
    ];

    /**
     * Table name that stores the users.
     * 
     * @var string
     */
    protected $tableName = 'users';

    /**
     * Stores the database connection.
     */
    protected $dbConnection;

    /**
     * Stores a user as an array.
     * 
     * @var array
     */
    protected $entity = self::DEFAULT_USER_VALUES;

    /**
     * Construct function.
     * 
     * @param mysqli $dbConnection
     */
    public function __construct( $dbConnection )
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Stores a user in the database.
     */
    public function insert()
    {

    }

    /**
     * Updates a user in the database.
     */
    public function update()
    {

    }

    /**
     * Sets a value of the stored user in the class.
     */
    public function set()
    {
        
    }

}