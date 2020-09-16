<?PHP
//유사도를 구하는 코드



//2진수에서 1의 갯수를 세주는 함수
function count1($n) {
    $cnt;
    $cnt=0;
    while($n!=0) {
        $cnt+=$n%2;
        $n/=2;
    }
    return $cnt;
}


$servername = "localhost"; 
$username = "inp";
$password = "Inp1234^^"; 
$database = "inp"; 

$conn = mysqli_connect( 
    $servername,
    $username,
    $password,
    $database);

if(!$conn){
        die("Connection failed:". mysqli_connect_error());
    }

$post = $_POST['title'];
$query="SELECT * FROM inp_movie WHERE title ='$post'" ; 
$result=mysqli_query($conn,$query); 

print "information of $post is ....."."<br>";

if(mysqli_num_rows($result)>0){
	while($show=mysqli_fetch_assoc($result)){
$nowtitle = $show['title'];
$nowgenreNum = $show['genreNum'];
$nowspecial = $show['specialgenreNum'];
$nowgenre1 = $show['genre1'];
$nowgenre2 = $show['genre2'];
$nowgenre3 = $show['genre3'];
$nowgenre4 = $show['genre4'];
$nowgenre5 = $show['genre5'];
$nowaudits = $show['audits'];
$nowdirector = $show['director'];
$nowactor1 = $show['actor1'];
$nowactor2 = $show['actor2'];
$nowactor3 = $show['actor3'];
$nownation = $show['nation'];
$nowopenDt = $show['openDt'];
$nowrate = $show[rate];
	
	}
}
echo $nowtitle;
print "$nowtitle, $nowgenreNum, $nowgenre1, $nowgenre2, $nowgenre3, $nowgenre4, $nowgenre5, $nowaudits, $nowdirector, $nowactor1, $nowactor2, $nowactor3, $nownation, $nowopenDt, $nowrate"."<br><br><br>";
print "simillar movie with $post is ....."."<br>";

$conn = mysqli_connect( 
    $servername,
    $username,
    $password,
    $database);

if(!$conn){
        die("Connection failed:". mysqli_connect_error());
    }

//임시테이블 만들기

    $maketemp = "CREATE TEMPORARY TABLE temp('id' int NOT NULL AUTO_INCREMENT, 'title' varchar(20), 'genre1' varchar(20), 'genre2' varchar(20), 'genre3' varchar(20), 'genre4' varchar(20), 'genre5' varchar(20),'audits' varchar(20),  'director' varchar(20), 'actor1' varchar(20), 'actor2' varchar(20),'actor3' varchar(20), 'nation' varchar(10), 'openDt' varchar(20), 'url' varchar(200), 'rate' double, 'dirurl' varchar(200), 'act1url' varchar(200),'act2url' varchar(200),'act3url' varchar(200),'similarity' int NOT NULL,  PRIMARY KEY(id))";

mysqli_query($conn, $maketemp);
    for($i =1 ;$i<=1781 ; $i++){
        $query = "SELECT * FROM inp_movie WHERE id = $i";
        $result = mysqli_query($conn,$query);
        $row = mysqli_fetch_array($result);
    
        $similarity = 0;


        $thisnum1 = $row[genreNum];
        $n1 = count1($nowgenreNum & $thisnum1);
        $similarity1 = 5*$n1;
    

        $thisnum2 = $row[specialgenreNum];
        $n2 = count1($nowspecial & $thisnum2);
        $similarity2 = 20*$n2;
        $similarity = $similarity1 + $similarity2;
    

//유사도 25 이상을 임시 테이블에 저장
    if($similarity >= 25){

    $str = "INSERT INTO temp(title,genre1,genre2,genre3,genre4,genre5,audits,director,actor1,actor2,actor3,nation,openDt,url,rate,similarity)
                 VALUES('$row[title]','$row[genre1]','$row[genre2]','$row[genre3]','$row[genre4]','$row[genre5]','$row[audits]','$row[director]','$row[actor1]','$row[actor2]','$row[actor3]','$row[nation]','$row[openDt]','$row[url]','$row[rate]','$similarity') ";
    
    $r = mysqli_query($conn, $str);

    }
    }

    
//유사도 높은것부터 10개 출력
    $query = "SELECT * from temp ORDER BY similarity DESC  LIMIT 10";
    $result = mysqli_query($conn, $query);
    while($data = mysqli_fetch_array($result)){

        echo "제목 : $data[title] , 유사도 : $data[similarity]";





    }







mysqli_close($conn);


?>



