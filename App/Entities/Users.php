<?php

namespace App\Entities;

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
     * Admin user type.
     * 
     * @var string
     */
    const USER_TYPE_ADMIN = 'admin';

    /**
     * Employee user type.
     * 
     * @var string
     */
    const USER_TYPE_EMPLOYEE = 'employee';

    /**
     * Entity specific values.
     * 
     * @var array
     */
    protected $entitySpecificValues = [
        self::COLUMN_USER_TYPE => [ self::USER_TYPE_EMPLOYEE, self::USER_TYPE_ADMIN ]
    ];

    /**
     * Allowed to be empty columns.
     * 
     * @var array
     */
    protected $allowedToBeEmptyColumns = [
        self::COLUMN_ID,
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
     * Verify password.
     * 
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public function verifyPassword ( $password, $hash )
    {
        return password_verify( $password, $hash );
    }

    /**
     * Creates a hash.
     * 
     * @param string $password.
     * @return string
     */
    public function createHash ( $password )
    {
        $options = [
            'cost' => 12,
        ];
        return password_hash( $password, PASSWORD_BCRYPT, $options );
    }

}