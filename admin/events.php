<?php include("adminheader.php"); ?>
<?php
  if(!$_SESSION["admin"])
  {
  	$_SESSION["message"]="Please login to continue !";
  	header("Location:login.php");
  }
?>

<?php
  if(isset($_POST['host']) && ! empty ($_POST['host']))
  {
    $event_name=mysqli_real_escape_string($conn,$_POST['event-name']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $venue=mysqli_real_escape_string($conn,$_POST['venue']);
    $city=mysqli_real_escape_string($conn,$_POST['city']);
    $start_date=mysqli_real_escape_string($conn,$_POST['start-date']);
    $end_date=mysqli_real_escape_string($conn,$_POST['end-date']);
    $query="Insert into `event` (`name`,`type`,`venue`,`city`,`start-date`,`end-date`,`registrations`,`active`,`host`,`description`) values('$event_name','$type','$venue','$city','$start_date','$end_date','1','0','GoGreen','file')";
    $result=$db->insertQuery($query);
    header("Location:events.php");
  }
?>

  <link rel="stylesheet" href="extra/style.css">
  <link rel="stylesheet" href="extra/dashboard.css">
  <title>Admin Dashboard</title>
  <style media="screen">
    button{
      z-index: 100;
    }
  </style>
</head>
<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
        </button>
      </div>
      <div class="img bg-wrap text-center py-4" style="background-image: url(../images/adminav.jpg);">
        <div class="user-logo">
          <div class="img" style="background-image: url(images/logo.jpg);"></div>
          <h3>Hello Admin</h3>
        </div>
      </div>
      <ul class="list-unstyled components mb-5">
        <li>
          <a href="dashboard.php"><span class="fas fa-adjust mr-3 notif"></span>Dashboard</a>
        </li>
        <li>
            <a href="issues.php"><span class="fa fa-bell mr-3 notif"></span>Issues</a>
        </li>
        <li>
          <a href="challenges.php"><span class="fa fa-gift mr-3"></span>Challenges</a>
        </li>
        <li class="active">
          <a href="events.php"><span class="fa fa-trophy mr-3"></span>Events</a>
        </li>
        <li>
          <a href="setting.php"><span class="fa fa-cog mr-3"></span> Settings</a>
        </li>
        <li>
          <a href="logout.php"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
        </li>
      </ul>

    </nav>

    <div id="content" class="events p-4 p-md-5 pt-5">

      <div class="bg-title">
            <h2 class="float-left"> Event Request </h2>
            <button type="button" class="btn btn-success btn-lg  float-right" data-toggle="modal" data-target="#hostevent">Host An Event!</button>
            <div style="clear:both"> </div>
      </div>





      <div class="row">
        <?php
          $sql = "SELECT * FROM event WHERE active = '0'";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
          <div class="col-lg-3 col-sm-6 col-xs-12">
              <div style="padding:15px">
                <div class="card shadow-lg mb-5 bg-white rounded" style="width:100%;">
                  <img src="../images/adminav.jpg" width="100%" height="200px" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title"><?= $row['name'] ?></h5>
                    <div class="card-text">
                      <li><b>Start Time:</b><?= $row['start-date'] ?></li>
                      <li><b>End Time:</b> <?= $row['end-date'] ?></li>
                      <li><b>Venue:</b> <?= $row['venue'] ?> </li>
                      <li><b>Registration Fees:</b> N/A </li>
                      <li><b>Hosted By:</b> <?= $row['host'] ?> </li>
                      <li><b>Event details:</b> <a href="" class="text-primary" data-toggle="modal" data-target="#view" data-title=<?=  $row['name'] ?> data-link=<?=  $row['description'] ?>>View</a> </li>
                    </div>
                    <br>
                    <a href="editevent.php?eid=<?= $row['evid'] ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="events.php?acc=1&eid=<?= $row['evid'] ?>" class="btn btn-sm btn-primary">Approve</a>
                    <a href="events.php?acc=0&eid=<?= $row['evid'] ?>" class="btn btn-sm btn-danger">Decline</a>
                  </div>
                </div>
              </div>
          </div>
          <?php
            }}
          ?>
        </div>

        <div class="row bg-title">
                <h2>Live Events</h2> <br> <br> <br>
        </div>
        <div class="row">
          <?php
            $sql = "SELECT * FROM event WHERE active = '0'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
          ?>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div style="padding:15px">
                  <div class="card shadow-lg mb-5 bg-white rounded" style="width:100%;">
                    <img src="../images/adminav.jpg" width="100%" height="200px" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title"><?= $row['name'] ?></h5>
                      <div class="card-text">
                        <li><b>Start Time:</b><?= $row['start-date'] ?></li>
                        <li><b>End Time:</b> <?= $row['end-date'] ?></li>
                        <li><b>Venue:</b> <?= $row['venue'] ?> </li>
                        <li><b>Registration Fees:</b> N/A </li>
                        <li><b>Hosted By:</b> <?= $row['host'] ?> </li>
                        <li><b>Event details:</b> <a href="" class="text-primary" data-toggle="modal" data-target="#view" data-title=<?=  $row['name'] ?> data-link=<?=  $row['description'] ?>>View</a> </li>
                      </div>
                      <br>
                      <a href="editevent.php?eid=<?= $row['evid'] ?>" class="btn btn-sm btn-info">Edit</a>
                      <a href="events.php?acc=4&eid=<?= $row['evid'] ?>" class="btn btn-sm btn-primary">Users</a>
                      <a href="events.php?acc=3&eid=<?= $row['evid'] ?>" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                  </div>
                </div>
            </div>
            <?php
              }}
            ?>
          </div>




        <!--  Models -->
        <div class="modal fade" id="hostevent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Host A New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form" method="post" action="events.php">
                  <div class="row">
                  	<div class="col-sm-12">
                    	<div class="form-group">
                    <label for="recipient-name" class="form-control-label">Event Name</label>
                    <input type="text" class="form-control" name="event-name"  placeholder="Enter event name" required>
                  </div>
                    </div>
                  </div>
                  <div class="row">
                  	<div class="col-sm-12">
                    	<div class="form-group">
                    <label for="recipient-name" class="form-control-label">Type</label>
                    <select class="form-control" name="type">
                      <option value="cleanliness">Cleanliness Drive</option>
                      <option value="tree-plantation">Tree plantation</option>
                      <option value="awareness">Awareness</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                    </div>
                  </div>
                  <div class="row">
                  	<div class="col-sm-6">
                    	<div class="form-group">
                    <label for="recipient-name" class="form-control-label">Venue</label>
                    <input type="text" class="form-control" name="venue"  placeholder="Enter Venue" required>
                  </div>
                    </div>
                    <div class="col-sm-6">
                    	<div class="form-group">
                    <label for="recipient-name" class="form-control-label">City</label>
                    <input type="text" class="form-control" name="city"  placeholder="Enter City" required>
                  </div>
                    </div>
                  </div>
                  <div class="row">
                  	<div class="col-sm-6">
                    	<div class="form-group">
                    <label for="recipient-name" class="form-control-label">Start Date</label>
                    <input type="date" class="form-control" name="start-date"  placeholder="Enter start date" required>
                  </div>
                    </div>
                    <div class="col-sm-6">
                    	<div class="form-group">
                    <label for="recipient-name" class="form-control-label">End Date</label>
                    <input type="date" class="form-control" name="end-date"  placeholder="Enter end  date" required>
                  </div>
                    </div>
                  </div>
                  <div class="row">
                  	<div class="col-sm-12">
                    	<div class="form-group">
                    <label for="recipient-name" class="form-control-label">Description</label><br>
                    <input type="file"  name="description"  placeholder="Enter Description" required>
                  </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="host" value="host" class="btn btn-secondary">Host!</button>
              </div>
            </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Details of </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body details">
                <object>

                </object>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
            </div>
          </div>
        </div>

    </div>
  </div>

  <script type="text/javascript">
    $('#view').on('show.bs.modal', function (event) {
      console.log("here");
      var button = $(event.relatedTarget);
      var title = button.data('title');
      var link = button.data('link');
      var modal = $(this);
      modal.find('.modal-title').text('Details of ' + title);
      $("object").repaceWith('<object width="600" height="600" data="'+link+'"></object>');
    });
  </script>
  <script src="../lib/jquery.min.js"></script>
  <script src="../lib/Bootsrap/js/bootstrap.min.js"></script>
  <script src="extra/admindashboard.js"></script>
</body>
</html>
