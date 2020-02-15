<?php
// acturl 넣는 코드

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

$select_sql= "SELECT actor1,actor2,actor3 from inp_movie"; //요청할 명령문

$act_movie = mysqli_query($conn,$select_sql);

if(mysqli_num_rows($act_movie) > 0) {
    // output data of each row
    $i=1;
    while($act = mysqli_fetch_assoc($act_movie)) {
            $act_t1[$i]= $act["actor1"];
            $act_t2[$i]= $act["actor2"];
            $act_t3[$i]= $act["actor3"];
            $i++;
    }

    

    for($i=1; $i<=count($act_t1); $i++){
        $act_t1[$i]=str_replace(" ","+",$act_t1[$i]);
        $act_t2[$i]=str_replace(" ","+",$act_t2[$i]);
        $act_t3[$i]=str_replace(" ","+",$act_t3[$i]);
        $act_t1[$i]=urlencode($act_t1[$i]);
        $act_t2[$i]=urlencode($act_t2[$i]);
        $act_t3[$i]=urlencode($act_t3[$i]);
    }


} else {
    echo "0 results";
}

//mysql

include_once 'Snoopy.class.php'; 
$snoopy=new snoopy;

for($i=; $i<=; $i++){ //245부터
$url1 = "https://www.google.co.kr/search?hl=ko&q=$act_t1[$i]+배우";
$url2 = "https://www.google.co.kr/search?hl=ko&q=$act_t2[$i]+배우";
$url3 = "https://www.google.co.kr/search?hl=ko&q=$act_t3[$i]+배우";

$actor=array(NULL,NULL,NULL);

$snoopy->fetch($url1);
$pst_txt= $snoopy->results;
$pst_txt = iconv("euc-kr","UTF-8",$pst_txt);

$pst_str = "<div class=\"OSMzvb\"";

$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),1000);
$pst_str="<img src=\"";
$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),500);
$pst_txt = strtok($pst_txt,"\"");

$actor[1]=$pst_txt;


$snoopy->fetch($url2);
$pst_txt= $snoopy->results;
$pst_txt = iconv("euc-kr","UTF-8",$pst_txt);

$pst_str = "<div class=\"OSMzvb\"";

$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),1000);
$pst_str="<img src=\"";
$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),500);
$pst_txt = strtok($pst_txt,"\"");

$actor[2]=$pst_txt;



$snoopy->fetch($url3);
$pst_txt= $snoopy->results;
$pst_txt = iconv("euc-kr","UTF-8",$pst_txt);

$pst_str = "<div class=\"OSMzvb\"";

$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),1000);
$pst_str="<img src=\"";
$pst_txt = substr($pst_txt, strpos($pst_txt,$pst_str) + strlen($pst_str),500);
$pst_txt = strtok($pst_txt,"\"");

$actor[3]=$pst_txt;

$update_sql= "UPDATE inp_movie SET act1url='$actor[1]' WHERE id=$i";
$dir_url_movie = mysqli_query($conn,$update_sql);


$update_sql= "UPDATE inp_movie SET act2url='$actor[2]' WHERE id=$i";
$dir_url_movie = mysqli_query($conn,$update_sql);


$update_sql= "UPDATE inp_movie SET act3url='$actor[3]' WHERE id=$i";
$dir_url_movie = mysqli_query($conn,$update_sql);

echo "id= $i update actorurl $actor[1],$actor[2],$actor[3]<br>";

}
mysqli_close($conn);

?>
