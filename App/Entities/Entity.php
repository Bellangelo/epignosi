<?php

/**
 * Main interface that Entities should implement.
 * It is used to have the same functionality across all Entities.
 */
interface Entity
{
    /**
     * Table name that stores the users.
     * 
     * @var string
     */
    protected $tableName;

    /**
     * Stores the database connection.
     */
    protected $dbConnection;

    /**
     * The entity that the class is responsible for.
     * 
     * @var array
     */
    protected $entity;

    /**
     * Inserts the entity.
     */
    public function insert();

    /**
     * Updates the entity.
     */
    public function update();

    /**
     * Set a value in the entity.
     */
    public function set();

}