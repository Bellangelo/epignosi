<?php

namespace App\Api;

/**
 * Contains error messages about vacations.
 */
class VacationsResponse extends Response
{
    /**
     * Start date is later than end date error message.
     * 
     * @var string
     */
    const MESSAGE_START_DATE_IS_LATER = 'Start date cannot be after the end date.';

    /**
     * Date cannot be in the past error message.
     * 
     * @var string
     */
    const MESSAGE_DATE_CANNOT_BE_IN_THE_PAST = 'Date cannot be in the past.';

    /**
     * Start day cannot be today error message.
     * 
     * @var string
     */
    const MESSAGE_START_CANNOT_BE_TODAY = 'Start date cannot be the current day.';
}