<?php
include '../emg_admin/config.php';

session_start();
// After successful login


if(!isset($_SESSION['name'])){
	header('location:../index.php');
	exit();

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
	<style>
	.hover-effect:hover {
  background-color: #f5f5f5;
  cursor: pointer;
  transform: scale(1.1); 
  transition: transform 0.3s ease;
}
.nav{
	background-color: green !important;
	
}
.side{
	background-color:red;
}

</style>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar" style=" background: linear-gradient(to right, #FF0000, #00FF00, #000000);" >
		<a href="#" class="brand" style=" background: linear-gradient(to right, #FF0000, #00FF00, #000000);">
			<!-- <i class='bx bxs-smile'></i> -->
			<img src="../img/muk.jpeg" style="height:100%; width:20% padding:10px; margin:15px">

			
			<span class="text" style="color:white"> Makarere Sports System </span>
		</a>
		<ul class="side-menu top" >
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
				<a href="../playerrate.php">
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
				<a href="../data.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#" id="resetPass">
					<i class='bx bxs-cog' ></i>
					<span class="text">Change password</span>
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
		<nav class="nav">
			<i class='bx bx-menu'  style="color:white;"></i>
			<a href="#" class="nav-link"  style="color:white;">Categories</a>
			<form action="#">
				
			</form>

			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			
			
	
				<a href="#" style="font-size: larger; color: white;"><span class="bx bxs-user"></span > <?php echo $_SESSION['name']; ?></a>
				
			
			
			
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li onclick="location.href='../data.php'" class="hover-effect">
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
				<li onclick="location.href='../selectedsquad.php'" class="hover-effect">
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
				<li onclick="location.href='../standings.php'" class="hover-effect">
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
					
						<thead class="table-dark">
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
						<h3 style="color: indigo;">Top players</h3>
						<i class='bx bx-plus' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">Player</th>
                  
                    <th scope="col">Goals</th>
                    <th scope="col">Assists</th>
                    
                    <th scope="col">Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection parameters
                $host = 'localhost';
                $username = 'root';
                $password = '';
                $database = 'football';

                // PDO connection
                try {
                    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Fetch data from rateplayer table and order by rating descending
                    $sql = "SELECT * FROM rateplayer ORDER BY (
                        (goals * 5) + (assists * 1.5) + 
                        CASE
                            WHEN yellow_cards = 0 THEN 4
                            WHEN yellow_cards < 4 THEN 3
                            ELSE 0
                        END +
                        CASE
                            WHEN red_cards = 0 THEN 4
                            WHEN red_cards < 2 THEN 3
                            ELSE 0
                        END +
                        (passes_completed * 3) + (minutes_played * 1) + (motd * 3)
                    ) / 10 DESC";
                    $stmt = $conn->query($sql);
                    

                    $rank = 1;

                    // Display the data in the table
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                
                        echo "<th scope='row'>" . $rank. "</th>";
                        
                        echo "<td>" . $row['name'] . "</td>";
                        
                        echo "<td>" . $row['goals'] . "</td>";
                        echo "<td>" . $row['assists'] . "</td>";
                        
                        
                    
                        // Calculate the Rating based on your logic
                        $goals = (int)$row['goals'];
                        $assists = (int)$row['assists'];
                        $yellowCards = (int)$row['yellow_cards'];
                        $redCards = (int)$row['red_cards'];
                        $passesCompleted = (int)$row['passes_completed'];
                        $minutesPlayed = (int)$row['minutes_played'];
                        $motm = (int)$row['motd'];
                        $app = (int)$row['appearances'];
                    
                        // Calculate the weight for yellow cards based on your criteria
                        if ($yellowCards === 0) {
                            $yellowCardsWeight = 4;
                        } elseif ($yellowCards < 4) {
                            $yellowCardsWeight = 3;
                        } else {
                            $yellowCardsWeight = 0;
                        }
                    
                        // Calculate the weight for red cards based on your criteria
                        if ($redCards === 0) {
                            $redCardsWeight = 4;
                        } elseif ($redCards < 2) {
                            $redCardsWeight = 3;
                        } else {
                            $redCardsWeight = 0;
                        }
                        if($app==0){
                            $rating = 0;
                        } else{
                    
                        // Calculate the Rating
                        $rating = ($goals * 5 + $assists * 1.5 + $yellowCardsWeight + $redCardsWeight + $passesCompleted * 3 + $minutesPlayed * 1 + $motm * 3) / 100;
                    }
                        // Format the rating to 1 decimal place
                        $formattedRating = number_format($rating, 1);
                    
                        echo "<td>" . $formattedRating . "</td>";
                        echo "</tr>";

                        $rank++;
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

                // Close the database connection
                $conn = null;
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

document.getElementById('resetPass').onclick = function(){
	if(confirm("Your about to reset your password!")){
		window.location.href="resetpass2.php";
	}
}
</script>
</html>