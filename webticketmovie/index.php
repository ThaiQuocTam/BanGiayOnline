<?php 
    include_once("db/connect.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WEB TICKET MOVIE</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./css/movieD.css">
    <link rel="stylesheet" href="./css/listMovies.css">
    <link rel="stylesheet" href="./css/main1.css">
    <link rel="stylesheet" href="./css/listTheater.css">
    <link rel="stylesheet" href="./css/user.css">
</head>
<body>
    <?php
        include("include/header.php");
        if(isset($_GET['controller'])){
            $controller = $_GET['controller'];
        }else{
            $controller = '';
        }

        if($controller=='phim'){
            include('include/movieDetail.php');
        }
        else if($controller=='listmoviescomingsoon'){
            include('include/listMoviecomingsoon.php');
        }
		else if($controller=='listmoviesnowshowing'){
            include('include/listMovienowshowing.php');
        }
        else if($controller=='userInfo'){
            if(isset($_SESSION['user']) && $_SESSION['user'] != '')
            {
                include('include/userInfo.php');
            }
		}
        else if($controller=='listTheater'){
            include('include/listTheater.php');
        }
        else{
            include('include/home.php');
        }

        include("include/footer.php");
    ?>
    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="./js/index.js"></script>
    <script src="./js/listTheater.js"></script>
    <script src="./js/movieD.js"></script>
    <script src="./js/userInfo.js"></script>
	
	<script type="text/javascript" src="https://ahachat.com/customer-chats/customer_chat_ywV7BYvt4k625f709b6c4d1.js"></script>
</body>
</html>