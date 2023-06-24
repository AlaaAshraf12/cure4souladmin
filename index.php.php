<?php require_once "connection.php"; 
$conn = OpenConnection();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Weekly Schedule</title>
  <style>
    
        /* navbar */
        * {
            box-sizing: border-box;
          }
          
          body {
            margin: 0px;
            font-family: 'segoe ui';
          }
          
          .nav {
            height: 50px;
            width: 100%;
            background-color: #4d4d4d;
            position: relative;
          }
          
          .nav > .nav-header {
            display: inline;
          }
          
          .nav > .nav-header > .nav-title {
            display: inline-block;
            font-size: 22px;
            color: #fff;
            padding: 10px 10px 10px 10px;
          }
          
          .nav > .nav-btn {
            display: none;
            
          }
          
          .nav > .nav-links {
            display: inline;
            float: right;
            font-size: 18px;
            padding-right:40px
          }
          
          .nav > .nav-links > a {
            display: inline-block;
            padding: 13px 10px 13px 10px;
            text-decoration: none;
            color: #efefef;
          }
          
          .nav > .nav-links > a:hover {
            background-color: rgba(0, 0, 0, 0.3);
          }
          
          .nav > #nav-check {
            display: none;
          }
          
          @media (max-width:600px) {
            .nav > .nav-btn {
              display: inline-block;
              position: absolute;
              right: 0px;
              top: 0px;
            }
            
        
            .nav > .nav-btn > label {
              display: inline-block;
              width: 50px;
              height: 50px;
              padding: 13px;
            }
            .nav > .nav-btn > label:hover,.nav  #nav-check:checked ~ .nav-btn > label {
              background-color: rgba(0, 0, 0, 0.3);
            }
            .nav > .nav-btn > label > span {
              display: block;
              width: 25px;
              height: 10px;
              border-top: 2px solid #eee;
            }
            .nav > .nav-links {
              position: absolute;
              display: block;
              width: 100%;
              background-color:#164277;
              height: 0px;
              transition: all 0.3s ease-in;
              overflow-y: hidden;
              top: 50px;
              left: 0px;
              margin-left:-5px;
            }
            .nav > .nav-links > a {
              display: block;
              width: 100%;
            }
            .nav > #nav-check:not(:checked) ~ .nav-links {
              height: 0px;
            }
            .nav > #nav-check:checked ~ .nav-links {
              height: calc(100vh - 50px);
              overflow-y: auto;
            }
          }
          .nav-title{margin-left: 80px;}
          .btn{margin-left: 60px;}
          .nav-links{padding-left:20px;margin-left: 20px;}
      
    body {
      font-family: Arial, sans-serif;
    }
    form {
      width: 300px;
      margin: 0 auto;
    }
    label {
      display: block;
      margin-top: 10px;
    }
    select, input[type="time"] {
      width: 100%;
      padding: 5px;
      margin-top: 5px;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>


<body style="background-color: #f0f7f8;">
  <!--navbar--> 
  <div class="nav" style="height:60px;background-color:#164277">
        <input type="checkbox" id="nav-check">
        <div class="nav-header">
          <div class="nav-title">
            
            <a href="home.html" class="logo" style="color: white;font-size:30px; font-weight: bold; padding-left: 20px;text-decoration: none;">cure4soul<span class="dot" style="color: #00c3da;">.</span></a>
        </div>
        </div>
        <div class="nav-btn">
          <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
          </label>
        </div>
        
        <div class="nav-links">
            <a href="power.html">Dashboard</a>
            <a href="addschedule.php">Add therapist schedule</a>
            
            
       
        </div>
        </div>
  <h2 style="text-align:center;color:#164277">Add Weekly Schedule</h2>
  <form method="POST" style="border-style:solid; width:500px; height:500px;border-color:lightgrey;padding:30px">
    <label for="therapist">Therapist:</label>
    <select name="therapist" id="therapist">
      <?php
      // Retrieve therapist options from the database
      $sql = "SELECT tid, name FROM therapist";
      $result = sqlsrv_query($conn, $sql);

      while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo '<option value="' . $row["tid"] . '"> ' . $row["name"] . '</option>';
      }
      ?>
    </select>
    <label for="day">Day:</label>
    <select name="day" id="day">
      <option value="Sunday">Sunday</option>
      <option value="Monday">Monday</option>
      <option value="Tuesday">Tuesday</option>
      <option value="Wednesday">Wednesday</option>
      <option value="Thursday">Thursday</option>
      <option value="Friday">Friday</option>
      <option value="Saturday">Saturday</option>
    </select>
    <label for="time">Time:</label>
    <input type="time" name="time" id="time">
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required><br><br>
    <input type="submit" name='Submit' value="Save" style="width:140px;">
  </form>


  <?php
// Handle form submission
if (isset($_POST['Submit'])) {
  $therapistId = $_POST["therapist"];
  $day = $_POST["day"];
  $time = $_POST["time"];
  $date = $_POST["date"];
  $status = "unbooked";
  $attendStatus = "pending";

  // Insert the schedule into the sessions table
  $sql = "INSERT INTO sessions (dayy, date, Time1, status, attendstatus, tid) 
          VALUES (?, ?, ?, ?, ?, ?)";

  $params = array($day, $date, $time, $status, $attendStatus, $therapistId);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($stmt === false) {
    echo "Error: " . sqlsrv_errors()[0]['message'];
  } else {
    echo "Schedule added successfully.";
  }
}
?>
</body>
</html>

