<?php

namespace App\Entities;

/**
 * Abstraction to handle a token in the database.
 */
class Tokens extends EntityFunctionality
{
    /**
     * Table name that contains the tokens.
     */
    const TABLE_NAME = 'tokens';

    /**
     * Column id.
     * 
     * @var string 
     */
    const COLUMN_ID = 'id';

    /**
     * Column user id.
     * 
     * @var string 
     */
    const COLUMN_USER_ID = 'user_id';

    /**
     * Column token.
     * 
     * @var string 
     */
    const COLUMN_TOKEN = 'token';

    /**
     * Column created.
     * 
     * @var string 
     */
    const COLUMN_CREATED = 'created';

    /**
     * Column expires.
     * 
     * @var string 
     */
    const COLUMN_EXPIRES = 'expires';

    /**
     * Default user values.
     * 
     * @var array
     */
    const DEFAULT_TOKEN_VALUES = [
        self::COLUMN_USER_ID => null,
        self::COLUMN_TOKEN => null,
        self::COLUMN_CREATED => null,
        self::COLUMN_EXPIRES => null
    ];

    /**
     * Construct function.
     * 
     * @param mysqli $dbConnection
     */
    public function __construct( $dbConnection )
    {
        parent::__construct( $dbConnection, self::TABLE_NAME, self::DEFAULT_TOKEN_VALUES );
    }

}