<?PHP

function onlyHanAlpha($subject) {

    $new_names = trim(preg_replace('/[^\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}0-9a-zA-Z\s]/u', "", $subject));

    return $new_names;
}//string 에서 한글 영어 숫자만 남기는 함수
include_once 'C://Bitnami//wampstack-7.1.23-0//apache2//htdocs//Snoopy-2.0.0.tar.gz//Snoopy.class.php'; 
$snoopy=new snoopy;


$servername = "localhost"; 
$username = "root";
$password = "ghks2122"; 
$database = "inp"; 

$conn =mysqli_connect( $servername,$username,$password,$database);

if(!$conn){
        die("Connection failed:". mysqli_connect_error());
    }

for($i=1700;$i<1781;$i++){    
    $query="SELECT * FROM inp_movie WHERE id = $i"; 
    $result=mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result); 
    
    $title=$row[title];
    $title = onlyHanAlpha($title);
    $title = preg_replace("/\s+/", "+", $title);
    $title= urlencode($title);

    $url = "https://www.google.co.kr/search?q=영화+$title+장르";
    $snoopy->fetch($url);
    $eval_txt = $snoopy->results;
    $eval_txt = iconv("euc-kr","UTF-8",$eval_txt);
    preg_match_all("/<span class=\"ED44Kd\">(.*?)<\/span>/", $eval_txt, $text);
    
    $text[1][0] = onlyHanAlpha($text[1][0]);
    $text[1][0] = str_replace("br","",$text[1][0]);
    $genre1 = $text[1][0]; 
    
    if($genre1 == NULL){
        continue;
    }                            //genre1                                           
    
    $text[1][1] = onlyHanAlpha($text[1][1]);
    $text[1][1] = str_replace("br","",$text[1][1]);
    $genre2 = $text[1][1];                                  //genre2
    
    $text[1][2] = onlyHanAlpha($text[1][2]);
    $text[1][2] = str_replace("br","",$text[1][2]);
    $genre3 = $text[1][2];                                   //genre3
    
    $text[1][3] = onlyHanAlpha($text[1][3]);
    $text[1][3] = str_replace("br","",$text[1][3]);
    $genre4 = $text[1][3];                                    //genre4
    
    $text[1][4] = onlyHanAlpha($text[1][4]);
    $text[1][4] = str_replace("br","",$text[1][4]);
    $genre5 = $text[1][4];                                     //genre5


    $sql ="UPDATE inp_movie SET genre1 = '$genre1' WHERE id = $i ";
    $r = mysqli_query($conn,$sql);

    $sql ="UPDATE inp_movie SET genre2 = '$genre2' WHERE id = $i ";
    $r = mysqli_query($conn,$sql);

    $sql ="UPDATE inp_movie SET genre3 = '$genre3' WHERE id = $i ";
    $r = mysqli_query($conn,$sql);

    $sql ="UPDATE inp_movie SET genre4 = '$genre4' WHERE id = $i ";
    $r = mysqli_query($conn,$sql);

    $sql ="UPDATE inp_movie SET genre5 = '$genre5' WHERE id = $i ";
    $r = mysqli_query($conn,$sql);

    if($r){ 
        echo "New record created successfully"."<br>"; 
    } else{
        echo "Error: ".$sql."<br>".mysqli_error($conn)."<br>";
    }


}




?>