<?php

class Validation{


    public function validate($required_fields, $fields){
        $errorMessage = NULL;

        print_r( $required_fields);
        print_r( $fields);

        foreach($required_fields as $key => $value) {
           if(!isset($fields[$value])){

             print_r($fields[ $key]);
             $errors[$key] = $required_fields[$key];
           }
        }

        if(!empty($errors)) {
            
            foreach($errors as $value) {         
               $errorMessage .=  $value . ", ";
            }
            $errorMessage .= " these fields are required";

            throw new Exception($errorMessage);

        }
    }
}