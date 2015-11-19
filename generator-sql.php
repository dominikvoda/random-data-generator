<?php
  
  function generateNumber($from, $to, $last = false){
    $return = rand($from, $to);
    if(!$last){
      $return .= ', ';
    }
    return $return;
  }
  
  function generateString($file, $last = false){
    $handle = fopen("data/" . $file, "r");
    $data = [];    
    $i = 0;
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $data[] = $line;
            $i++;
        }          
        fclose($handle);
    }
    $return = "'" . $data[rand(0, $i - 1)] . "'";
    if(!$last){
      $return .= ', ';
    }
    return $return;
  }
  
  function parseLipsum(){
    $handle = fopen("data/words-input.txt", "r");
    $lines = [];  
    $data = [];  
    $i = 0;
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $lines[] = $line;
        }          
        fclose($handle);
    }         

    $GLOBALS['words'] = [];
    foreach($lines as $line){
      $GLOBALS['words'] = array_merge($GLOBALS['words'], explode(" ", $line));
    }
  }
  
  function generateText($numberOfWords, $last = false){
    if(!isset($GLOBALS['words'])){
      parseLipsum();
    }
    $maxIndex = sizeof($GLOBALS['words']) - 1;
    $return = "'";
    for($i = 0; $i < $numberOfWords; $i++){
      $index = rand(0, $maxIndex);
      $return .= $GLOBALS['words'][$index];
      if(($i + 1) != $numberOfWords){
        $return .= " ";
      }
    }
    $return .= "'";
    if(!$last){
      $return .= ",";
    }
    return $return;
  }
  
  function generateNull($last = false){
    $return = "NULL"; 
    if(!$last){
      $return .= ",";
    }
    return $return;
  }
  
  function dataOrNull($generatedData, $last = false){
    if(rand(0, 1) == 0){
      $return = "NULL";         
      if(!$last){
        $return .= ",";
      }   
    }
    else{
      $return = $generatedData;
    } 
    return $return;
  }
  
  function generateFromArray($array, $last = false){
    $size = sizeof($array) - 1;
    $return = "'".$array[rand(0, $size)]."'";                       
    if(!$last){
      $return .= ",";
    } 
    return $return;
  }
  
  /**
   * generateDate('2005-01-01 7:00', '2015-10-10 15:00', "Y-m-d H:i");
   */     
  function generateDate($min, $max, $format, $last = false){
    $startDate = \Datetime::createFromFormat($format, $min);       
    $endDate = \Datetime::createFromFormat($format, $max);
    $startTimestamp = $startDate->getTimestamp();
    $endTimestamp = $endDate->getTimestamp();
    $return = "'" . date($format, rand($startTimestamp, $endTimestamp)) . "'";                     
    if(!$last){
      $return .= ",";
    } 
    return $return;
  }
  
  function generateLines($rows, $tableName){
    for($i = 0; $i < $rows; $i++){
      echo "INSERT INTO " . $tableName . " VALUES (";
      /*
      ----balik----
      echo generateText(rand(1, 10));
      echo generateNumber(1, 80);
      echo generateNumber(50, 20000);
      echo generateNumber(1, 20);
      echo generateNumber(1, 9);
      echo generateNull();
      echo dataOrNull(generateText(rand(10, 20)));
      echo "'ceka na prirazeni trasy'";   */
      
      /**
       * ---- trasa ----
       */
      echo generateNumber(20, 2000);
      echo generateDate('2005-01-01 7:00', '2015-10-10 15:00', "Y-m-d H:i");
      echo "'ceka na prirazeni ridice a automobilu',";
      echo generateNumber(11, 15);
      echo generateFromArray(['2T5 2434', '5E6 7436', '1A3 1944', '7S1 4421', 'OPA 9887'], true);
      echo ");<br>";
    }
  }   
        
  generateLines(15, "trasa");
?>