<?php

/**
 * Handles the main logic of Entities like insert, update, delete, etc.
 */
class EntityFunctionality implements Entity
{
    /**
     * Stores the database connection.
     */
    protected $dbConnection;

    /**
     * Table name that stores the users.
     * 
     * @var string
     */
    protected $tableName;

    /**
     * Stores the entity as an array.
     * 
     * @var array
     */
    protected $entity;

    /**
     * Construct function.
     * 
     * @param mysqli $dbConnection
     */
    public function __construct( $dbConnection, $tableName, $entity )
    {
        $this->dbConnection = $dbConnection;
        $this->tableName = $tableName;
        $this->entity = $entity;
    }

    /**
     * Stores the entity in the database.
     */
    public function insert()
    {

    }

    /**
     * Updates the entity in the database.
     */
    public function update()
    {

    }

    /**
     * Sets a value of the entity in the class.
     */
    public function set()
    {
        
    }

}