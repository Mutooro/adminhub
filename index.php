<?php
include '../emg_admin/config.php';

session_start();
// After successful login
$_SESSION['login_time'] = time();


// Check if the user just logged in
if (isset($_SESSION['name']) && isset($_SESSION['login_time'])) {
	$sessionTimeoutSeconds = 60; // Set the session timeout to 30 minutes (1800 seconds)

    // Calculate the elapsed time since login
    $elapsedTime = time() - $_SESSION['login_time'];

    // Check if the elapsed time exceeds the session timeout
    if ($elapsedTime > $sessionTimeoutSeconds) {
        // Session has timed out, perform necessary actions
        // For example, you can unset session variables and redirect the user to the login page
        unset($_SESSION['login_time']);
        header("Location: ../index.php"); // Replace "login.php" with your actual login page URL
        exit;
    }
} else {
    // User is not logged in, handle accordingly
	header('Location: ../index.php"');
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->

	<title>Dashboard</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">MAKSports</span>
		</a>
		<ul class="side-menu top" style="">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="../imageandtext.php">
					<i class='bx bxs-user' ></i>
					<span class="text">Register Player</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li>
				<a href="../standings.php">
					<i class='bx bxs-chart' ></i>
					<span class="text">Table standings</span>
				</a>
			</li>
			<li>
				<a href="../selectedsquad.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout" id="logoutLink">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search"  placeholder="Search...">
					<button type="submit" name="search" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>

			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			
			
	
				<a href="#" style="font-size: larger;"><span class="bx bxs-user"></span > <?php echo $_SESSION['name']; ?></a>
				
			
			
			
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-user' ></i>
					<span class="text">
						<h3><?php 
						
						//fetching user data
						$query = "select count(*) as userCount from fileupload";
						$result = $con->query($query);

						if($result !== false){
							$row = $result->fetch(PDO::FETCH_ASSOC);
							$userCount = $row['userCount'];
						}else{
							$userCount =0;
						}
						echo $userCount;

						?></h3>
						<p>Players</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3>
							<?php
						//fetching user data
						$query = "select count(*) as userCount from teamselect";
						$result = $con->query($query);

						if($result !== false){
							$row = $result->fetch(PDO::FETCH_ASSOC);
							$userCount = $row['userCount'];
						}else{
							$userCount =0;
						}
						echo $userCount;

						?>
						</h3>
						<p>Selected Players</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-user' ></i>
					<span class="text">
						<h3>
						<?php
						//fetching user data
						$query = "select count(*) as userCount from  leagueone";
						$result = $con->query($query);

						if($result !== false){
							$row = $result->fetch(PDO::FETCH_ASSOC);
							$userCount = $row['userCount'];
						}else{
							$userCount =0;
						}
						echo $userCount;

						?>
						</h3>
						<p>Registered Teams</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order" style="background-color: ;">
					<div class="head">
						<h3 style="color: indigo;">Table standings</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
					
						<thead>
							<tr>
							
							  <th scope="col"> TEAMS</th>
							  <th>P</th>
							  <th>w</th>
							  <th>L</th>
							  <th>D</th>
							  
							  <th scope="col">PTS</th>
						  </tr>
						  </thead>
						
						<tbody>
							<?php
						  $stmt = $db->runQuery("SELECT * FROM leagueone ORDER BY points DESC limit 5");
						  $stmt->execute();
						  while($rows = $stmt->fetch()){
							  $id = $rows['team'];
							  $goalsfor1 = $rows['playedgames'];
							  $goalsagainst1 = $rows['wins'];
							  
							  $hometeam = $rows['loss'];
							  $awayteam = $rows['draws'];
						
							  $pts = $rows['points'];
						  
							  echo '<tr>
							  
							  <td>'.$id.'</td>
							  
							  <td>'.$goalsfor1.'</td>
							  
							  <td>'.$goalsagainst1.'</td>
							  
							  <td>'.$hometeam.'</td>
							  <td>'.$awayteam.'</td>
							
							  <td>'.$pts.'</td>
							  
							</tr>';
						    
						  
						  }
						  ?>
						  </tbody>
					</table>
				</div>
				<div class="todo">
					<div class="head">
						<h3>Results</h3>
						<i class='bx bx-plus' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						
						<thead>
						<tr>
    
							<th scope="col">HOME TEAM</th>
							<th scope="col">SCORES</th>
							<th scope="col">AWAY TEAM</th>
							<th scope="col">SCORES</th>
							</tr>
						  </thead>
						
						<tbody>
											<?php
						$stmt = $db->runQuery("SELECT * FROM matchestable limit 5 ");
						$stmt->execute();
						while($rows = $stmt->fetch()){
						$id = $rows['id'];
						$goalsfor1 = $rows['goalsfor'];
						$goalsagainst1 = $rows['goalsagainst'];

						$hometeam = $rows['hometeam'];
						$awayteam = $rows['awayteam'];

						echo '<tr>

						<td>'.$hometeam.'</td>
						<td>'.$goalsfor1.'</td>
						<td>'.$awayteam.'</td>
						<td>'.$goalsagainst1.'</td>
						<td>
						</td>
						</tr>';
						
						}
						?>
												</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
<script>
document.getElementById('logoutLink').onclick = function(){
	if(confirm("Are you sure u want to log out?")){
		window.location.href="../logout.php";
	}
}
</script>
</html>