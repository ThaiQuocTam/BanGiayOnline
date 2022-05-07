<?php 
    include_once("db/connect.php");
    session_start();
    $showingRoom = $_GET['showing'];
    $_SESSION['idRoom'] = $showingRoom;
    $sql_ticketInfo = mysqli_query($mysqli, "SELECT * FROM `showings`,theaters,room,movie WHERE showings_name_movie = movie_id and showings_room = room_id and room_theater = theaters_id and showings_room = '$showingRoom'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
   
    
</head>
<body>
<div class="theaterMap">
    <?php
        while($row_ticketInfo = mysqli_fetch_array($sql_ticketInfo)){
            $_SESSION['theaterName'] = $row_ticketInfo['theaters_id'];
            $_SESSION['typeTicket'] = $row_ticketInfo['room_name'];
            if($row_ticketInfo['room_name'] == 'Phòng 1'){
                $_SESSION['ticketName'] = 'Vé Phim 2D';
            }else if ($row_ticketInfo['room_name'] == 'Phòng 2'){
                $_SESSION['ticketName'] = 'Vé Phim 3D';
            }
    ?>
    <div class="ticket-info">
        <div>Phim: <span><?php echo $row_ticketInfo['movie_name'];?></span></div>
        <div>Suất Chiếu: <span><?php echo $row_ticketInfo['showings_time'];?></span></div>
        <div>Rạp: <span><?php echo $row_ticketInfo['theaters_name'];?></span></div>
        <div>Phòng: <span><?php echo $row_ticketInfo['room_name'];?></span></div>
        
    </div>
    <form action="" method="post" id = "booking">
       <input type="hidden" name="listTicket" id="listTicket" value=""/> 
        <button type="submit" name="booking" class="btn btn-primary">Đặt Vé</button>
    </form>
    <?php } ?>
    
</div>
</body>
</html>