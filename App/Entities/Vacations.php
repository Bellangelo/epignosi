<?php

/**
 * Abstraction to handle a vacation in the database.
 */
class Vacations extends EntityFunctionality implements Entity
{
    /**
     * Table name that contains the vacations.
     */
    const TABLE_NAME = 'vacations';

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
     * Column start date.
     * 
     * @var string 
     */
    const COLUMN_START_DATE = 'start_date';

    /**
     * Column end date.
     * 
     * @var string 
     */
    const COLUMN_END_DATE = 'end_date';

    /**
     * Column status.
     * 
     * @var string 
     */
    const COLUMN_STATUS = 'status';

    /**
     * Column reason.
     * 
     * @var string 
     */
    const COLUMN_REASON = 'reason';

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
    const DEFAULT_VACATION_VALUES = [
        self::COLUMN_ID => null,
        self::COLUMN_USER_ID => null,
        self::COLUMN_START_DATE => null,
        self::COLUMN_END_DATE => null,
        self::COLUMN_STATUS => null,
        self::COLUMN_REASON => null,
        self::COLUMN_CREATED => null,
    ];

    /**
     * Construct function.
     * 
     * @param mysqli $dbConnection
     */
    public function __construct( $dbConnection )
    {
        parent::__construct( $dbConnection, self::TABLE_NAME, self::DEFAULT_VACATION_VALUES );
    }

    /**
     * Stores a vacation in the database.
     */
    public function insert()
    {

    }

    /**
     * Updates a vacation in the database.
     */
    public function update()
    {

    }

    /**
     * Sets a value of the stored vacation in the class.
     */
    public function set()
    {
        
    }

}