<?php

    $client_secret = "430156241533f1d058c603178cc3ca0e"; // 시크릿 키 저장

    $url = "http://www.kobis.or.kr/kobisopenapi/webservice/rest/movie/searchMovieList.json"; // REST 방식의 json url 따오기
   
    $target_date="20171101"; // 타겟 날짜 설정
   
    $address = $url."?key=".$client_secret."&targetDt=".$target_date; // 응답 예시에서 본 양식 대로 정의
   
    $contents= file_get_contents($address); // 해당 url을 string으로 읽는 함수
    $obj = json_decode($contents,true); // json 객체로 변환
	

    /* 여기까지 api 이용해서 데이터 추출 */

    $servername = "localhost"; //서버 이름
    $username = "root"; //유저 이름
    $password = "ghks2122"; //비밀번호
    $database = "test"; //데이터베이스 이름

    $conn = mysqli_connect( //mysql과 연결하는 문법
        $servername,
        $username,
        $password,
        $database);

    if(!$conn){
        die("Connection failed: ". mysqli_connect_error());
    }
	for($i=0; $i<10; $i++){ // 먼저 var_dump로 구조를 읽고 차근차근 따라서 정의해 보면 됨
        $title= $obj["movieListResult"]["movieList"][$i]["movieNm"];//title
		  
    // 생성해둔 테이블에 result 저장
    // 나중에는 위에 for문에 넣어서 순서대로 저장하면 될 듯!
	    $genre = $obj["movieListResult"]["movieList"][$i]["repGenreNm"] ;
		 
		 
		  $director = $obj["movieListResult"]["movieList"][$i]["directors"][0]["peopleNm"] ;
	
		 
		   $contry= $obj["movieListResult"]["movieList"][$i]["nationAlt"] ;
	
		 
		 $created= $obj["movieListResult"]["movieList"][$i]["openDt"] ;
		 $sql ="INSERT INTO movie(title,genre,director,contry,created) VALUES('$title','$genre','$director','$contry','$created')";
		  $r = mysqli_query($conn,$sql);
       print $title;
    }

   


    if($r){ // 해당 mysql과 연결해서 문법실행
        echo "New record created successfully"; //성공
    } else{
        echo "Error: ".$sql."<br>".mysqli_error($conn);
    }
    
    mysqli_close($conn); // 연결 종료

    /* 여기까지 mysql php 연동 */

?>

