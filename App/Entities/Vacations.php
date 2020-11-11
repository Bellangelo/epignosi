<?php

namespace App\Entities;

/**
 * Abstraction to handle a vacation in the database.
 */
class Vacations extends EntityFunctionality
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
     * Pending status.
     * 
     * @var string
     */
    const STATUS_PENDING = 'pending';

    /**
     * Rejected status.
     * 
     * @var string
     */
    const STATUS_REJECTED = 'rejected';

    /**
     * Approved status.
     * 
     * @var string
     */
    const STATUS_APPROVED = 'approved';

    /**
     * Entity specific values.
     * 
     * @var array
     */
    protected $entitySpecificValues = [
        self::COLUMN_STATUS => [ self::STATUS_PENDING, self::STATUS_REJECTED, self::STATUS_APPROVED ]
    ];

    /**
     * Allowed to be empty columns.
     * 
     * @var array
     */
    protected $allowedToBeEmptyColumns = [
        self::COLUMN_ID,
        self::COLUMN_REASON,
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
     * Get diffence from 2 dates in days.
     * 
     * @param string $earlier
     * @param string $later
     * @return string
     */
    public function getDifferenceInDays( $earlier, $later )
    {
        $earlier = new \DateTime( $earlier );
        $later = new \DateTime( $later );

        return intval( $later->diff($earlier)->d ) + 1;
    }

}