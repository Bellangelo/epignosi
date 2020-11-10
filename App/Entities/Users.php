<?php

/**
 * Abstraction to handle a user in the database.
 */
class Users extends EntityFunctionality
{
    /**
     * Table name that contains the users.
     */
    const TABLE_NAME = 'users';

    /**
     * Column id.
     * 
     * @var string 
     */
    const COLUMN_ID = 'id';

    /**
     * Column first name.
     * 
     * @var string 
     */
    const COLUMN_FIRST_NAME = 'first_name';

    /**
     * Column last name.
     * 
     * @var string 
     */
    const COLUMN_LAST_NAME = 'last_name';

    /**
     * Column email.
     * 
     * @var string 
     */
    const COLUMN_EMAIL = 'email';

    /**
     * Column user type.
     * 
     * @var string 
     */
    const COLUMN_USER_TYPE = 'user_type';

    /**
     * Column password.
     * 
     * @var string 
     */
    const COLUMN_PASSWORD = 'password';

    /**
     * Column created.
     * 
     * @var string 
     */
    const COLUMN_CREATED = 'created';

    /**
     * Default user values.
     * 
     * @var array
     */
    const DEFAULT_USER_VALUES = [
        self::COLUMN_ID => null,
        self::COLUMN_FIRST_NAME => null,
        self::COLUMN_LAST_NAME => null,
        self::COLUMN_EMAIL => null,
        self::COLUMN_USER_TYPE => null,
        self::COLUMN_PASSWORD => null,
        self::COLUMN_CREATED => null,
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

}