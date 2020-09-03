<?php 
session_start();
if(!isset($_SESSION["username"])){
  header("Location:logout.php"); 
}
?>



<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
    <style>
    @import url("//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css");
    </style>
    <title>Semix</title>
</head>

<body>
    <?php 
  $conn = new mysqli("localhost", "root", "", "simx");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $userName = $_SESSION["username"];
    $sql = "SELECT * FROM `users` WHERE username = '$userName'";
    $result = $conn->query($sql);
if ($result->num_rows > 0) {
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
            <a href="index.php"><img src="simx.png" /></a>
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
          <a
            style="background-color: #005585;"
            type="button"
            class="btn btn-info"
            href="logout.php"
          >
            LogOut
          </a>
        </div>
      </div>
    </div>
    ';
  }
} else {
  echo "0 results";
}
  ?>
    <?php 
    $conn = new mysqli("localhost", "root", "", "simx");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT b.*, u.username AS uploader, u.picture AS uploader_pic FROM `broadcasts` AS b, `users` AS u WHERE u.username = b.username";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '
        <a style="text-decoration: none;  color: black;" href="broadcast.php?id='.$row["imglink"].'">
      <div id="multidiv" class="pl-5 pr-5 pt-5" style="width: 24.9%;  display:inline-grid; margin-left:-1%; padding-left:40px !important;">
      
        <div style="background-color: black; height:280px;">
        <img
          class="video"
          src="http://www.simx.tv/picture/Photos/'.$row["imglink"].'.png"
        />
      </div>
      <div class="row mt-3">
        <div class="col-2">
          <img
            src="http://www.simx.tv/picture/Photos/'.$row["uploader_pic"].'.png"
            alt="Avatar"
            class="avatar"
          />
        </div>
        <div class="col-10">
          <p style="font-weight: bold; font-size: 18px;">
          '.$row["title"].'
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-2"></div>
        <div class="col-10">
          <p style="font-weight: bold;">
          '.$row["name"].' <br />
            '.$row["viewers"].' Views . Upload Date: ' .explode(" ", $row["time"])[0].'
          </p>
        </div>
      </div>
    </div>
      </a>';
      }
    } else {
      echo "0 results";
    }
    ?>
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
</body>

</html>