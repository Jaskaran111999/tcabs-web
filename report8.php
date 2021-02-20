<?php
	require_once("classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: login.php');
	} else {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
		}
	}
  if(isset($_POST['search'])) {
    $firsttable = TRUE;
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT unitCode,term,year,team.TeamName,project.ProjectName From unitoffering
    INNER JOIN offeringproject ON unitoffering.unitOfferingID = offeringproject.UnitOfferingID
    INNER JOIN project ON offeringproject.ProjectName = project.ProjectName
    INNER JOIN teamprojects ON project.ProjectName = teamprojects.ProjectName
    INNER JOIN team ON teamprojects.TeamID = team.TeamID
    WHERE CONCAT(`TeamName`,`term`,`year`,`unitCode`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
  }
  else if(isset($_POST['details'])) {
  $firsttable = FALSE;
  $TeamName = $_POST['details'];
    $query = "SELECT users.gender,users.email,team.TeamName,supervisormeeting.MeetingID,StartTime,EndTime,Location,fName,lName,email,pNum From team
    INNER JOIN supervisormeeting ON team.TeamID = supervisormeeting.TeamID
    INNER JOIN meetingattendees ON supervisormeeting.MeetingID = meetingattendees.MeetingID
    INNER JOIN teammember ON meetingattendees.TeamMemberID = teammember.TeamMemberID
    INNER JOIN enrolment ON teammember.EnrolmentID = enrolment.enrolmentID
    INNER JOIN users ON enrolment.sUserName = users.email
    WHERE team.TeamName LIKE '".$TeamName."'";
    $search_result = filterTable($query);

		$query1 = "SELECT users.fName,users.lName,project.ProjectName,project.ProjectDescription,users.pNum,users.email FROM project
		INNER JOIN teamprojects ON project.ProjectName = teamprojects.ProjectName
		INNER JOIN team ON teamprojects.TeamID = team.TeamID
		INNER JOIN offeringstaff ON team.OfferingStaffID = offeringstaff.OfferingStaffID
		INNER JOIN users ON offeringstaff.UserName = users.email
		WHERE team.TeamName LIKE '".$TeamName."'";
		$search_result1 = filterTable($query1);
}
 else {
    $firsttable = TRUE;
    $query = "SELECT unitCode,term,year,team.TeamName,project.ProjectName From unitoffering
    INNER JOIN offeringproject ON unitoffering.unitOfferingID = offeringproject.UnitOfferingID
    INNER JOIN project ON offeringproject.ProjectName = project.ProjectName
    INNER JOIN teamprojects ON project.ProjectName = teamprojects.ProjectName
    INNER JOIN team ON teamprojects.TeamID = team.TeamID";
    $search_result = filterTable($query);
}

function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "tcabs");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <body class="loggedin">
		<?php include "styles/stylesheet.php"; ?>
			<body class="loggedin">
				<?php include "views/header.php"; ?>

			<div class="content">
			<h2>Generated Reports</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>

			<div class="btn-group btn-group-justified">
				<?php
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='admin') { ?>
						<a href="report1.php" class="btn btn-primary">Registered Convenors</a>
				<?php }} ?>

				<?php
						$report2 = FALSE;
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='admin') {
						$report2 = TRUE;
				 	} else if($userType=='convenor') {
						$report2 = TRUE;
				 	} }
					if($report2 == TRUE) { ?>
						<a href="report2.php" class="btn btn-primary">Enrolled Students</a>
				<?php } else {}?>

				<?php
						$report3 = FALSE;
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='admin') {
						$report3 = TRUE;
					} else if($userType=='convenor') {
						$report3 = TRUE;
					} }
					if($report3 == TRUE) { ?>
						<a href="report3.php" class="btn btn-primary">Registered Supervisors</a>
				<?php } else {}?>

				<?php
						$report4 = FALSE;
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='convenor') {
						$report4 = TRUE;
					} else if($userType=='supervisor') {
						$report4 = TRUE;
					} }
					if($report4 == TRUE) { ?>
						<a href="report4.php" class="btn btn-primary">Registered Projects</a>
				<?php } else {}?>

				<?php
						$report5 = FALSE;
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='convenor') {
						$report5 = TRUE;
					} else if($userType=='supervisor') {
						$report5 = TRUE;
					} }
					if($report5 == TRUE) { ?>
						<a href="report5.php" class="btn btn-primary">Registered Teams</a>
				<?php } else {}?>

				<?php
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='supervisor') { ?>
						<a href="report6.php" class="btn btn-primary">Meeting Attendees</a>
				<?php }} ?>

				<?php
						$report7 = FALSE;
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='convenor') {
						$report7 = TRUE;
					} else if($userType=='supervisor') {
						$report7 = TRUE;
					} }
					if($report7 == TRUE) { ?>
						<a href="report7.php" class="btn btn-primary">Budget Overview</a>
				<?php } else {}?>

				<?php
						$report8 = FALSE;
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='convenor') {
						$report8 = TRUE;
					} else if($userType=='supervisor') {
						$report8 = TRUE;
					} }
					if($report8 == TRUE) { ?>
						<a href="report8.php" class="btn btn-primary">Team Overview</a>
				<?php } else {}?>

				<?php
						$report9 = FALSE;
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='convenor') {
						$report9 = TRUE;
					} else if($userType=='supervisor') {
						$report9 = TRUE;
					} }
					if($report9 == TRUE) { ?>
						<a href="report9.php" class="btn btn-primary">Unit Overview</a>
				<?php } else {}?>

				<?php
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='supervisor') { ?>
						<a href="report10.php" class="btn btn-primary">Meeting Summary</a>
				<?php }} ?>
			</div>

			<div>
				<?php
				//Check the Users role to see if they have access to this
				$roleFound = FALSE;
				foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
					if($userType=='convenor') {
						$roleFound = TRUE;
					} else if($userType=='supervisor') {
						$roleFound = TRUE;
				} }?>


				<?php
				//If they have the correct role to view the page

    if($roleFound == TRUE) {
  	if ($firsttable == TRUE) { ?>

    <p class="h4 mb-4 text-center">Team Overview</p>

    <body>
        <form action="report8.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Search.."><br><br>
            <input type="submit" name="search" value="Filter"><br><br>
            <table>
                <tr>
                  <th>Unit Code</th>
                  <th>Unit Offering Period</th>
                  <th>Team Name</th>
                  <th>Team Overview</th>
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                  <td><?php echo $row["unitCode"];?></td>
                  <td><?php echo $row["term"]; ?> - <?php echo $row["year"]; ?></td>
                  <td><?php echo $row["TeamName"]; ?></td>
                  <td><button type="submit" class="btn btn-primary" name="details" value="<?php echo $row['TeamName'];?>" >Details </button></td>
                </tr>
                <?php endwhile;?>
            </table>
            <br>
            <br>
						<div class="btn-group btn-group-justified">
              <a href="report8.php" class="btn btn-primary">Clear Search</a>
            </div>
        </form>

    </body>
<?php }
  	if ($firsttable == FALSE) { ?>

      <p class="h4 mb-4 text-center">Team Overview (<?php echo $TeamName;?>)</p>

      <body>
				<p class="h6 mb-4 text-center">Supervisor & Project</p>
              <table>
                  <tr>
										<th>Supervisor Name</th>
										<th>Email</th>
										<th>Phone Number</th>
                    <th>Project Name</th>
                    <th>Project Description</th>
									</tr>
							<?php while($row = mysqli_fetch_array($search_result1)):?>
									<tr>
										<td><?php echo $row["fName"];?> <?php echo $row["lName"];?></td>
										<td><?php echo $row["email"];?></td>
										<td><?php echo $row["pNum"];?></td>
										<td><?php echo $row["ProjectName"];?></td>
										<td><?php echo $row["ProjectDescription"]; ?></td>
									</tr>
							<?php endwhile;?>
						</table>
						<br>
							<p class="h6 mb-4 text-center">Students</p>
						<table>
									<tr>
                    <th>Student Name</th>
                    <th>Email</th>
										<th>Phone Number</th>
										<th>Gender</th>
                  </tr>
							<?php while($row = mysqli_fetch_array($search_result)):?>
									<tr>
                    <td><?php echo $row["fName"]; ?> <?php echo $row["lName"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
										<td><?php echo $row["pNum"];?></td>
										<td><?php echo $row["gender"];?></td>

                  </tr>
							<?php endwhile;?>
              </table>
              <br>
              <br>
							<div class="btn-group btn-group-justified">
	              <a href="report8.php" class="btn btn-primary">Clear Search</a>
	            </div>
          </form>

      </body>

<?php }}
	//If they dont have correct permission
if ($roleFound == FALSE) { ?>

		<h2>Permission Denied</h2>
		<div>
		<p>Sorry, you do not have access to this page. Please contact your administrator.</p>
		</div>
	<?php  }  ?>
		</div>
	</div>
</body>
<?php include "views/footer.php"; ?>
</html>
