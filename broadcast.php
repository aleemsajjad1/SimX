<html>

<head>

    <title>SimX</title>
    <link rel="stylesheet" href="style.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />

    <style>
    @import url("//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css");
    </style>

</head>

<body>

    <?php 
  session_start();

  $conn = new mysqli("localhost", "root", "", "simx");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $userName = $_SESSION["username"];
    $sql = "SELECT * FROM `users` WHERE username = '$userName'";

     $result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo '
    
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"
        >&times;</a
      >
      <a href="#">Home</a>
    </div>

    <div class="container-fluid">
      <div class="row pt-3">
        <div class="col-lg-3">
          <div class="logoo">
            <span style="font-size: 30px; cursor: pointer;" onclick="openNav()"
              >&#9776;</span
            >
            <img src="simx.png" />
          </div>
        </div>
        <div class="col-lg-5 pt-2">
          <form class="navbar-form" action="search.php" method="post">
            <div class="input-group">
              <input
                class="form-control"
                type="text"
                name="name"
                placeholder="Search"
              />
              <span class="input-group-btn">
                <button type="submit" name="submit" value="submit" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </span>
            </div>
          </form>
        </div>
        
        <div style="text-align: right;" class="col-lg-4 profile-img">
        <span class="pr-3" style="font-weight:bold;">'.$row["name"].'</span>
          <img
            src="http://www.simx.tv/picture/Photos/'.$row["picture"].'.png"
            alt="Avatar"
            class="avatar"
          />
          <button
            style="background-color: #005585;"
            type="button"
            class="btn btn-info"
          >
            LogOut
          </button>
        </div>
      </div>
    </div>


    ';
  }
} else {
  echo "0 results";
}
  
  ?>

    <div class="container-fluid">

        <div class="row pt-5">

            <?php
    $conn = new mysqli("localhost", "root", "", "simx");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $broadcastId = $_GET['id'];
    // $sql = "SELECT * FROM `broadcasts` WHERE  broadcast = '$broadcastId'";
    $sql = "SELECT b.*, u.username AS uploader, u.picture AS uploader_pic FROM `broadcasts` AS b, `users` AS u WHERE u.username = b.username AND broadcast = '$broadcastId'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if($row['isOffline']){
        $src = "https://simx.s3-us-west-2.amazonaws.com/offlineVideos/$row[broadcast].mp4";
      }else{
        $src = "https://simx.s3-us-west-2.amazonaws.com/recordedvideos/$row[broadcast].mp4";
      }
      echo '
      <div class="col-8">
              <video class="video-js" controls width="1000" height="450" autoplay loop>
                  <source src="'.$src.'"
                      type="video/mp4" />
                  <p class="vjs-no-js">
                      To view this video please enable JavaScript, and consider
                      upgrading to a web browser that
                      <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                  </p>
              </video>
              <div class="row">
            <div class="col-12"><h3 >'.$row["title"].'</h3></div>
          </div>
          <div class="row">
            <div class="col-12"> '.$row["viewers"].' views . Upload Date: ' .explode(" ", $row["time"])[0].' </div>
          </div>
          <div class="row mt-3">
        <div class="col-1">
          <img
            src="http://www.simx.tv/picture/Photos/'.$row["uploader_pic"].'.png"
            alt="Avatar"
            class="avatar"
          />
        </div>
        <div class="col-11 pl-0">
          <p class="pt-2" style="font-weight: bold; font-size: 15px;">
          '.$row["name"].'
          </p>
        </div>
      </div>
          </div>
          
      ';
    }else {
      echo "0 results";
    }
        
    ?>


            <div class="col-4">
                <?php 
    $conn = new mysqli("localhost", "root", "", "simx");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $broadcastId = $_GET['id'];
    $sql = "SELECT * FROM `broadcasts` WHERE broadcast != '$broadcastId' ";
    // $sql = "SELECT b.*, u.username AS uploader, u.picture AS uploader_pic FROM `broadcasts` AS b, `users` AS u WHERE u.username = b.username";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '
      <div class="row mt-5">
        <div class="col-5">
          <div style="background-color: black;">
            <img class="thambnail"
            src="http://www.simx.tv/picture/Photos/'.$row["imglink"].'.png" />
          </div>
        </div>
        <div class="col-7 pl-0">
          <div class="row">
            <div class="col-12">
              <p style="font-weight: bold; font-size: 18px;">
                '.$row["title"].'
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-12 pt-5">
              <p>
                '.$row["name"].' <br />
                '.$row["viewers"].' Views . Upload Date: ' .explode(" ",
                $row["time"])[0].'
              </p>
            </div>
          </div>
        </div>
      </div>
    
      ';
      }
    } else {
      echo "0 results";
    }

    ?>
            </div>
            <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
            </script>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <!-- <script src="//vjs.zencdn.net/5.4.6/video.min.js"></script> -->
</body>

</html>