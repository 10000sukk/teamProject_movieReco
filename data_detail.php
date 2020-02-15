<?PHP

$client_secret = "f1b1663a8ed3faa133c3ba0e4fdac157"; 

    $url = "http://www.kobis.or.kr/kobisopenapi/webservice/rest/movie/searchMovieInfo.json"; 

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

for($i=226;$i<=300;$i++){
    $query="SELECT movieCd FROM inp_movie WHERE id = $i" ; 
    $result=mysqli_query($conn,$query); 
    $row=mysqli_fetch_array($result); 
    $movieCd = $row[movieCd];


   

    $address = $url."?key=".$client_secret."&movieCd=".$movieCd; 
   
    $contents= file_get_contents($address); 
    $obj = json_decode($contents,true); 


    

    
	 
    //$title= $obj["movieInfoResult"]["movieInfo"]["movieNm"];

   // $genre = $obj["movieInfoResult"]["movieInfo"]["genres"][0]["genreNm"];

    /*$audits = $obj["movieInfoResult"]["movieInfo"]["audits"][0]["watchGradeNm"];

    $director = $obj["movieInfoResult"]["movieInfo"]["directors"][0]["peopleNm"];

    $actor1 = $obj["movieInfoResult"]["movieInfo"]["actors"][0]["peopleNm"];

    $actor2= $obj["movieInfoResult"]["movieInfo"]["actors"][1]["peopleNm"];

    $actor3= $obj["movieInfoResult"]["movieInfo"]["actors"][2]["peopleNm"];
    
    $nation = $obj["movieInfoResult"]["movieInfo"]["nations"][0]["nationNm"];*/

    $openDt = $obj["movieInfoResult"]["movieInfo"]["openDt"];
   
		  //$sql ="UPDATE inp_movie SET title = $title WHERE id = $i ";
         // $r = mysqli_query($conn,$sql);

          //$sql ="UPDATE inp_movie SET genre = '$genre' WHERE id = $i ";
          //$r = mysqli_query($conn,$sql);

          /*$sql ="UPDATE inp_movie SET audits = '$audits' WHERE id = $i ";
          $r = mysqli_query($conn,$sql);

          $sql ="UPDATE inp_movie SET director = '$director' WHERE id = $i ";
          $r = mysqli_query($conn,$sql);

         $sql ="UPDATE inp_movie SET actor1 = '$actor1' WHERE id = $i ";
          $r = mysqli_query($conn,$sql);

          $sql ="UPDATE inp_movie SET actor2 = '$actor2' WHERE id = $i ";
          $r = mysqli_query($conn,$sql);

          $sql ="UPDATE inp_movie SET actor3 = '$actor3' WHERE id = $i ";
          $r = mysqli_query($conn,$sql);

          $sql ="UPDATE inp_movie SET nation = '$nation' WHERE id = $i ";
          $r = mysqli_query($conn,$sql);*/

          $sql ="UPDATE inp_movie SET openDt = '$openDt' WHERE id = $i ";
          $r = mysqli_query($conn,$sql);
          
      
    

    if($r){ 
        echo "New record created successfully"."<br>"; 
    } else{
        echo "Error: ".$sql."<br>".mysqli_error($conn)."<br>";
    }
    
    
}  

mysqli_close($conn); 

?>



