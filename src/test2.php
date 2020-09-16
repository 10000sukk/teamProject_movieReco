<?php
// 줄거리 넣기

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

$select_sql= "SELECT title from inp_movie"; //요청할 명령문

$title_movie = mysqli_query($conn,$select_sql);

if(mysqli_num_rows($title_movie) > 0) {
    // output data of each row
    $i=1;
    while($title = mysqli_fetch_assoc($title_movie)) {
            $title_t[$i]= $title["title"];
            $i++;
    }

    for($i=1; $i<=count($title_t); $i++){
        $title_t[$i]=urlencode($title_t[$i]);
    }


} else {
    echo "0 results";
}

//mysql

include_once 'Snoopy.class.php'; 
$snoopy=new snoopy;

for($i=1622; $i>=639; $i--){  //639부터
$url = "https://www.google.co.kr/search?hl=ko&q=$title_t[$i]+영화";


$snoopy->fetch($url);
$pst_txt= $snoopy->results;

$pst_txt = iconv("euc-kr","UTF-8",$pst_txt);
$pst_str = "<div class=\"mraOPb\"";

if (stripos($pst_txt,$pst_str) == false) {
    $pst_str="<h3 class=\"bNg8Rb\"";
}

$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),10000);
$pst_str="<span>\"";
$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),3000);
$pst_txt = strtok($pst_txt,"</");

$update_sql= "UPDATE inp_movie SET story='$pst_txt' WHERE id=$i";
$dir_url_movie = mysqli_query($conn,$update_sql);

echo "id= $i update story $pst_txt <br>";

}
mysqli_close($conn);

?>
