
<!--
Listing Details page is reached from Listings page, on selecting a particular listing. 
This page contains the elaborate description such as owner information, store hours and location.
ALong with the menu which is a form for users to select menu items and quantities.
-->

<?php
	
	//Connecting to database
	$db=mysqli_connect("localhost","root","","testdb");
	session_start();
	//Checking to see if create buttob to add a listing is selected or not.
	if (isset($_POST['create_btn'])){
		
		$name=mysqli_real_escape_string($db,$_POST['name']);
		$info=mysqli_real_escape_string($db,$_POST['info']);
		$time=mysqli_real_escape_string($db,$_POST['time']);
		$location=mysqli_real_escape_string($db,$_POST['location']);
		//Inserting user inputs into the listing table of database.
		$sql = "INSERT INTO listing(name,information,time,location) VALUES ('$name','$info','$time','$location')";
		mysqli_query($db,$sql);
		$_SESSION['message']="Listing Created!";

		
	}
	
	else if (isset($_POST['btn_checkout'])){
		//Collecting username(currently logged in user) in name variable to be inserted into the menu table of the database to identify whicg user ordered what and in what quantity.
		$name=$_SESSION['username'];
		$itemarr=$_POST["item"];
		//menu items are inputted in form of array and then implodede to form a list before inserting into database.
		$newitems=implode(",",$itemarr);
		$cost="$60";
		//Inserting user inputs into the customerOrder table of the database.
		$sql = "INSERT INTO customerorder(CustomerName,Items,TotalCost) VALUES ('$name','$newitems','$cost')";
		mysqli_query($db,$sql);
		$_SESSION['message']="Order Selected!";
		$_SESSION['username']= $name; 
		header("location:checkout.php"); 
	}
	//Checking if post button from review form is selected or not. 
	else if (isset($_POST['post_btn'])){
		//To insert user reviews into the review table of database. 
		$name=$_SESSION['username'];
		$time=date("h:i:sa");
		$date=date("Y/m/d");
		//Inserting username(currently logged in user), review, date and time into the reviews table.
		$review=mysqli_real_escape_string($db,$_POST['review']);
		$sql = "INSERT INTO reviews(name,review,date,time) VALUES ('$name','$review','$date','$time')";
		mysqli_query($db,$sql);
	}
?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Foodzpa</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  
  

  <!-- Libraries CSS Files -->
  <link href="lib/nivo-slider/css/nivo-slider.css" rel="stylesheet">
  <link href="lib/owlcarousel/owl.carousel.css" rel="stylesheet">
  <link href="lib/owlcarousel/owl.transitions.css" rel="stylesheet">
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/venobox/venobox.css" rel="stylesheet">

  <!-- Nivo Slider Theme -->
  <link href="css/nivo-slider-theme.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

  <!-- Responsive Stylesheet File -->
  <link href="css/responsive.css" rel="stylesheet">

  
  
  <style>
/* The container */
.chkcontainer {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}


/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 33.33%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

@media screen and (max-width: 1000px) {
  .column {
    width: 100%;
  }
  
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}

/*DropDown*/

.dropbtn {
  background-color: #E53030;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #DA2E2E;
}

#myInput {
  border-box: box-sizing;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}  

</style>
  

</head>

<body data-spy="scroll" data-target="#navbar-example">

  <div id="preloader"></div>

  <header>
    <!-- header-area start -->
    <div id="sticker" class="header-area">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12">

            <!-- Navigation -->
            <nav class="navbar navbar-default">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-navbar-collapse-1" aria-expanded="false">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
                <!-- Brand -->
                <a class="navbar-brand page-scroll sticky-logo" href="guestHome.php">
                  <h1><span>Foodz</span>Pa</h1>
                  <!-- Uncomment below if you prefer to use an image logo -->
                  <!-- <img src="img/logo.png" alt="" title=""> -->
								</a>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse main-menu bs-example-navbar-collapse-1" id="navbar-example">
                <ul class="nav navbar-nav navbar-right">
                  <li class="active">
                    <a class="page-scroll" href="#home">Home</a>
                  </li>
                  <li>
                    <a class="page-scroll" href="#portfolio">Most Popular</a>
                  </li>
                  <li>
                    <a class="page-scroll" href="#services">Categories</a>
                  </li>
				  <li>
                    <a class="page-scroll" href="#about">About Us</a>
                  </li>
                  <li>
                    <a class="page-scroll" href="#contact">Contact</a>
                  </li>
				  
				  <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['username']; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li>
					  <a onclick="openFormCreate()">Create Listing</a>

						<div class="form-popup" id="myFormCreate">
						  <form class="form-container" style="max-width: 400px;" method="POST" action="userHome.php">
							<h1>Create Listing</h1>
							<label for="name"><b>Owner Name</b></label>
							<input type="text" placeholder="Enter Username" name="name" id="name" required>

							<label for="info"><b>Owner Information</b></label>
							<input type="text" placeholder="Enter Information" name="info" id="info" required>
							
							<label for="time"><b>Store Hours</b></label>
							<input type="text" placeholder="Enter Hours" name="time" id="time" required>
							
							<label for="loc"><b>Store Location</b></label>
							<input type="text" placeholder="Enter Location" name="location" id="location" required>

							<button type="submit" class="btn" name="create_btn" value="Create" onclick="validateCreate()">Create</button>
							<button type="button" class="btn cancel" onclick="closeFormCreate()">Close</button>
						   </form> 
					  
						</div>
					  
					  </li>
                      <li><a href="#" >Edit Listing</a></li>
					  <li><a href="#" >Delete Listing</a></li>
					  <li><a href="logout.php" >Sign Out</a></li>
                    </ul> 
                  </li>
				  
                </ul>
              </div>
              <!-- navbar-collapse -->
            </nav>
            <!-- END: Navigation -->
          </div>
        </div>
      </div>
    </div>
    <!-- header-area end -->
  </header>
  <!-- header end -->

  
  <script>
	function openFormCreate() {
	  document.getElementById("myFormCreate").style.display = "block";
	}

	function closeFormCreate() {
	  document.getElementById("myFormCreate").style.display = "none";
	}
	
	function validateCreate(){
		alert("Congratulations your listing has been created!");
	}
	
  </script>
  
  
  
  <!-- Start Bottom Header -->
  <div class="header-bg page-area">
    <div class="home-overly"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="slider-content text-center">
            <div class="header-bottom">
              <div class="layer2 wow zoomIn" data-wow-duration="1s" data-wow-delay=".4s">
                <h1 class="title2">Welcome to </h1>
              </div>
              <div class="layer3 wow zoomInUp" data-wow-duration="2s" data-wow-delay="1s">
                <h2 class="title3">Mike's</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Header -->
  <div class="blog-page area-padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="page-head-blog">
            <div class="single-blog-page">
              <!-- search option start -->
              <form action="#">
                <div class="search-option">
                  <input type="text" placeholder="Search...">
                  <button class="button" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                </div>
              </form>
              <!-- search option end -->
            </div>


            <div class="single-blog-page">
              <div class="left-blog">
                <h4>Categories</h4>
                <ul>
                  <li>
                    <a href="#">Owner Info</a>
                  </li>
				  <li>
                    <a href="#">Store Location</a>
                  </li>
                  <li>
                    <a href="#">Menu</a>
                  </li>
                  <li>
                    <a href="#">Gallery</a>
                  </li>
                  <li>
                    <a href="#">Reviews</a>
                  </li>
                </ul>
              </div>
            </div>
            
            
          </div>
        </div>
        <!-- End left sidebar -->
        <!-- Start single blog -->
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <!-- single-blog start -->
              <article class="blog-post-wrapper">
                <div class="post-thumbnail">
                  <img src="img/blog/6.jpg" alt="" />
                </div>
                <div class="post-information">
                  <h2>Overview</h2>
                  <div class="entry-meta">
                    <span class="author-meta"><i class="fa fa-user"></i> <a href="#">owner</a></span>
                    <span><i class="fa fa-clock-o"><a href="#"></i> hours</span></a>
                    <span class="tag-meta"><i class="fa fa-location-arrow"></i><a href="#">location</a></span>
					<span><i class="material-icons"><a onclick="openFormMenu()">restaurant_menu</i> menu</a>
					
						<!-- Menu form with checkbox for menu items and corresponding dropdowns to select quantity and view price-->
						<div class="form-popup" id="myFormMenu">
						  <form class="form-container" style="max-width: 1000px; " method="post" action="listingDetail.php">
							<h1>Menu</h1>
							<div class="row">
							  <div class="column">
								<h2>Cakes</h2>
								<p>
									<label class="chkcontainer">Pancakes
									  <input type="checkbox" checked="checked" name="item[]" value="Pancakes">
									  <span class="checkmark"></span>
									  
									  <select id="QuantityPancake" name='Quantity'
                                      onchange="calculatePancake()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($10)</option>
                                      <option value="two">Two($20)</option>
                                      <option value="three">Three($30)</option>
                                      <option value="Four">Four($40)</option>
                                      <option value="Five">Five($50)</option>
									  </select>
									  
									</label>
									<label class="chkcontainer">Waffles
									  <input type="checkbox" name="item[]" value="Waffles">
									  <span class="checkmark"></span>
									  
									  <select id="QuantityWaffles" name='Quantity'
                                      onchange="calculateWaffle()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($20)</option>
                                      <option value="two">Two($40)</option>
                                      <option value="three">Three($60)</option>
                                      <option value="Four">Four($80)</option>
                                      <option value="Five">Five($100)</option>
									  
									  </select>
									  
									</label>
									<label class="chkcontainer">Waffly Pancake
									  <input type="checkbox" name="item[]" value="Waffly Pancake">
									  <span class="checkmark"></span>
									  
									  <select id="QuantityWafflyPancake" name='Quantity'
                                      onchange="calculateWafflyPancake()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($15)</option>
                                      <option value="two">Two($30)</option>
                                      <option value="three">Three($45)</option>
                                      <option value="Four">Four($60)</option>
                                      <option value="Five">Five($75)</option>
									  </select>
									  
									</label>
									<label class="chkcontainer">Pancakey Waffles
									  <input type="checkbox" name="item[]" value="Pancakey Waffles">
									  <span class="checkmark"></span>
									  
									  <select id="QuantityPancakeyWaffles" name='Quantity'
                                      onchange="calculatePancakey Waffles()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($10)</option>
                                      <option value="two">Two($20)</option>
                                      <option value="three">Three($30)</option>
                                      <option value="Four">Four($40)</option>
                                      <option value="Five">Five($50)</option>
									  </select>
									  
									</label>								
							  </div>
							  <div class="column">
								<h2>Proteins</h2>
								<p>
								<label class="chkcontainer">Grilled Chicken
								  <input type="checkbox" checked="checked" name="item[]" value="Grilled Chicken">
								  <span class="checkmark"></span>
								  
								  <select id="QuantityGrilledChicken" name='Quantity'
                                      onchange="calculateTotal()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($20)</option>
                                      <option value="two">Two($40)</option>
                                      <option value="three">Three($60)</option>
                                      <option value="Four">Four($80)</option>
                                      <option value="Five">Five($100)</option>
									  </select>
								  
								</label>
								<label class="chkcontainer">Fried Bacon
								  <input type="checkbox" name="item[]" value="Fried Bacon">
								  <span class="checkmark"></span>
								  
								  <select id="QuantityFriedBacon" name='Quantity'
                                      onchange="calculateTotal()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($15)</option>
                                      <option value="two">Two($30)</option>
                                      <option value="three">Three($45)</option>
                                      <option value="Four">Four($60)</option>
                                      <option value="Five">Five($75)</option>
									  </select>
								  
								</label>
								<label class="chkcontainer">Grilled Tuna
								  <input type="checkbox" name="item[]" value="Grilled Tuna">
								  <span class="checkmark"></span>
								  
								  <select id="QuantityGrilledTuna" name='Quantity'
                                      onchange="calculateTotal()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($10)</option>
                                      <option value="two">Two($20)</option>
                                      <option value="three">Three($30)</option>
                                      <option value="Four">Four($40)</option>
                                      <option value="Five">Five($50)</option>
									  </select>
								  
								</label>
								<label class="chkcontainer">Baked Tofu
								  <input type="checkbox" name="item[]" value="Baked Tofu">
								  <span class="checkmark"></span>
								  
								  <select id="QuantityBakedTofu" name='Quantity'
                                      onchange="calculateTotal()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($10)</option>
                                      <option value="two">Two($20)</option>
                                      <option value="three">Three($30)</option>
                                      <option value="Four">Four($40)</option>
                                      <option value="Five">Five($50)</option>
									  </select>
								  
								</label>
							    </p>
							  </div>
							  <div class="column">
								<h2>Drinks & Beverages</h2>
								<p>
								<label class="chkcontainer">Tea
								  <input type="checkbox" checked="checked" name="item[]" value="Tea">
								  <span class="checkmark"></span>
								  
								  <select id="QuantityTea" name='Quantity'
                                      onchange="calculateTotal()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($5)</option>
                                      <option value="two">Two($10)</option>
                                      <option value="three">Three($15)</option>
                                      <option value="Four">Four($20)</option>
                                      <option value="Five">Five($30)</option>
									  </select>
								  
								</label>
								<label class="chkcontainer">Coffee
								  <input type="checkbox" name="item[]" value="Coffee">
								  <span class="checkmark"></span>
								  
								  <select id="QuantityCoffee" name='Quantity'
                                      onchange="calculateTotal()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($5)</option>
                                      <option value="two">Two($10)</option>
                                      <option value="three">Three($15)</option>
                                      <option value="Four">Four($20)</option>
                                      <option value="Five">Five($30)</option>
									  </select>
								  
								</label>
								<label class="chkcontainer">Lemonade
								  <input type="checkbox" name="item[]" value="Lemonade">
								  <span class="checkmark"></span>
								  
								  <select id="QuantityLemonade" name='Quantity'
                                      onchange="calculateTotal()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($5)</option>
                                      <option value="two">Two($10)</option>
                                      <option value="three">Three($15)</option>
                                      <option value="Four">Four($20)</option>
                                      <option value="Five">Five($30)</option>
									  </select>
								  
								</label>
								<label class="chkcontainer">Milkshake
								  <input type="checkbox"name="item[]" value="Milkshake">
								  <span class="checkmark"></span>
								  
								  <select id="QuantityMilkshake" name='Quantity'
                                      onchange="calculateTotal()">
                                      <option value="None">Select Quantity</option>
                                      <option value="one">one($5)</option>
                                      <option value="two">Two($10)</option>
                                      <option value="three">Three($15)</option>
                                      <option value="Four">Four($20)</option>
                                      <option value="Five">Five($30)</option>
									  </select>
								  
								</label>
							</p>
							  </div>
							</div>

							<button type="submit" class="btn" name="btn_checkout" value="Checkout" >Continue to Checkout</button>
							<button type="button" class="btn cancel" onclick="closeFormMenu()">Close</button>
						  </form>
						</div>
					</span>
					<script>
					function openFormMenu() {
					  document.getElementById("myFormMenu").style.display = "block";
					}

					function closeFormMenu() {
					  document.getElementById("myFormMenu").style.display = "none";
					}
					
					
					</script>
					
					<span><i class="fa fa-comments-o"></i> <a href="#">6 comments</a></span>
					<span><i class="fa fa-shopping-cart"></i> <a href="test.html">Checkout</a></span>
                  </div>
                  <div class="entry-content">
				  <b><h2>Owner Info</h2></b>
				  <?php
			  //retreiving and displaying owner information and store hours and location.
					$db=mysqli_connect("localhost","root","","testdb");
					$info = mysqli_query($db,"select information from listing where name='Mikes Breakfast'");
					$rowinfo = $info->fetch_assoc();
					
					echo "{$rowinfo['information']}";
					
				  
				  ?>
                    
                    <blockquote>
					<b><h2>Store Hours</h2></b>
                      <p>
					  <?php
						$time = mysqli_query($db,"select time from listing where name='Mikes Breakfast'");
						$rowtime = $time->fetch_assoc();
					
						echo "{$rowtime['time']}";
					  ?>
					  
					  </p>
                    <b><h2>Location</h2></b>
						<p>
						<?php
						$loc = mysqli_query($db,"select location from listing where name='Mikes Breakfast'");
						$rowloc = $loc->fetch_assoc();
					
						echo "{$rowloc['location']}";
					  ?>
						</p>
					
					</blockquote>
                    
                  </div>
                </div>
              </article>
              <div class="clear"></div>
              <div class="single-post-comments">
                <div class="comments-area">
                  <div class="comments-heading">
                    <h3>Reviews</h3>
                  </div>
                  <div class="comments-list">
                    <ul>
                      <li class="threaded-comments">
                        <div class="comments-details">
                          <div class="comments-list-img">
                            <img src="img/team/1.jpg" width="60" height="80" alt="post-author" style="border-radius:50%;">
                          </div>
                          <div class="comments-content-wrap">
                            <span><!-- Displaying reviews of users -->
								<b><a href="#"><?php
								
									$loc = mysqli_query($db,"select name from reviews where name='Bhupendra'");
									$rowloc = $loc->fetch_assoc();
						
									echo "{$rowloc['name']}";
								?></a></b>
																
                            <p><?php
								
								$loc = mysqli_query($db,"select review from reviews where name='Bhupendra'");
								$rowloc = $loc->fetch_assoc();
							
								echo "{$rowloc['review']}";
							?></p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="comments-details">
                          <div class="comments-list-img">
                            <img src="img/team/2.jpg" width="60" height="80" alt="post-author" style="border-radius:50%;">
                          </div>
                          <div class="comments-content-wrap">
                            <span>
							
							<b><a href="#"><?php
								
								$loc = mysqli_query($db,"select name from reviews where name='Munmun'");
								$rowloc = $loc->fetch_assoc();
					
								echo "{$rowloc['name']}";
							?></a></b>
																
                            <p><?php
								
								$loc = mysqli_query($db,"select review from reviews where name='Munmun'");
								$rowloc = $loc->fetch_assoc();
							
								echo "{$rowloc['review']}";
							?></p>
                          </div>
                        </div>
                      </li>
                      <li class="threaded-comments">
                        <div class="comments-details">
                          <div class="comments-list-img">
                            <img src="img/team/3.jpg" width="60" height="80" alt="post-author" style="border-radius:50%;">
                          </div>
                          <div class="comments-content-wrap">
                            <span>
								<b><a href="#"><a href="#"><?php
								
									$loc = mysqli_query($db,"select name from reviews where name='Akash'");
									$rowloc = $loc->fetch_assoc();
						
									echo "{$rowloc['name']}";
								?></a></b>
																
                            <p><?php
								
								$loc = mysqli_query($db,"select review from reviews where name='Akash'");
								$rowloc = $loc->fetch_assoc();
							
								echo "{$rowloc['review']}";
							?></p>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="comment-respond">
                  <h3 class="comment-reply-title">Leave a Review </h3>
                  <span class="email-notes">Required fields are marked *</span>
			<!-- review form to take users name(currently logged into system) along with user review to store to database.-->
                  <form method="POST" action="listingDetail.php">
                    <div class="row">

                        <p><label for="name"><b>Review *</b></label></p>
                        <textarea id="message-box" cols="30" name="review" value="review"rows="10"></textarea>
                        <button type="submit" class="btn" name="post_btn" value="Post" onclick="validatePost()">Post</button>
                      
                    </div>
                  </form>
                </div>
              </div>
			  
			  
  <script>
	  //Script to show user that their review has been successfully posted.
	function validatePost(){
		alert("Congratulations your review has been posted!");
	}
	
  </script>
			  
			  
              <!-- single-blog end -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Blog Area -->
  <div class="clearfix"></div>

  <!-- Start Footer bottom Area -->
  <footer>
    <div class="footer-area">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="footer-content">
              <div class="footer-head">
                <div class="footer-logo">
                  <h2><span>Foodz</span>Pa</h2>
                </div>

                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.</p>
                <div class="footer-icons">
                  <ul>
                    <li>
                      <a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-google"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-pinterest"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- end single footer -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="footer-content">
              <div class="footer-head">
                <h4>information</h4>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
                </p>
                <div class="footer-contacts">
                  <p><span>Tel:</span> +123 456 789</p>
                  <p><span>Email:</span> contact@example.com</p>
                  <p><span>Working Hours:</span> 9am-5pm</p>
                </div>
              </div>
            </div>
          </div>
          <!-- end single footer -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="footer-content">
              <div class="footer-head">
                <h4>Instagram</h4>
                <div class="flicker-img">
                  <a href="#"><img src="img/portfolio/1.jpg" alt=""></a>
                  <a href="#"><img src="img/portfolio/2.jpg" alt=""></a>
                  <a href="#"><img src="img/portfolio/3.jpg" alt=""></a>
                  <a href="#"><img src="img/portfolio/4.jpg" alt=""></a>
                  <a href="#"><img src="img/portfolio/5.jpg" alt=""></a>
                  <a href="#"><img src="img/portfolio/6.jpg" alt=""></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-area-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="copyright text-center">
              <p>
                &copy; Copyright <strong>eBusiness</strong>. All Rights Reserved
              </p>
            </div>
            <div class="credits">
              <!--
                All the links in the footer should remain intact.
                You can delete the links only if you purchased the pro version.
                Licensing information: https://bootstrapmade.com/license/
                Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=eBusiness
              -->
              Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/venobox/venobox.min.js"></script>
  <script src="lib/knob/jquery.knob.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/parallax/parallax.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/nivo-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
  <script src="lib/appear/jquery.appear.js"></script>
  <script src="lib/isotope/isotope.pkgd.min.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <script src="js/main.js"></script>
</body>

</html>
