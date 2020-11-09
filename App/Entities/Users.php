<?php

/**
 * Abstraction to handle a user in the database.
 */
class Users extends EntityFunctionality implements Entity
{
    /**
     * Table name that contains the users.
     */
    const TABLE_NAME = 'users';

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
     * Construct function.
     * 
     * @param mysqli $dbConnection
     */
    public function __construct( $dbConnection )
    {
        parent::__construct( $dbConnection, self::TABLE_NAME, self::DEFAULT_USER_VALUES );
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