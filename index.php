<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KPI Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-RMwXNYP5x1K2eP5d7MXV+gymrTBpdS2MI+Ic9RBs1w4k+LEwQMd5gAXOXGO6tDBVTWgF44gFpVg4GrDQ86O9qg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <!-- The bootstrap 5 tutorial is available here: https://www.w3schools.com/bootstrap5/index.php 
    and here:https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
    <!-- The Chart JS manual is available here: https://www.chartjs.org/docs/latest/charts/area.html -->
    <div class="row">
    <div class="col-md-2 bg-dark" style="position: fixed;  background-color: #171a24;">
    <div class="container mt-5">
  <div class="card1">
    <div class="card-body text-center">
      <h3 class="card-title">CV-DETECT Analytics Dashboard</h3>
    </div>
  </div>
</div>

  <div style="color:#e4a111; text-align:center;">
    <strong>BBT4106 and BBT4206: Business Intelligence Project (and BI1 Take-Away CAT 2)<br /></strong>
    <strong><br />Name:<input type="text" value="Myriam A. Mbongo" readonly class="input-field"><br /></strong>
<strong>Student ID:<input type="text" value="134141" readonly class="input-field"><br /></strong>

  </div>
  <br />
  <strong>Kaplan and Norton’s Balanced Scorecard</strong>
  <ul>
    
    <li>Financial Perspective (KPI1a and KPI1b)</li>
    <li>Customer Perspective (KPI2a and KPI2b)</li>
    <li>Internal Business Processes Perspective (KPI3a and KPI3b)</li>
    <li>Innovation and Learning Perspective (KPI4a and KPI4b)</li>
  </ul>
</div>

      <div class="col-md-10 row" style="margin-left: 17.5%">
  <!-- Start of Key Metrics -->
  <?php
  function humanize_number($input){
    $input = number_format($input);
    $input_count = substr_count($input, ',');
    if($input_count != '0'){
        if($input_count == '1'){
            return substr($input, 0, -4).'K';
        } else if($input_count == '2'){
            return substr($input, 0, -8).'M';
        } else if($input_count == '3'){
            return substr($input, 0,  -12).'B';
        } else {
            return;
        }
    } else {
        return $input;
    }
  }
  ?>
  <?php
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "SELECT AVG(satisfaction_score) AS average_score FROM patient_satisfaction  ;";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Calculate the average satisfaction score
    $totalScores = 0;
    $numRows = $result->num_rows;
  
    while($row = $result->fetch_assoc()) {
      $totalScores += $row['average_score'];
    }
  
    $averageScore = $totalScores / $numRows;
    $formattedAverageScore = number_format($averageScore, 2); // Format the average score to two decimal places
  } else {
    echo "0 results";
  }
  
  $conn->close();
  ?>
  
  <div class="col-md-3 my-1">
    <div class="card">
      <div class="card-body text-center">
      <strong>Average Patient Satisfaction Score</strong><hr>
<div class="rating">
  <h1><?= $formattedAverageScore ?>
          <span style="font-size: 44px; color: gold;">★</span>
      </h1>
 
</div>

      </div>
    </div>
  </div>
  
 
<div class="col-md-3 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>Highest Intervention Count</strong><hr>
      <h1>
        <?php
        include 'dbconfig.php';

        // Create connection
        $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT quarter, intervention_count FROM interventions WHERE intervention_count >= 100;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $highestIntervention = 0;

          // Find the highest intervention count
          while ($row = $result->fetch_assoc()) {
            if ($row['intervention_count'] > $highestIntervention) {
              $highestIntervention = $row['intervention_count'];
            }
          }

          echo $highestIntervention;
        } else {
          echo "0 results";
        }

        $conn->close();
        ?>
      </h1>
    </div>
  </div>
</div>


<div class="col-md-3 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>Average Cost Savings</strong><hr>
      <h2>KES
        <?php
        include 'dbconfig.php';

        // Create connection
        $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT AVG(cost_savings) AS average_savings FROM cost_savings;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $averageSavings = number_format($row['average_savings'], 2);

          echo $averageSavings;
        } else {
          echo "0 results";
        }

        $conn->close();
        ?><i class="fas fa-money-bill"></i>
      </h2>
    </div>
  </div>
</div>


<div class="col-md-3 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>Average Processing Time</strong><hr>
      <h1>
        <?php
        include 'dbconfig.php';

        // Create connection
        $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT AVG(processing_time) AS average_processing_time FROM patient_data WHERE year = 2023;";
        $result = $conn->query($sql);
        
        if ($result !== false && $result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $averageProcessingTime = number_format($row['average_processing_time'], 2);
          echo $averageProcessingTime ." hrs";
        } else {
          echo "0 results";
        }
        
        $conn->close();
        ?>
      </h1>
    </div>
  </div>
</div>

  
  
  <!-- End of Key Metrics -->

    <!-- Start of KPI DIVs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap"></script>
    <?php include 'kpi1.php'; ?> 
    <?php include 'kpi2.php'; ?>
    <?php include 'kpi3.php'; ?>
    <?php include 'kpi4.php'; ?>
    <!-- End of KPI DIVs -->
  </body>
</html>