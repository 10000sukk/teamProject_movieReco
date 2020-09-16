<?PHP

//주요장르 구분 넘버 부여 코드
function bbb($num){
    $result=0;
    if($num&pow(2,3)){
        $result = $result|pow(2,3);
    }
    if($num&pow(2,4)){
        $result = $result|pow(2,4);
    }
    if($num&pow(2,13)){
        $result = $result|pow(2,13);
    }
    if($num&pow(2,18)){
        $result = $result|pow(2,18);
    }
    if($num&pow(2,20)){
        $result = $result|pow(2,20);
    }
    if($num&pow(2,22)){
        $result = $result|pow(2,22);
    }
    if($num&pow(2,23)){
        $result = $result|pow(2,23);
    }
    if($num&pow(2,24)){
        $result = $result|pow(2,24);
    }


    return $result;

}


$servername = "localhost"; 
$username = "root";
$password = "ghks2122"; 
$database = "inp"; 

    $conn =mysqli_connect($servername,$username,$password,$database); 

    if(!$conn){
        die("Connection failed:". mysqli_connect_error());
    }
    for($i=1 ; $i<=1781 ; $i++){    
        $query="SELECT * FROM inp_movie WHERE id = $i"; 
        $result=mysqli_query($conn,$query);
        $row = mysqli_fetch_array($result); 
        
        $g = $row[genreNum]; //장르넘버

        $g2 = bbb($g);        //가중치 장르 넘버

        $sql ="UPDATE inp_movie SET specialgenreNum = '$g2' WHERE id = $i ";
        $r = mysqli_query($conn,$sql);

    

        if($r){ 
            echo "New record created successfully.<br>"; 
        } else{
            echo "Error: ".$sql."<br>".mysqli_error($conn)."<br>";
    }
    }



mysqli_close($conn);

?>