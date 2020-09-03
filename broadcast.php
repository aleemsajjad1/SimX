<?php 

session_start();
if(!isset($_SESSION["username"])){
  header("Location:logout.php"); 
}

?>

<!DOCTYPE html>
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

    <div class="container-fluid">

        <div class="row pt-5">

            <?php
    $conn = new mysqli("localhost", "root", "", "simx");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $broadcastId = $_GET['id'];

    // $sqlo = "SELECT t.tag  FROM `tags` AS t WHERE  t.tag = '$broadcastId'";
    $sql = "SELECT b.*, u.picture AS uploader_pic FROM `broadcasts` AS b, `users` AS u WHERE u.username = b.username AND broadcast = '$broadcastId'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $rows = $result->fetch_assoc();

      
      

      if($rows['isOffline']){
        $src = "https://simx.s3-us-west-2.amazonaws.com/offlineVideos/$rows[broadcast].mp4";
      }else{
        $src = "https://simx.s3-us-west-2.amazonaws.com/recordedvideos/$rows[broadcast].mp4";
      }
      ?>
            <div class="col-8">
                <?php 
              
              $bid = $rows['id'];

      $b = $rows['broadcast'];

      $un = $_SESSION["username"]; 
              
              ?>
                <?php echo '
                <video class="video-js" controls width="1000" height="450" autoplay loop>
                    <source src="'.$src.'" type="video/mp4" />
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider
                        upgrading to a web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>
                ';
                ?>
                <div style="padding-left:1%; padding-top:1%;">

                    <?php 
                  $conn = new mysqli("localhost", "root", "", "simx");
                  if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                  }
                   $broadcastId = $_GET['id'];
                    $sqlo = "SELECT t.tag AS tag FROM `tags` AS t WHERE  t.broadcast ='$broadcastId'";
                    $results = $conn->query($sqlo);

                    if ($results->num_rows > 0) {
                      while($row = $results->fetch_assoc()){
                      echo '<span style="color:blue;"> #'.$row["tag"].'</span>';
                      }
                    }
                    ?>

                </div>


                <div class="row">
                    <div class="col-8">
                        <?php  echo' <h3>'.$rows["title"].'</h3>' ?>
                    </div>
                    <div style="padding-left:10%;" class="col-4 send-btn-for-upload ">

                        <?php 
                      if($rows["isJob"] == 1){
                        echo'
                        <button id="sendCv" class="btn btn-info btn-lg" style="background-color: red">
                            <span><span class="glyphicon glyphicon-send"></span> &nbsp; &nbsp;Apply For Job</span>
                        </button>';

                      }
                    ?>



                    </div>
                </div>
                <div class="row">
                    <?php echo '<div class="col-12"> '.$rows["viewers"].' views . Upload Date: ' .explode(" ", $rows["time"])[0].'
                    </div>'?>
                </div>
                <div class="row mt-3">
                    <?php echo '
                    <div class="col-1">
                        <img src="http://www.simx.tv/picture/Photos/'.$rows["uploader_pic"].'.png" alt="Avatar"
                        class="avatar" /> '?>
                </div>
                <div class="col-11 pl-0">
                    <?php echo '<p class="pt-2" style="font-weight: bold; font-size: 15px;">'.$rows["name"].'</p>'?>
                </div>
            </div>
        </div>

        <?php
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
    $sql = "SELECT * FROM `broadcasts` WHERE broadcast != '$broadcastId' LIMIT 10 ";
    // $sql = "SELECT b.*, u.username AS uploader, u.picture AS uploader_pic FROM `broadcasts` AS b, `users` AS u WHERE u.username = b.username";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo '
        <a style="text-decoration: none;  color: black;" href="broadcast.php?id='.$row["imglink"].'">
      <div class="row mt-5 ">
        <div class="col-5">
          <div style="background-color: black; height:140px;">
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
      </a>
    
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

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
        $("#sendCv").click(function() {

            $('#sendCv').html('<div ><img src="30.gif" /></div>');
            $.post("video.php", {
                    username: "<?php echo $un; ?>",
                    broadcast: "<?php echo $b; ?>",
                    broadcastId: "<?php echo $bid; ?>"
                },
                function(data, status) {
                    $('#sendCv').html(
                        '<span><span class="glyphicon glyphicon-send"></span> &nbsp; &nbsp;Apply With Video</span>'
                    );
                    console.log("Data: " + data + "\nStatus: " + status);
                    var myObj = JSON.parse(data);
                    if (status == "success") {
                        alert(myObj.message)
                    } else {
                        alert("somting went wrong")
                    }
                });
        });
        </script>
</body>

</html>