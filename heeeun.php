<?php

// 포스터, 평점
/* mysql 연결 */

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

/* mysql query */

    $select_sql="select title from inp_movie";

    mysqli_set_charset($conn,"utf8");

    $title_movie = mysqli_query($conn,$select_sql);

    if(mysqli_num_rows($title_movie) > 0) {
        // output data of each row
        $i=1;
        while($title = mysqli_fetch_assoc($title_movie)) {
		$movie_t[$i]= $title["title"];
                $i++;
        }
    } else{
            echo "0 results";
    }

    $country_sql="select nation from inp_movie";

    $nation_movie = mysqli_query($conn,$country_sql);

    if(mysqli_num_rows($nation_movie)>0){
	$i=1;
        while($nation = mysqli_fetch_assoc($nation_movie)) {
		$movie_n[$i]= $nation["nation"];
	
		switch($movie_n[$i]){
		case"한국":
			$movie_n[$i]="KR";
			break;
		case"일본":
			$movie_n[$i]="JP";
			break;
		case"미국":
                  	$movie_n[$i]="US";
			break;
		case"홍콩":
                        $movie_n[$i]="HK";
                        break;
		case"영국":
                        $movie_n[$i]="GB";
                        break;
		case"프랑스":
                        $movie_n[$i]="FR";
			break;
		default:
			$movie_n[$i]="ETC";
			break;
		}

        	$i++;
        }
    } else{
            echo "0 results";
    }

for($i=1001; $i<=1781; $i++){
/* 네이버 api 추출 */
    $client_id = "ZjXIF9SRe1TTTOJy71Gs";
    $client_secret = "zL_OWDmgnp";
    $enc_t=urlencode($movie_t[$i]);
    $country=urlencode($movie_n[$i]);
    $url = "https://openapi.naver.com/v1/search/movie.json?query=".$enc_t."&country=".$country; // json 결과

    $is_post = false;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, $is_post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = array();
    $headers[] = "X-Naver-Client-Id: ".$client_id;
    $headers[] = "X-Naver-Client-Secret: ".$client_secret;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "status_code:".$status_code."
";

    $response = json_decode($response,true);
    curl_close($ch);

    var_dump($response);

    /* 평점*/

    $max_rate=0.00;

    $res_items=$response["items"];

    for($j=0; $j<count($res_items); $j++){
	    if($res_items[$j]["userRating"]>$max_rate){
                 $max_rate=$response["items"][$j]["userRating"];
                 $index=$j;
         }
    }
    /*포스터*/
    if($response["items"][$index]["image"]!=NULL){
    	$image_url=$response["items"][$index]["image"];
    }
   
    /*mysql에 집어넣기*/
   
    $url_sql="update inp_movie set url='$image_url' where id=$i";

    mysqli_set_charset($conn,"utf8");

    $url_movie = mysqli_query($conn,$url_sql);

    $rate_sql="update inp_movie set rate='$max_rate' where id=$i";

    $rate_movie=mysqli_query($conn,$rate_sql);



}
?>
