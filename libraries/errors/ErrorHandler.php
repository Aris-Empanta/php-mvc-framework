<?php

namespace Libraries\Errors;

class ErrorHandler
{
    public static function handleNonFatalErrors($errorNumber, $errorMessage, $errorFile, $errorLine){
        
        // We clean the output buffer in order to render the error page below.
        ob_clean();
        
        /*
            We sanitise the error message to avoid pontential Cross Site Scripting attacks.
            ENT_QUOTES is used as the second parameter, which ensures that both single and double 
            quotes are converted to their respective HTML entities. The third parameter, 'UTF-8', 
            specifies the character set as UTF-8, which is commonly used for web applications.
        */
        $errorMessage = htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8');
        $error = error_get_last();       

        $errorsLog = dirname(dirname(__DIR__)). '/logs/errors.txt';

        $writeToFile = fopen($errorsLog, 'w');

        fwrite($writeToFile, $error['message'] );

        fclose($writeToFile);
    }

    public static function handleFatalErrors() {
        $error = error_get_last();
        
        //We handle all the errors that a common error handler cannot handle, like fatal errors
        if ($error !== null && 
             in_array($error['type'], 
             [E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, 
             E_COMPILE_ERROR, E_COMPILE_WARNING])) 
        {
            // We clean the output buffer in order to render the error page below.
            ob_clean();
            // Do your stuff
             echo $error;
        }
    }
}