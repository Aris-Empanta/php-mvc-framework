<?php

class DbHandler extends DbConnection
{
    use Utilities;
    
    public function getAllData($table)
    {
        $connection = $this->dbConnection;
        $sql = "SELECT * FROM $table";
        $stmt= $connection->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll(); // Fetch all rows from the executed query
    
        return $result; // Return the fetched data   
    }

    public function getDataByCondition($table, $condition)
    {
        $connection = $this->dbConnection;

        //we save the condition parts (column expression and value e.p. id > 3) in an associative array variable.
        $conditionAssoc = $this->conditionAssoc($condition);

        $column = $conditionAssoc["column"];
        $expression = $conditionAssoc["expression"];
        $value = $conditionAssoc["value"];

        //We construct the condition part of the where statement.
        $conditionString = " $column $expression :$column";

        $sql = "SELECT * FROM $table WHERE $conditionString";
        
        $stmt= $connection->prepare($sql);
                
        //We create an associative array with all the data that will be binded to the query
        $data =  [$column=>$value];
        
        //We execute the query
        $stmt->execute($data);

        $result = $stmt->fetchAll(); // Fetch all rows from the executed query
    
        print_r($result); // Return the fetched data 
    }

    public function saveData($table, $data = [])
    {
        $connection = $this->dbConnection;

        $columnsArray = array_keys($data);

        $columnsString = implode(", ", $columnsArray);
       
        $columnsString = trim($columnsString, ", ");

        $preparedStatementValues = "";

        foreach($columnsArray as $preparedStatementValue) {

            $preparedStatementValues .= " :".$preparedStatementValue.",";
        }

        $preparedStatementValues = trim($preparedStatementValues, ",");

        $sql = "INSERT INTO $table ($columnsString) 
                VALUES ($preparedStatementValues)";

        $stmt= $connection->prepare($sql);
        $stmt->execute($data);
    }

    public function updateByCondition($table, $data = [], $condition)
    {
        try{
                $connection = $this->dbConnection;

                //the columns' names that will be modified
                $columns = array_keys($data);

                //the part of the query that will mention the columns to be updated
                $updateString = "";

                //Constructing the above mentioned part
                foreach($columns as $column) {
                        $updateString .= " $column = :$column,";
                }
                //removing comma from the end
                $updateString = trim($updateString,",");

                //we save the condition parts (column expression and value e.p. id > 3) in an associative array variable
                $conditionAssoc = $this->conditionAssoc($condition);

                $column = $conditionAssoc["column"];
                $expression = $conditionAssoc["expression"];
                $value = $conditionAssoc["value"];

                //We construct the condition part of the where statement.
                $conditionString = " $column $expression :$column";

                //The query to be used in the prepare statement.
                $sql =  "UPDATE $table
                        SET $updateString
                        WHERE $conditionString";

                $stmt= $connection->prepare($sql);
                
                //We create an associative array with all the data that will be binded to the query
                $allData =  array_merge($data, [$column=>$value]);
                
                //We execute the query
                $stmt->execute($allData);
            }      
            catch (PDOException $e) {

                echo "Error executing query: " . $e->getMessage();
            }          
    }

    public function deleteDataByCondition($table, $condition) {

        $connection = $this->dbConnection;

        //we save the condition parts (column expression and value e.p. id > 3) in an associative array variable.
        $conditionAssoc = $this->conditionAssoc($condition);

        $column = $conditionAssoc["column"];
        $expression = $conditionAssoc["expression"];
        $value = $conditionAssoc["value"];

        //We construct the condition part of the where statement.
        $conditionString = " $column $expression :$column";

        $sql = "DELETE FROM $table WHERE $conditionString";
        
        $stmt= $connection->prepare($sql);
                
        //We create an associative array with all the data that will be binded to the query
        $data =  [$column=>$value];
        
        //We execute the query
        $stmt->execute($data);

        $result = $stmt->fetchAll(); // Fetch all rows from the executed query
    
        print_r($result); // Return the fetched data    
    }
}