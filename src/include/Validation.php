<?php
class Validation{


    public function envCheck(){
        
        $neededKeys = unserialize(ENV_VARIABLES);

        $missingVariable = [];
        foreach ($neededKeys as $key) {
            if (!array_key_exists($key, $_ENV)) {
                $missingVariable[] = $key . ' is not set';
            }
        }
    
        if (count($missingVariable) > 0) {
            
            throw new Exception(json_encode($missingVariable));
            exit();
        }
    }

    public function validate($required_fields, $fields){
        $errorMessage = NULL;

        foreach($required_fields as $key => $value) {
           if(!isset($fields[$value])){
             $errors[$key] = $required_fields[$key];
           }
        }

        if(!empty($errors)) {
            
            foreach($errors as $value) {         
               $errorMessage .=  $value . ", ";
            }
            $errorMessage .= " field is required";

            throw new Exception($errorMessage);

        }
    }
}