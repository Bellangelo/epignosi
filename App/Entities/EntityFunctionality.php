<?php

namespace App\Entities;

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
     * Allowed to be empty columns.
     * 
     * @var array
     */
    protected $allowedToBeEmptyColumns = [];

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
     * Stores the entity in the database. On success, it returns the created row id.
     * 
     * @return boolean|integer
     */
    public function insert()
    {
        $this->validateEntity();
        $sql = $this->createInsertSQL( $this->entity );
        $query = mysqli_query( $this->dbConnection, $sql );

        if ( !$query ) {
            return $query;
        }

        return mysqli_insert_id( $this->dbConnection );
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
     * Selects from database based on parameters.
     * 
     * @param array $values
     * @param string|int|null $limit
     * @param array $returnValues
     * @param string $orderBy
     * @return array $results
     * @throws Exception
     */
    public function find( $values = '', $limit = null, $returnValues = null, $orderBy = null )
    {
        $results = [];
        // Validate keys.
        if ( !empty( $values ) ) {

            foreach ( $values as $key => $value ) {
                $this->validateKey( $key );
            }

        }

        // Validate returned values.
        if ( !empty( $returnValues ) ) {

            foreach ( $returnValues as $value ) {
                $this->validateKey( $value );
            }

        }

        $sql = $this->createSelectSQL( $values, $limit, $returnValues, $orderBy );
        $query = mysqli_query( $this->dbConnection, $sql );
        
        if ( !$query ) {
            throw new \Exception ( 'Database error.' );
        }

        while( $data = mysqli_fetch_assoc( $query ) ) {
            $results[] = $data;
        }

        return $results;
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
     * @return string $sql
     */
    private function createInsertSQL( $entity )
    {
        $sql = 'INSERT INTO ' . $this->tableName;
        $columns = '';
        $values = '';

        foreach ( $entity as $key => $value ) {
            $columns .= ',`' . $key . '`';
            $values .= ',"' . mysqli_real_escape_string( $this->dbConnection, $value ) . '"';
        }
        // Remove the first comma.
        $columns = substr( $columns, 1 );
        $values = substr( $values, 1 );

        $sql .= ' (' . $columns . ') VALUES (' . $values . ')';
        return $sql;
    }

    /**
     * Builds the sql update query based on the passed values.
     * 
     * @param string|int $entityId
     * @param array $values
     * @param array $where
     * @return string
     */
    private function createUpdateSQL( $values, $where )
    {
        $sql = 'UPDATE ' . $this->tableName . ' SET ';
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
     * Builds the sql select query based on params.
     * 
     * @param array $values
     * @param string|int|null $limit
     * @param array $returnValues
     * @param string $orderBy
     * @return string
     */
    private function createSelectSQL( $values = '', $limit = null, $returnValues = null, $orderBy = null )
    {
        $returnValuesSQL = '';
        $limitSQL = '';
        $whereSQL = '';
        $orderBySQL = '';
        
        // Create returned values sql.
        if ( !empty( $returnValues ) ) {

            foreach( $returnValues as $value ) {
                $returnValuesSQL .= ',`' . mysqli_real_escape_string( $this->dbConnection, $value ) . '`';
            }
            // Remove first comma.
            $returnValuesSQL = substr( $returnValuesSQL, 1 );

        }
        else {
            $returnValuesSQL = '*';
        }

        // Create the limit sql.
        if ( !empty( $limit ) ) {
            $limitSQL = ' LIMIT ' . mysqli_real_escape_string( $this->dbConnection, $limit );
        }

        // Create the where sql.
        $whereSQL = empty( $values ) ? '1=1' : $this->arrayToWhere( $values );

        // Create order by sql.
        if ( !empty( $orderBy ) ) {
            $orderBySQL = ' ORDER BY ' . mysqli_real_escape_string( $this->dbConnection, $orderBy );
        }

        $sql = 'SELECT ' . $returnValuesSQL . ' FROM ' . $this->tableName . '
            WHERE ' . $whereSQL . ' ' . $orderBySQL . ' ' . $limitSQL;
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

            if ( array_key_exists( $key, $entity ) && !in_array( $entity[ $key ], $values ) ) {
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
        foreach ( $entity as $key => $value ) {
            if ( empty( $value ) && !in_array( $key, $this->allowedToBeEmptyColumns ) ) {
                throw new \Exception ( 'Column "' . $key . '" cannot be empty.' );
            }
        }

        return true;
    }

}