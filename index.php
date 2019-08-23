<?php

        //Make Your Required Checks
        header('Content-type: application/json');        

        //Store file name in a variable
        $fp = 'blog.txt';

        //Get the contents of file in array
        $conentsArray = file($fp, FILE_IGNORE_NEW_LINES);

        //Declare variables
        $blogData = array();
        $escapeLine = "---";
        $escapeLineOccurances = 0;
        $contentStartFound = false;
        $content = "";
        
        //Get the total lines except one ---
        $totalLines = count($conentsArray) - 1;
        
        foreach($conentsArray as $index=>$value)
        {
            $lineData = rtrim($value, "\r");
            $colonPosition = strpos($lineData, ":");
            $key = substr($lineData, 0, $colonPosition);
            $data = ltrim(substr($lineData, ++$colonPosition));
            
            //Check data is Empty if true the Skip
            if(empty($data)) 
            {
                continue;
            } 
            else if($data == $escapeLine) { //Check data is similar to escapeLine if true the Skip
                $escapeLineOccurances++;
                continue;
            } 
            else if(in_array($key, array("section", "preview_image"))) { //Skip Image
                continue;
            }

            //Getting long content
            if($contentStartFound) 
            {
                $content .= $data;
                if($index == $totalLines) {
                    $key = "content";
                    $data = $content;
                } else {
                    continue;
                }
            }
            
            //Gettting short content
            if($escapeLineOccurances == 2) 
            {
                $key = "short-content";
                if($data == "READMORE") {
                    $data = $content;
                    $escapeLineOccurances = 0;
                    $contentStartFound = true;
                    $content = "";
                }else{
                    $content = $data;
                }
            }
            
            //Check Tags Here
            if($key == "tags") {
                $data = explode(',', $data);
            }

            //Collect Data in array
            $blogData[$key] = $data;
        }

        //Finally print the data with JSON_PRETTY_PRINT for vertically
        echo (json_encode($blogData, JSON_PRETTY_PRINT));
        
?>