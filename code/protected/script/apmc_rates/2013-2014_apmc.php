
<?php
function download_remote_file_with_curl($link,$path) {
    $ch = curl_init ();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1 );
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_POST,0);

    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);


    $res_code =curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $data = curl_exec($ch);
    echo 'link exist code=' .$code;
    echo 'res code='.$res_code;
    curl_close($ch);
    $d_f = fopen($path,'w');
    fwrite($d_f,$data);
    fclose($d_f);
}



for($i=0;$i<=750;$i++){



    $linker = mysqli_connect("localhost", "root", "Aakash24.duaa", "daily_rates");

    if (!$linker) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
      echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
      exit;
    }

    echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
    echo "Host information: " . mysqli_get_host_info($linker) . PHP_EOL;
     // connection estabilised   
   $pdfArray = array();




    echo "$i\n";
    //$D = date('Y-m-d');
    //$d = date ('Y-m-d');
    //$y = date ('Y',strtotime($d));
    //$d = date ('Y-m-d');
    $d = '2014-12-31';
    //echo "today the date is $d \n" ; 

    $d0= date('Y-m-d', strtotime('-'.$i.' day', strtotime(date( $d ))));
    //$d1= date_format($d0, 'd-m-Y'); 
    $d1 = date('dmY', strtotime($d0));
    $y = date ('Y',strtotime($d0));
    //echo $y;
    echo $d1."\n" ;
    //echo $d0."\n" ;
    $sun = date ('l');
    echo $sun."\n" ;
    if ($sun == 'Sunday'){
    echo "its a sunday";
    exit;
    }

    $link = "www.apmcazadpurdelhi.com/".$y."/".$d1.".xls";
    $path = "/home/aakash/".$d1.".xls";
    $csvfile = "/home/aakash/".$d1.".csv";


    $curl = curl_init($link);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    $result = curl_exec($curl);
    if ($result !== false){
       $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        echo $statusCode."\n" ;  
        if ($statusCode == 404){
            echo "URL Not Exists  '$d1' \n";

            $status = "failure";

             continue;

        }

        else
        {
          echo "URL Exists for '$d1' \n";
          $status = "success";
        }
    }
    else
    {
       echo "URL not Exists for '$d1'  \n ";
       $status = "failure";
    }


	download_remote_file_with_curl($link,$path);


	shell_exec("unoconv -f csv $path");
	$myfile = fopen($csvfile, "r") or die("Unable to open file!");
	//echo fread($myfile,filesize("$path"));
    $item = array ( "APPLE","ALMOND","AMROOD", "POMEGRANATE","BABUGOSHA","BANANA","BAILGIRI","BER","R.BER","CHAKOTRA","CHIKOO","COCONUT","C.APPLE","G.COCONUT","GRAPES","KINNU","KIWI","MALTA","MANGO","MELON/SARDA(Yellow)","MELON(Yellow)","MITHA","MOSAMBI","MOSSAMBI","NAKH","LEECHI","ORANGE","PAPAYA","PEARS","PINE.APPLE","PLUM","P.APPLE","PEACH","JAMUN","SHINGARA","STRAWBERRY","SUGERCANE","WATER MELON","ANAR","IMLI","DATE","PEARS/NAKH/SHANDONG","L.DANA/R.DANA/RAMBRITAN","MANGO STEAM","ASPRAGUS","ORANGE/MALTA(FULLSIZE","ORANGE(MINI)","DRAGAN"/*,"MELON"*/,"SHARDA","AVACADA","LEMON","YAPEAR/B.GOSHA","PLUM","FIG","LITCHI","BLUE BERRY","CHERRY","PEACH","APRICOT","POTATO","AMRAH","ARVI","ARVI LEAVES","AMLA","BATHUA","BRINJAL","R. BANANA","BEANS","BITTER GOURD","BROKLI","BABYCORN","BHUTTA","CABBAGE","CHUKANDER","CHIRCHINDA","CARROT","CHOLAI","CAULIFLOWER","CUCUMBER","GAWAR","G.CORIANDER","G.GARLIC","M.GINGER","G.LOBHIYA","GARLIC","G.CORIANDER","GOURD","G.GOBHI","GALGAL","HALDI GREEN","ICEBERG","JIMIKAND","JUGNI","KACHALU","KACHNAR","KAKORA","KAKRI","KAKRONDA","KAMRAIKH","KASERU","KUNDRU","KULFA","K.KAKRI","KATHAL","KACHRI","KHATTA","LADY FINGER","LEMON","LEMON GRASS","LANKU","METHI","M.CHILLI","MINT","MONGRA","R.MANGO","MUSHROOM","G.ONION","ONION","PEAS","PERMAL","PUMPKIN","PHUEE","SPINACH","SARSON LEAVES","RADISH","CAPSICUM","SAIM","SALAD","S.POTATO","SWEET POTATO","S.PETHA","SINGHI","SINGRI/SINGRA","SOYA","TOMATO","TORI","TINDA","TEET","TURNIP","YAM POTATO","SARSO LEAVE","SINGRI","JAPANI PHAL","MELON/SARDHA(Yellow)","KINOO","MELON SARDHA()","RASPBERRY","R.BANANA","CHOLIA DANA","CHOLIA LEAVES","SWANJANA PLANT","SWANJANA FLOWER","TINDA CHAPAL","BLACK.GAJAR","CHOLIA PLANT","ICEBERG","BANKLA","LOQUATE","MULBERRY","PHALSA","SWANJANA PHALI","GARMA","LOBHIYA","CHHOLIA LEAVES","LEHSUA","SWANJANAPHALI","C.TINDA","ICEBEGE","GAJAR BLACK","SINGRA","SWANFLOWER","SWAN.PLANT","HALDIGREEN","SARSONLEAVES","CHOLIALEAVES","CHOLIADANA","TINDACHAPAL","MELONSARDHA()","SWANJANAPLANT","GAJARBLACK","LADYFINGER","WATERMELON","SUGARCANE","MELON","SWANJANA","MANGOSTEAM","R.BANANA","LEMONGRASS","SWEETPOTATO","YAMPOTATO","JAPANIPHAL","SWANJANAFLOWER","CHOLIAPLANT");

    while (! feof ($myfile))
   {
      $line = fgets($myfile);
      $line = preg_replace('/\s/','', $line);

      if(preg_match('/^[\s\n\r\t]+$/', $line)){
           continue;
        }
        if (empty($line)!== false)
        {
         continue;
        } 
        if (strpos($line,'NO.APMC/MIS')!== false){
              
            continue;
        }
        if (strpos($line,'AGRICULTURAL')!== false){
              
            continue;
        }
        if (strpos($line,'(GOVT.')!== false){
              
            continue;
        }
        if (strpos($line,'OFFICE')!== false){
              
            continue;
        }
        if (strpos($line,'BULLETIN')!== false){
              
           continue;
        }
        if (strpos($line,'DAY')!== false){
              
           continue;
        }
        if (strpos($line,'NO.:091-11-27691799')!== false){
              
           continue;
        }
        if (strpos($line,'NAME:www.apmcazadpurdelhi.com/delagrimarket.nic.in')!== false){
              
        continue;
        }
        if (strpos($line,'apmcazadpur@gmail.com')!== false){
              
          continue;
        }  
        if (strpos($line,'ARRIVAL')!== false){
              
            continue;
        }
        if (strpos($line,'COMM.')!== false){
              
            continue;
        }
        if (strpos($line,'Page')!== false){
              
            continue;
        }
        if (strpos($line,'download from apmcazadpurdelhi.com')!== false){
           continue;
        }
            
        if (strpos($line,'NOTE:')!== false){
            break;
        }
        if (strpos($line,'VEGETABLES')!== false){
                continue;
        }


        if (strpos($line,'PRICE RELATES')!== false){
          continue;
        }
        if (strpos($line,'2. FIGURES SHOWN AFTER THE COMMODITY NAME DENOTE ARRIVAL OF PREVIOUS DAY.')!== false){
           continue;
        }
        if (strpos($line,'3. NC. = NEW CROP.    CS = COLD STORE . OC = OLD CROP. S.F. = SUGAR FREE.')!== false){
            continue;
        }
        if (strpos($line,'4. MODAL RATES ARE THOSE RATES ON WHICH MAJOR PORTION OF ARRIVALS ARE SOLD.')!== false){
            continue;
        }
        if (strpos($line,'*RATES RELATES TO THE PREVIOUS DAY.')!== false){
           continue;
        }
        if (strpos($line,'( GOVT. OF NCT OF DELHI)')!== false){
         continue;
        }
        if (strpos($line,'OFFICE COMPLEX NFM,PH-I, SARAI PEEPAL THALA, AZADPUR, DELHI-33')!== false){
           continue;
        }
        if (strpos($line,'NAME OF THE')!== false)
        {
          continue;
        }
        if (strpos($line,'(IMPORTED ITEMS)')!== false){
            break;
        }
        if (strpos($line,'PACKING')!== false)
        {
           continue;
        }



        if (strpos($line,'(IN KG.)')!== false){
                break;
        }



        $row_fruit_new = "";                                  // new fruit that will come in the lines i.e like apple then amrood
        $row_loc_new = "";
        $row_var_new = "";
        foreach ($item as $fruit) {                      // $fruit is the item that is present in array of item ie different fruits
                   
            if (strpos($line,$fruit) !== false) {         // if in line a fruit is present which is present in array of item          
               $row_fruit_new = $fruit;
               //continue;

               $row_loc_new = "";
              $row_loc = "";
               $row_var = "";
             $row_var_new = "";                  
                                             
            }
        }
        if ($row_fruit_new==''){
            if ($row_fruit==''){
            	continue;
            }
            else
            {
               $linee=explode(",",$line);
               
               //echo $linee[1];
               //echo $row_fruit."\t".$linee[0]."\t".$linee[1]."\t".$linee[2]."\t".$linee[3]."\t".$linee[4]."\t".$linee[5]."\t".$linee[6]."\t".$linee[7]."\t".$linee[8]."\t".$linee[9]."\t".$linee[10]."\t".$linee[11]."\t".$linee[12]."\t".$linee[13]."\n";
               if ($linee[7]==''){
               	$linee[7]="NONE";
               }

                if ($linee[1]!=''){
                	    $row_loc_new=$linee[1];
                	    $row_loc=$row_loc_new;
                    if ($linee[3]!=''){
                	    $row_var_new=$linee[3];
                	    $row_var=$row_var_new;
                        //echo $row_fruit."\t".$row_loc."\t".$linee[2]."\t".$row_var."\t".$linee[4]."\t".$linee[5]."\t".$linee[6]."\t".$linee[7]."\t".$linee[8]."\t".$linee[9]."\t".$linee[10]."\t".$linee[11]."\t".$linee[12]."\t".$linee[13]."\t".$linee[14]."\n";
                        $apmcItem=$row_fruit;
                                $apmcLocation=$row_loc;
                                $apmcVariety=$row_var;
                                $apmcWeight=$linee[4];
                                $apmcUnit=$linee[5];
                                $apmcTypeOfPacking=$linee[6];
                                $apmcGradeSize=$linee[7];
                                $apmcPriceMin=$linee[8];
                                $apmcPriceModal=$linee[9];
                                $apmcPriceMax=$linee[10];
                    }
                    else {
                    	$linee[3]="NONE";
                         $row_var=$linee[3]; 
                        //echo $row_fruit."\t".$row_loc."\t".$linee[2]."\t".$row_var."\t".$linee[4]."\t".$linee[5]."\t".$linee[6]."\t".$linee[7]."\t".$linee[8]."\t".$linee[9]."\t".$linee[10]."\t".$linee[11]."\t".$linee[12]."\t".$linee[13]."\t".$linee[14]."\n";
                        $apmcItem=$row_fruit;
                                $apmcLocation=$row_loc;
                                $apmcVariety=$row_var;
                                $apmcWeight=$linee[4];
                                $apmcUnit=$linee[5];
                                $apmcTypeOfPacking=$linee[6];
                                $apmcGradeSize=$linee[7];
                                $apmcPriceMin=$linee[8];
                                $apmcPriceModal=$linee[9];
                                $apmcPriceMax=$linee[10];

                    }
                }

                else {
                	if ($linee[3]!=''){
                		$row_var=$linee[3];
                		//echo $row_fruit."\t".$row_loc."\t".$linee[2]."\t".$row_var."\t".$linee[4]."\t".$linee[5]."\t".$linee[6]."\t".$linee[7]."\t".$linee[8]."\t".$linee[9]."\t".$linee[10]."\t".$linee[11]."\t".$linee[12]."\t".$linee[13]."\t".$linee[14]."\n";
                          $apmcItem=$row_fruit;
                                $apmcLocation=$row_loc;
                                $apmcVariety=$row_var;
                                $apmcWeight=$linee[4];
                                $apmcUnit=$linee[5];
                                $apmcTypeOfPacking=$linee[6];
                                $apmcGradeSize=$linee[7];
                                $apmcPriceMin=$linee[8];
                                $apmcPriceModal=$linee[9];
                                $apmcPriceMax=$linee[10];


                     
                	}
                	else
                	{
                       //echo $row_fruit."\t".$row_loc."\t".$linee[2]."\t".$row_var."\t".$linee[4]."\t".$linee[5]."\t".$linee[6]."\t".$linee[7]."\t".$linee[8]."\t".$linee[9]."\t".$linee[10]."\t".$linee[11]."\t".$linee[12]."\t".$linee[13]."\t".$linee[14]."\n";
                       $apmcItem=$row_fruit;
                                $apmcLocation=$row_loc;
                                $apmcVariety=$row_var;
                                $apmcWeight=$linee[4];
                                $apmcUnit=$linee[5];
                                $apmcTypeOfPacking=$linee[6];
                                $apmcGradeSize=$linee[7];
                                $apmcPriceMin=$linee[8];
                                $apmcPriceModal=$linee[9];
                                $apmcPriceMax=$linee[10];


                	}

                     



                }



            }


        }
        else 
        {
        	$row_fruit=$row_fruit_new;
        	continue;
        }

        $rowArr = array();
        $rowArr = array('apmc_date'=>$d0 ,'apmc_item'=>$apmcItem, 'apmc_location'=> $apmcLocation , 'apmc_variety'=> $apmcVariety ,'apmc_weight'=>$apmcWeight , 'apmc_unit'=>$apmcUnit ,'apmc_typeofpacking'=>$apmcTypeOfPacking,'apmc_gradesize'=>$apmcGradeSize,'apmc_pricemin'=>$apmcPriceMin,'apmc_pricemodal'=>$apmcPriceModal,'apmc_pricemax'=>$apmcPriceMax);
        //var_dump($rowArr);
        array_push($pdfArray, $rowArr);
        //print_r($pdfArray); die;



    } 

    $rows = '';
    foreach($pdfArray as $element){


        $rows .= "('".$element['apmc_date']. "','".$element['apmc_item']."','".$element['apmc_location']."','".$element['apmc_variety']."','".$element['apmc_weight']."','".$element['apmc_unit']."','".$element['apmc_typeofpacking']."','".$element['apmc_gradesize']."','".$element['apmc_pricemin']."','".$element['apmc_pricemodal']."','".$element['apmc_pricemax']."')," ;
    }
     //$rows = remove last comma($rows);

     $query_row = "INSERT INTO DailyData (date,item,place,variety,weight,unit,type_of_packing,grade_size,price_mini,price_modal,price_max) VALUES $rows "; 
     //echo $query_row."\n";
    $query_row = rtrim(rtrim($query_row), ',');


    if ($linker->query($query_row) === TRUE) {
        echo "New record created successfully \n ";
    } else {
    echo "Error: " . $query_row . "<br>" . $linker->error;
    }

     


}

?>
