<?php
    include_once("db/connect.php");
    session_start();
    if (isset($_POST['FilmEdit'])){
        $idFilmEdit = $_POST['idFilmEdit'];
        $filmNameEdit = $_POST['filmNameEdit'];
        $directorEdit = $_POST['directorEdit'];
        $actorEdit = $_POST['actorEdit'];
        $categoryFilmEdit = $_POST['categoryFilmEdit'];
        $dateEdit = $_POST['dateEdit'];
        $timeEdit = $_POST['timeEdit'];
        $languageEdit = $_POST['languageEdit'];
		$phimid = $_POST['phimid'];
        $rateEdit = $_POST['rateEdit'];
        $decriptionEdit = $_POST['decriptionEdit'];
        $trailerEdit = $_POST['trailerEdit'];
        //Get embeed link video trailer
		$searchEdit     = '/youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi';
        $replaceEdit    = "youtube.com/embed/$1";
        $urlEdit = preg_replace($searchEdit,$replaceEdit,$trailerEdit);
        //End Get embeed link video trailer
        $posterEdit = basename($_FILES['posterEdit']['tmp_name']);
		$thumuc="img/".$posterEdit;
        //End Code up img to folder
		mysqli_query($mysqli,"set names 'utf8'");
        $sql_editFilm = mysqli_query($mysqli, "UPDATE `movie` 
        SET `movie_name`='$filmNameEdit',`movie_directors`='$directorEdit',`movie_cast`='$actorEdit',`movie_cate`='$categoryFilmEdit',
        `movie_date`='$dateEdit',`movie_time`='$timeEdit',`movie_language`='$languageEdit',`movie_rate`='$rateEdit',`movie_img`='$thumuc',
        `movie_decription`='$decriptionEdit',`movie_trailer`='$urlEdit',`phim_id`='$phimid' WHERE `movie_id`= '$idFilmEdit'");
		if($_FILES['posterEdit']['tmp_name']==''){
			$image = $row['movie_img'];
		}else{
			move_uploaded_file($_FILES['posterEdit']['tmp_name'], $thumuc);
		}
			echo "<script type='text/javascript'>alert('Chỉnh sửa thông tin phim thành công');</script>";
	}
    if(isset($_POST['deleteRowMovie'])){
        $idRowMovie =  $_POST['idRowMovie'];
        $sql_deleteShowing = mysqli_query($mysqli,"DELETE FROM `movie` WHERE `movie_id` = '$idRowMovie'");
        echo "<script type='text/javascript'>alert('Xóa phim thành công');</script>";
    }
	if(isset($_POST['deleteUS'])){
		$idUser = $_POST['idUser'];
		$sql_DLUS = mysqli_query($mysqli,"DELETE FROM users	WHERE user_id = $idUser") or die("Lỗi truy vấn 1");
		$sql_DLIF = mysqli_query($mysqli,"DELETE FROM users_info WHERE users_info_login = $idUser") or die("Lỗi truy vấn 2");
		echo "<script type='text/javascript'>alert('Xóa người dùng thành công');</script>";
	}
    if(isset($_POST['addShowing'])){
        $addShowMovieName = $_POST['addShowingName'];
        $addShowRoom = $_POST['addShowingRoom'];
        $addShowTheaterName = $_POST['addShowingTheater'];
        $addShowTime = $_POST['addShowingTime'];
        $sql_addNewRoomShowing = mysqli_query($mysqli,"INSERT INTO `room`(`room_id`, `room_name`, `room_theater`) 
        VALUES (null,'$addShowRoom','$addShowTheaterName');");
        $sql_getLastInsertRoom = mysqli_query($mysqli, "SELECT LAST_INSERT_ID();");
        $row = $sql_getLastInsertRoom->fetch_row();
        $sql_createNewSeat = mysqli_query($mysqli,"CALL addNewSeat('$row[0]')");
        $sql_addNewShowing = mysqli_query($mysqli,"INSERT INTO `showings`(`showings_id`, `showings_name_movie`, `showings_room`, `showings_time`)
        VALUES (null,'$addShowMovieName','$row[0]','$addShowTime')");
    }

    if(isset($_POST['deleteRowShowings'])){
        $idShowingDelete =  $_POST['idRowShowing'];
        $sql_deleteShowing = mysqli_query($mysqli,"DELETE FROM `showings` WHERE `showings_id` = '$idShowingDelete'");
        echo "<script type='text/javascript'>alert('Xóa suất chiếu thành công');</script>";
    }
    if(isset($_POST['updateShowing'])){
        $time = $_POST['editTimeShow'];
        $idShowing = $_POST['idShowUpdate'];
        $sql_updateShowing = mysqli_query($mysqli,"UPDATE `showings` SET `showings_time` = '$time' WHERE `showings`.`showings_id` = '$idShowing';");
        echo "<script type='text/javascript'>alert('Cập nhật suất chiếu thành công');</script>";
    }
    if(!isset($_SESSION['admin_name'])){
        header("Location: adminLogin.php");
    }
    if(isset($_POST['addNewFilm'])){
    $moviename=$_POST['filmName'];
    $directors=$_POST['director'];
    $cast=$_POST['actor'];
    $category=$_POST['categoryFilm'];
    $date=$_POST['date'];
    $time=$_POST['time'];
    $language=$_POST['language'];
	$phimid=$_POST['phimid'];
    $content=$_POST['decription'];
    $rated=$_POST['rate'];
    $trailer=$_POST['trailer'];
	//Get embeed link video trailer
        $search     = '/youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi';
        $replace    = "youtube.com/embed/$1";
        $url = preg_replace($search,$replace,$trailer);
    $tenfile=basename($_FILES['poster']['name']);
	$thumuc="img/".$tenfile;
    mysqli_query($mysqli,"set names 'utf8'");
    $sql = mysqli_query($mysqli, "insert into movie(movie_name,movie_directors,movie_cast,movie_cate,movie_img,movie_date,
    movie_time,movie_language,movie_decription,movie_rate,movie_trailer,phim_id) values ('".$moviename."','".$directors."',
    '".$cast."','".$category."','".$thumuc."','".$date."','".$time."','".$language."','".$content."','".$rated."','".$url."','".$phimid."')");
    if(move_uploaded_file($_FILES['poster']['tmp_name'], $thumuc))
	echo "<script type='text/javascript'>alert('Upload thành công');</script>";
    }
    if(isset($_GET['adminSignOut'])){
        session_destroy();
        header('location: adminLogin.php');
    }
    if(isset($_POST['regAdmin'])){
        $mailAdmin = $_POST['inputEmail'];
        $passwordAdmin = md5($_POST['inputPassword']);
        $nameAdmin = $_POST['inputName'];
        $genderAdmin = $_POST['inputGender'];

        $sql_check = mysqli_query($mysqli, "SELECT * FROM `admin` WHERE `admin_email` = '$mailAdmin'");
        $countCheck = mysqli_num_rows($sql_check);
        if($countCheck == 0){
            $sql_registerAdmin = mysqli_query($mysqli, "INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_password`,admin_name,admin_gender) 
            VALUES (NULL, '$mailAdmin', '$passwordAdmin','$nameAdmin','$genderAdmin')");
            $sql_checkRegAdmin = mysqli_query($mysqli, "SELECT * FROM `admin` WHERE `admin_email` = '$mailAdmin'");
            $count = mysqli_num_rows($sql_checkRegAdmin);
            if($count > 0){
                echo "<script type='text/javascript'>alert('Đăng Ký Tài Khoản Thành Công');</script>";
            }
        }
        else{
            echo "<script type='text/javascript'>alert('Tên Đăng Nhập Đã Tồn Tại');</script>";
        }
    }
?>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CGV Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="./summernote-0.8.16-dist/summernote.min.js"></script>
    <link href="./summernote-0.8.16-dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/admin.css">
    <link rel="stylesheet" href="./fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./css/admin.css">

</head>
<body>
<div class="row">
    <div class="col-md-2" style="background:rgb(78,115,223);">
        <div class="container tabBarLeft">
            <div class="tabBarLeft-logo">admin</div>
			<hr>
            <a href="" class="tabBarLeft-menu">
                <i class="fa fa-desktop"></i>
                <span class="tabBarLeft-menu-title">DashBoard</span>
            </a>
            <hr>
            <div class="tabBarLeft-cate">Quản lý chung</div>
            <a href="#" class="tabBarLeft-menu list-movies-admin">
                <i class="fa fa-film"></i>
                <span class="tabBarLeft-menu-title">Danh sách phim</span>
            </a>
            <a href="#" class="tabBarLeft-menu list-showings">
                <i class="far fa-calendar-alt"></i>
                <span class="tabBarLeft-menu-title">Danh sách lịch chiếu</span>
            </a>
            
            <hr>
            <div class="tabBarLeft-cate">Quản lý người dùng</div>
            <a href="#" class="tabBarLeft-menu list-admins">
                <i class="fas fa-users-cog"></i>
                <span class="tabBarLeft-menu-title">Quản trị viên</span>
            </a>
            <a href="#" class="tabBarLeft-menu list-user">
                <i class="fas fa-users"></i>
                <span class="tabBarLeft-menu-title">Khách hàng</span>
            </a>
        </div>
    </div>
    <div class="col-md-10 tabBarRight padding-0" style="background-color: rgb(247,248,251);">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm Kiếm..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div class="nav-item dropdown ml-auto">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo $_SESSION['admin_name'];?> </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="?adminSignOut=true"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
                </div>
            </div>
        </nav>
        <main class="mainContent ml mr" id="mainContent">
            <h3 class="mainContent-title">DashBoard</h3>
            <div class="row card-list">
                <div class="col-md-3">
                    <div class="card shadow" style="border-left: .25rem solid #4e73df;border-radius: 0.36rem">
                        <div class="card-body">
                            <h5 class="card-title" style="color:#4e73df ">Doanh Thu</h5>
                            <?php
                            $ve2d = 0;
                            $ve3d = 0;
                            $sql_revenue = mysqli_query($mysqli, "SELECT * FROM `booking`");
                            while($row_revenue = mysqli_fetch_array($sql_revenue)){
                                if($row_revenue['booking_ticket'] == 'Vé Phim 2D'){
                                    $ve2d +=1;
                                }
                                elseif ($row_revenue['booking_ticket'] == 'Vé Phim 3D'){
                                    $ve3d+=1;
                                }
                            }
                            ?>
                            <p class="card-text"><?php echo number_format(($ve2d * 45000) + ($ve3d *75000), 0, '', ',') . " VNĐ" ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow" style="border-left: .25rem solid #1cc88a;border-radius: 0.36rem">
                        <div class="card-body">
                            <h5 class="card-title" style="color:#1cc88a ">Số Rạp Toàn Quốc</h5>
                            <?php
                            $sql_countTheater = mysqli_query($mysqli, "SELECT * FROM `theaters`");
                            $countTheater = mysqli_num_rows($sql_countTheater);
                            ?>
                            <p class="card-text"><?php echo "$countTheater rạp" ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow" style="border-left: .25rem solid #36b9cc;border-radius: 0.36rem">
                        <div class="card-body">
                            <h5 class="card-title" style="color:#36b9cc ">Số Khách Hàng</h5>
                            <?php
                            $sql_countCus = mysqli_query($mysqli, "SELECT * FROM `users`");
                            $countCus = mysqli_num_rows($sql_countCus);
                            ?>
                            <p class="card-text"><?php echo "$countCus Người" ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow" style="border-left: .25rem solid #f6c23e;border-radius: 0.36rem">
                        <div class="card-body">
                            <h5 class="card-title" style="color:#f6c23e ">Tổng Số Vé Đã Bán</h5>
                            <?php
                            $sql_countTicket = mysqli_query($mysqli, "SELECT * FROM `booking`");
                            $countTicket = mysqli_num_rows($sql_countTicket);
                            ?>
                            <p class="card-text"><?php echo "$countTicket Vé" ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<footer>
    <div class="row">
        <div class="col-md-2" style="background:rgb(78,115,223);">
        </div>
        <div class="col-md-10">
           © DashBoard Admin 2021
        </div>
    </div>
</footer>
<script src="./js/admin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>
