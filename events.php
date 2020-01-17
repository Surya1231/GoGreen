<?php
include("header.php");
?>
<title>Events</title>
<link rel="stylesheet" href="css/events.css">

<link rel="stylesheet" href="css/footer2.css">
</head>
<body>

<?php
  include 'topbar.php';
  if(isset($_POST['host']) && ! empty ($_POST['host']))
  {
    $event_name=mysqli_real_escape_string($conn,$_POST['event-name']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $venue=mysqli_real_escape_string($conn,$_POST['venue']);
    $city=mysqli_real_escape_string($conn,$_POST['city']);
    $start_date=mysqli_real_escape_string($conn,$_POST['start-date']);
    $end_date=mysqli_real_escape_string($conn,$_POST['end-date']);
    $target_dir = "event-attachments/";
    $target_file = $target_dir . basename($_FILES["description"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES["description"]["tmp_name"], $target_file)) {
        // echo "The file ". basename( $_FILES["description"]["name"]). " has been uploaded.";
    } else {
        // echo "Sorry, there was an error uploading your file.";
    }
    $query="Insert into `event` (`name`,`type`,`venue`,`city`,`start-date`,`end-date`,`registrations`,`active`,`host`,`description`) values('$event_name','$type','$venue','$city','$start_date','$end_date','0','0','dhruv','$target_file')";
    $result=$db->insertQuery($query);
    header("Location:events.php");
  }

  if(isset($_POST['register']) && ! empty ($_POST['register']))
  {
    $eid=$_POST['eventid'];
    $uid=$_SESSION['uid'];
    $query="Insert into `registration` (`uid`,`type`,`eid`) values('$uid','event',$eid)";
    $result=$db->insertQuery($query);
    $updatequery="Update `event` set `registrations`=`registrations`+1 where `eid`='$eid'";
    $update=$db->updateQuery($updatequery);
  }
?>
<div class="usercontainer">
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
        <form class="form" method="post" action="events.php" enctype="multipart/form-data">
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

<div class="modal fade" id="more-info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <object width="400" height="400" data="event-attachments/dashboard.txt"></object>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Send message</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="registration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Registration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="modalp">Are you sure you want to register for this event?</p>
        <form method="post" action="events.php">
          <input type="text hidden" name="eventid">
          <div class="float-right">
            <button type="submit" name="register" value="register" class="btn btn-secondary">Yes</button>
            <button data-dismiss="modal" class="btn btn-secondary">No</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="events-body">

  <div class="new-event">
    <button type="button" class="btn btn-success btn-lg  float-right" data-toggle="modal" data-target="#hostevent">Host An Event!</button>
  </div>
<br>
<br>
<br>
  <div class="current_events">
    <h3 style="text-align:center;">Current Events</h3>
    <hr>
    <div class="row">
  <?php
    $query="Select * from event where active=1";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
       echo '

          <div class="col-md-4">
             <div class="card border-success flex-md-row mb-4 shadow-sm h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                   <strong class="d-inline-block mb-2 text-success" style="text-transform:uppercase;">'.$row["name"].'</strong>
                   <div class="mb-1 text-mute small">'.$row["start-date"].' - '.$row["end-date"].'</div>
                   <p class="card-text mb-auto">Venue : '.$row["venue"].'</p>
                   <p class="card-text mb-auto">City : '.$row["city"].'</p>
                   <p class="card-text mb-auto">'.$row["registrations"].' Total Registrations</p>
                   <div class="">
                   <button class="btn btn-outline-success btn-sm" style="display:inline;" data-toggle="modal" data-target="#registration" data-evid='.$row["evid"].' data-name='.$row["name"].'>Register</button>

                     <button type="button" class="btn btn-outline-success btn-sm" style="display:inline;" data-toggle="modal" data-target="#more-info" data-evn='.$row["name"].' data-description='.$row["description"].'>More Info</button>
                   </div>
                </div>
                <img class="card-img-right flex-auto d-none d-lg-block" alt="Thumbnail [200x250]" src="//placeimg.com/250/250/nature" style="width: 200px; height: auto;">
             </div>
          </div>

       ';
    }
  ?>
  </div>
  </div>

  <div class="past_events">
    <h3 style="text-align:center;">Past Events</h3>
    <hr>
    <div class="row">
    <?php
      $query="Select * from event where active=1";
      $result = mysqli_query($conn, $query);
      while($row = mysqli_fetch_assoc($result)) {
        echo '

        <div class="col-md-4">
           <div class="card border-success flex-md-row mb-4 shadow-sm h-md-250">
              <div class="card-body d-flex flex-column align-items-start">
                 <strong class="d-inline-block mb-2 text-success" style="text-transform:uppercase;">'.$row["name"].'</strong>
                 <div class="mb-1 text-mute small">Over</div>
                 <p class="card-text mb-auto">Venue : '.$row["venue"].'</p>
                 <p class="card-text mb-auto">City : '.$row["city"].'</p>
                 <p class="card-text mb-auto">'.$row["registrations"].' Total Participants</p>
                 <div class="">
                   <a type="button" class="btn btn-outline-success btn-sm" style="display:inline;" data-toggle="modal" data-target="#more-info" data-evn='.$row["name"].' data-description='.$row["description"].'>More Info</a>
                 </div>
              </div>
              <img class="card-img-right flex-auto d-none d-lg-block" alt="Thumbnail [200x250]" src="//placeimg.com/250/250/nature" style="width: 200px; height: auto;">
           </div>
        </div>

        ';
      }
    ?>
    </div>
</div>
</div>
<script type="text/javascript">
  $('#more-info').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var name = button.data('evn')
  var description = button.data('description')
  var modal = $(this)
  modal.find('.modal-title').text(name)
  // modal.find('.modal-body object').data(description)
  $( "object" ).replaceWith('<object width="400" height="400" data="' + description + '"></object>');
  modal.find('.modal-body input').val(name)
})

  $('#registration').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var evid = button.data('evid')
  var name = button.data('name')
  var modal = $(this)
  modal.find('.modalp').text('Are you sure you want to register for the event - '+name+' ?')
  modal.find('.modal-body input').val(evid)
})
</script>
</div>

<?php include('footer2.php') ?>
