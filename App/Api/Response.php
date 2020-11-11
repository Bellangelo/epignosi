<?php

namespace App\Api;

//TODO: Create a handler to catch Exception that the App does not catch so we can
// print a json response in case of error.

/**
 * Class that handles the api response.
 */
class Response 
{
    /**
     * Error type.
     * 
     * @var string
     */
    const ERROR_TYPE = 'error';

    /**
     * Success type.
     * 
     * @var string
     */
    const SUCCESS_TYPE = 'success';

    /**
     * Wrong data message.
     * 
     * @var string
     */
    const MESSAGE_WRONG_DATA = 'Wrong data.';

    /**
     * Return a json response.
     * 
     * @param string $type
     * @param array $data
     * @param string $message
     */
    public function returnJSONResponse ( $type, $data, $message = '' ) {
        
        if ( is_bool( $type ) || is_int( $type ) ) {
            $type = $type ? self::SUCCESS_TYPE : self::ERROR_TYPE;
        }

        $response = [
            'type' => $type,
            'data' => $data,
        ];

        if ( $type == self::ERROR_TYPE ) {
            $response['message'] = $message;
        }

        return json_encode( $response );

    }

}

?>