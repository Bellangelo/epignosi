<?php

namespace App\Security;

/**
 * Contains methods that help to prevent attacks.
 */
class Security
{
    /**
     * Safely print data. Prevents XSS.
     * 
     * @param string $string
     */
    public function preventXSS( $string )
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

?>