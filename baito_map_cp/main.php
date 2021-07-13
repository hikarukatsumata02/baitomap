<?php
	include 'db_config.php';
    session_start();
    
    if ($_SESSION['login_flag'] == 1) {
        $username = $_SESSION['username'];
    } else {
        $username = "----";
    }
	try
	{
	 // connect
	 $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
	 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	 $stmt = $db->query("SELECT * FROM info");
	 $markers = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 $markers = json_encode($markers, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

	 // disconnect
	 $db = null;
	}
	catch(PDOException $e)
	{
			$error = $e->getMessage();
			exit;
	}
?>




<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Sample_GoogleMap</title>

    <script src="https://maps.google.com/maps/api/js?key=AIzaSyBHFxBGgG03zUutDwMAfK8lO8ziFQwTZ9A&language=ja"></script>
    <!-- <style>
        #map {
            height: 500px;
            width: 600px;
        }
    </style> -->
</head>

<body>
    <?php
        echo "<h3>ようこそ{$username}さん</h3>";
        echo "<p><a href='logout.php'>ログアウト</a></p>";
    ?>
    <div id="map" style="width: 600px; height:500px;"></div>

    <script>
        let alldata = JSON.parse('<?php echo $markers; ?>');
        let infoWindow = [];
        let baito_marker = [];
        // console.log("alldata=",alldata[0]['x_coor']);
        
		if (navigator.geolocation) {
            console.log("この端末では位置情報が取得できます");
        // Geolocation APIに対応していない
        } else {
            console.log("この端末では位置情報が取得できません");
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {
                // 緯度・経度を変数に格納
                let mapLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                console.log(typeof (mapLatLng));
                let Options = {
                    zoom: 15,      //地図の縮尺値
                    center: mapLatLng,    //地図の中心座標
                    mapTypeId: 'roadmap'   //地図の種類
                };
                // マップオブジェクトを作成
                let map = new google.maps.Map(document.getElementById('map'), Options);
                let marker = new google.maps.Marker({
                    map: map,             // 対象の地図オブジェクト
                    position: mapLatLng   // 緯度・経度
                });
                
                let marker_cnt = alldata.length;
                // データベースに格納されているバイトの位置をプロット
        		for(var i=0; i<marker_cnt; i++){
                    let baito_id = alldata[i]['id']; 
                    let name = alldata[i]['name'];
                    let lat = alldata[i]['x_coor'];
                    let lng = alldata[i]['y_coor'];
                    let money = alldata[i]['money'];
                    let work = alldata[i]['work']
                    let work_time = alldata[i]['work_time'];
                    let phone = alldata[i]['phone'];
                    let today = new Date();
                    let now_time = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
                                     
                    // baito_place = new google.maps.LatLng(alldata[i]['x_coor'], alldata[i]['y_coor'])
                    baito_place = new google.maps.LatLng(lat, lng)
                    baito_marker[i] = new google.maps.Marker({
                        map: map,
                        position: baito_place,
                        animation: google.maps.Animation.DROP,
                    	icon: {
                    		fillColor: "#0000FF",                //塗り潰し色
                    		fillOpacity: 0.8,                    //塗り潰し透過率
                    		path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
                    		scale: 10,                           //サイズ
                    		strokeColor: "#0000FF",              //枠の色
                    		strokeWeight: 1.0                    //枠の透過率
                    	}
                    });
                    // console.log(alldata[i]['name']);
                     infoWindow[i] = new google.maps.InfoWindow({
                     content: "<div id='content'>"+
                              "<h1 id='firstHeading' class='firstHeading'>"+
                              name+
                              "</h1>"+
                              "<div id='bodyContent'>"+
                              "<p>時給："+
                              money+
                              "円</p>"+
                              "<p>仕事内容："+
                              work+
                              "</p>"+
                              "<p>仕事時間："+
                              work_time+
                              "</p>"+
                              "<p>電話番号："+
                              phone+
                              "</p>"+
                              // "<p><a href='write_view.php'>口コミを書く</a></p>"+
                              "<p>口コミを書く</p>"+                            
                              "<form action='insert_review.php' method='post'>"+                                                       
                              "<textarea name='comment' rows='4' cols='20'></textarea>"+
                              
                              "<input name='baito_id' type='hidden' value=''>"+
                              "<input name='author' type='hidden' value='<?php echo $username?>'>"+
                              "<input name='wrote_date' type='hidden' value=''>"+
                              
                              "<p><input type='submit' value='送信する'></p>"+
                              "</form>"+                             
                              "<p><a href='review_view.php'>みんなの口コミ</a></p>"+ // $baito_idと$baito_nameをreview_view.phpに送る
                              "</div>"+
                              "</div>"
                   });
                    // document.getElementById('baito_id').value = baito_id;
                    // document.getElementById('wrote_date').value = now_time;
                   
                    markerEvent(i); // 口コミを書くためのクリックイベント
        		}
            },
        );
        // 口コミを書くためのクリックイベント
        function markerEvent(i) {
            baito_marker[i].addListener('click', function() {
            infoWindow[i].open(map,baito_marker[i]); // 吹き出しの表示
          });
        }
	</script>
</body>

</html>
