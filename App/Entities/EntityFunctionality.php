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
     * Entity specific values.
     * 
     * @var array
     */
    protected $entitySpecificValues;

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
     * 
     * @return boolean
     */
    public function insert()
    {
        $this->validateEntity();
        $sql = $this->createInsertSQL( $this->entity );
        $query = mysqli_query( $this->dbConnection, $sql );
        return $query;
    }

    /**
     * Updates the entity in the database.
     * 
     * @param array $values
     * @param array $where
     * @throws \Exception
     */
    public function update( $values, $where )
    {
        // Validate keys and values.
        foreach ( $values as $key => $value ) {
            $this->validateKey( $key );
        }

        $this->checkEntityValues( $values );
        // Validate the Where clause keys.
        foreach ( $where as $key => $value ) {
            $this->validateKey( $key );
        }

        $sql = $this->createUpdateSQL( $values, $where );
        $query = mysqli_query( $this->dbConnection, $sql );
        return $query;
    }

    /**
     * Sets a value of the entity in the class.
     * 
     * @param string $key
     * @param mixed $value
     * @throws \Exception
     */
    public function set( $key, $value )
    {
        $this->validateKey( $key );
        $this->checkEntityValues( [ $key => $value ] );
        $this->entity[ $key ] = $value;
    }

    /**
     * Checks if key exists in the entity.
     * 
     * @param string $key
     * @throws \Exception
     */
    protected function validateKey( $key )
    {
        // Check if entity contains the specific key.
        if ( !array_key_exists( $key, $this->entity ) ) {
            throw new \Exception ( 'Requested key/column does not exist in the entity.' );
        }

        return true;
    }

    /**
     * Builds the sql insert query based on the passed entity.
     * 
     * @param array $entity
     */
    private function createInsertSQL( $entity )
    {
        $sql = 'INSERT INTO `' . $this->tableName . '`';
        $columns = '';
        $values = '';

        foreach ( $entity as $key => $value ) {
            $columns .= ',`' . $key . '`';
            $values .= ',"' . mysqli_real_escape_string( $this->dbConnection, $value ) . '"';
        }
        // Remove the first comma.
        $columns = substr( $columns, 1 );
        $values = substr( $values, 1 );

        $sql .= ' ' . $columns . ' VALUES (' . $values . ')';
        return $sql;
    }

    /**
     * Builds the sql update query based on the passed values.
     * 
     * @param string|int $entityId
     * @param array $values
     * @param array $where
     */
    private function createUpdateSQL( $values, $where )
    {
        $sql = 'UPDATE `' . $this->tableName . '` SET ';
        $set = '';

        foreach ( $values as $key => $value ) {
            $set .= ',`' . $key . '` = "' . mysqli_real_escape_string( $this->dbConnection, $value ) . '"';
        }
        // Remove first comma
        $set = substr( $set, 1 );

        $sql .= $set . ' WHERE ' . $this->arrayToWhere( $where );
        return $sql; 
    }

    /**
     * Converts a array to a where statement.
     * 
     * @param array $where
     */
    private function arrayToWhere( $where )
    {
        $sql = '';

        foreach ( $where as $key => $value ) {
            $sql = ' AND `' . $key . '` = "' . mysqli_real_escape_string( $this->dbConnection, $value ) . '"';
        }
        // Remove the first 'AND'.
        $sql = substr( $sql, 4);
        return $sql;
    }

    /**
     * Validates the current entity fields.
     * 
     * @return boolean
     * @throws \Exception
     */
    protected function validateEntity()
    {
        $this->doNotAllowEmptyValues( $this->entity );
        $this->checkEntityValues( $this->entity );
    }

    /**
     * Checks that specific entity keys/columns contains specific values.
     * 
     * @param array $entity
     * @throws \Exception
     */
    protected function checkEntityValues( $entity )
    {
        if ( empty( $this->entitySpecificValues ) ) {
            return true;
        }

        foreach( $this->entitySpecificValues as $key => $values ) {

            if ( !in_array( $entity[ $key ], $values ) ) {
                throw new \Exception ( 'Column "' . $key . '" is not allowed to have the value "' . $entity[ $key ] . '"' );
            }

        }
    }

    /**
     * Checks that the entity does not contain empty values.
     * 
     * @param array $entity
     * @throws \Exception
     */
    protected function doNotAllowEmptyValues( $entity )
    {
        foreach ( $entity as $value ) {
            if ( empty( $value ) ) {
                throw new \Exception ( 'Column "' . $value . '" cannot be empty.' );
            }
        }

        return true;
    }

}