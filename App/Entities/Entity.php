<?php

namespace App\Entities;

/**
 * Main interface that Entities should implement.
 * It is used to have the same functionality across all Entities.
 */
interface Entity
{
    /**
     * Inserts the entity.
     */
    public function insert();

    /**
     * Updates the entity.
     * 
     * @param array $values
     * @param array $where
     */
    public function update( $values, $where );

    /**
     * Set a value in the entity.
     * 
     * @param string $key
     * @param mixed $value
     */
    public function set( $key, $value );

}