<?php

namespace Config;

//A trait containing helper functions
trait Utilities
{    
     /*
        It returns an associative array with 3 key value pairs: column, expression, value.
        E.g. ["column" => "id", "expression" => >, "value" => "3"]
     */
     public function conditionAssoc($condition) {
          
        //All the sql comparing expressions
          $comparingExpression = '/[=<>!]{1,2}|<>|!=|>=|<=/';
          $expression = "";
          /*
              We execute the regex, and if it matches, it returns an array that contains
              the first character that matches the pattern. 
          */
          if(preg_match($comparingExpression, $condition, $matches)) {

                  //The comparing expression found will be saved in a variable
                  $expression = $matches[0]; 

                  //we split string before and after comparison expression
                  $conditionParts = explode($expression, $condition);

                  //we remove all the white spaces 
                  $conditionParts[0] = trim($conditionParts[0]);
                  $conditionParts[1] = trim($conditionParts[1]);
                  
                  /*
                      If the expression exists twice or more in the statement, we still need only
                      3 parts, the column, the initial expression and the value.
                  */
                  if(count($conditionParts) > 2 ) {
                      
                      for($i = 1; $i < count($conditionParts); $i++) {

                          $conditionParts[1] .= $expression.$conditionParts[$i];
                      }
                  }

                  //if the string contains only numeric values, we convert it to integer
                  //to match the type in the database.
                  $conditionParts[1] = is_numeric($conditionParts[1]) ? intval($conditionParts[1]) : $conditionParts[1];

                  $conditionAssociativeArray = ["column" => $conditionParts[0], "expression" => $expression, "value" => $conditionParts[1]];

                  return $conditionAssociativeArray;
            }
        }
}