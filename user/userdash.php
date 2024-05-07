<h2>welcome
        <?php
        session_start();
        echo $_SESSION['user_name']; 
        // if($_SESSION['user_name']===""){}
        
        ?>   </h2> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hostel reservation system</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid ">
       
        <div class="row">
            
            <nav id="sidebar" class=" d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active btn btn-success" href="#">
                              Control Panel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#submenu1" data-toggle="collapse">
                                profile
                            </a>
                            <div id="submenu1" class="collapse">
                                <ul class="nav flex-column pl-4">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            view your profile
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            edit your profile
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#submenu2" data-toggle="collapse">
                               Roles
                            </a>
                            <div id="submenu2" class="collapse">
                                <ul class="nav flex-column pl-4">
                                    <li class="nav-item">
                                        <a class="nav-link" href="rooms.php">
                                           view rooms
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="recently.php">
                                        recently booked room by you
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="#" >
                                view list all registered room
                            </a>
                          
                        </li> -->
                    </ul>
                </div>
            </nav>
            <!-- Content -->
            
        </div>
    </div>
    
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

