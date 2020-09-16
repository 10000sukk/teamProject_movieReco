
<?php
//감독 url 삽입
$servername = "localhost"; //서버 이름
$username = "inp"; //유저 이름
$password = "Inp1234^^"; //비밀번호
$database = "inp"; //데이터베이스 이름

$conn = mysqli_connect( //mysql과 연결하는 문법
    $servername,
    $username,
    $password,
    $database);

if(!$conn){
    die("Connection failed: ". mysqli_connect_error());
}

mysqli_set_charset($conn,"utf8");

$select_sql= "SELECT director from inp_movie"; //요청할 명령문

$dir_movie = mysqli_query($conn,$select_sql);

if(mysqli_num_rows($dir_movie) > 0) {
    // output data of each row
    $i=1;
    while($dir = mysqli_fetch_assoc($dir_movie)) {
            $dir_t[$i]= $dir["director"];
            $i++;
    }

    for($i=1; $i<=count($dir_t); $i++){
        $dir_t[$i]=str_replace(" ","+",$dir_t[$i]); // title에 있는 문자열 공백 "+"로 바꾸기
        $dir_t[$i]=urlencode($dir_t[$i]);
    }
 echo $dir_t[57];
} else {
    echo "0 results";
}

//mysql

include_once 'Snoopy.class.php'; 
$snoopy=new snoopy;

for($i=1; $i<=1; $i++){

$name=$dir_t[$i];	
$url = "https://www.google.co.kr/search?hl=ko&q=$name+감독";

$snoopy->fetch($url);
$pst_txt= $snoopy->results;
echo $pst_txt."a<br>";
$pst_txt = iconv("euc-kr","UTF-8",$pst_txt);

echo $pst_txt."d<br>";

$pst_str = "<div class=\"OSMzvb\"";
$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),1000);
$pst_str="<img src=\"";
$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),500);
$pst_txt = strtok($pst_txt,"\"");

//web crawling
/*
$update_sql= "UPDATE inp_movie SET dir_url='$pst_txt' WHERE id=$i";

$dir_url_movie = mysqli_query($conn,$update_sql);
 */
echo "id= $i insert $pst_txt";
}
mysqli_close($conn);

?>
