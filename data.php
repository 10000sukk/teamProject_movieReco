<?PHP

$client_secret = "f8549ccb1da67930e6887547de9dc559"; 

    $url = "http://www.kobis.or.kr/kobisopenapi/webservice/rest/boxoffice/searchDailyBoxOfficeList.json"; 

    $servername = "localhost"; 
    $username = "root"; 
    $password = "ghks2122"; 
    $database = "inp"; 

    $conn = mysqli_connect( 
        $servername,
        $username,
        $password,
        $database);

    if(!$conn){
        die("Connection failed: ". mysqli_connect_error());
    }

    for($n=4; $n<=18; $n++){
        for($m =1; $m <=12; $m++ ){


            if($m < 10 && $n<10 ){
                $target_date="200".$n."0".$m."01"; 
            }
            else if($m>=10 && $n<10){
                $target_date="200".$n.$m."01"; 
            }
            else if($m<10 && $n >=10){
                $target_date="20".$n."0".$m."01"; 
            }
            else if($m>=10 && $n >=10){
                $target_date="20".$n.$m."01";
            }


    $address = $url."?key=".$client_secret."&targetDt=".$target_date; 
   
    $contents= file_get_contents($address); 
    $obj = json_decode($contents,true); 
	

    

    
	for($i=0; $i<10; $i++){ 
        $title= $obj["boxOfficeResult"]["dailyBoxOfficeList"][$i]["movieNm"];

        $movieCd = $obj["boxOfficeResult"]["dailyBoxOfficeList"][$i]["movieCd"];
		  
   
		 $sql ="INSERT INTO inp_movie(title,movieCd) VALUES('$title','$movieCd')";
		  $r = mysqli_query($conn,$sql);
       print $title."<br>";
    }

   


    if($r){ 
        echo "New record created successfully"."<br>"; 
    } else{
        echo "Error: ".$sql."<br>".mysqli_error($conn)."<br>";
    }
    
    
       
}
}
mysqli_close($conn); 

?>



