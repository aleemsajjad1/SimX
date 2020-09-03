  <?php
    session_start();  
    $conn = new mysqli("localhost", "root", "", "simx");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $username = $_POST['username'];
    $broadcasts = $_POST['broadcast'];
    $broadcastsID = $_POST['broadcastId'];

    $sql = "SELECT * FROM `videocvs` WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0){
        $rows = $result->fetch_assoc();
        $videocvid = $rows['id'];
        $query = "INSERT INTO `jobcandidates`(`username`, `broadcast`, `isshortlisted`, `videocvID`, `broadcast_id`) VALUES ('$username','$broadcasts','0','$videocvid','$broadcastsID')";
        if($result = $conn->query($query)){
            $response = array(
                "status" => true,
                "message" => "Successfully Added."
            );
        }else{
            $response = array(
                "status" => false,
                "message" => "Something went wrong"
            );
        }
      }else{
        $response = array(
                "status" => false,
                "message" => "No CV Exist. Upload your CV Using Our Mobile App"
        );
    }

    echo json_encode($response);

?>