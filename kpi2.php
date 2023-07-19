<!-- kpi2a -->
<?php
  $currentYear = 2023; // Change this to the current year for KPI2a
  $dataProcessingTime_target = 3.1; // Change this to the target value for KPI2a
?>


<!-- /* KPI2b */ -->

<?php
$currentYear = 2023; // Change this to the current year for KPI2b
$dataErrorsTarget = 5; // Change this to the target value for KPI2b
?>

<div class="col-md-6 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>
        KPI2a: <u>Data Processing Time per Patient for Cardiovascular Disease Diagnosis</u><br>
        Year: <?= $currentYear ?><br>
        Target: <?= $dataProcessingTime_target ?>
      </strong>
    </div>
    <div class="card-body">
      <canvas id="KPI2a"></canvas>
    </div>
  </div>
</div>


<div class="col-md-6 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>
        KPI2b: <u>Data Errors and Inconsistencies in the Cardiovascular Disease Database</u><br>
        Target: <?= $dataErrorsTarget ?> or below<br>
        Current Year: <?= $currentYear ?>
      </strong>
    </div>
    <div class="card-body">
      <canvas id="KPI2b"></canvas>
    </div>
  </div>
</div>




<!-- kpi2a -->
<?php
  $currentYear = 2023; // Change this to the current year for KPI2a
  $dataProcessingTime_target = 3.1; // Change this to the target value for KPI2a
?>
<?php
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Call the stored procedure
  $stmt = $conn->prepare("CALL GetDataProcessingTimePerPatient(?)");
  $stmt->bind_param("i", $currentYear);

  // Execute the stored procedure
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  $patientInfo = array();
  $avgProcessingTimes = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $patientInfo[] = $row['patient_info'];
      $avgProcessingTimes[] = $row['avg_processing_time'];
    }
  } else {
    echo "No data available.";
  }

  $stmt->close();
  $conn->close();

  $jsonPatientInfo = json_encode($patientInfo);
  $jsonAvgProcessingTimes = json_encode($avgProcessingTimes);
?>



<script>
  const kpi2a = document.getElementById('KPI2a');

  new Chart(kpi2a, {
    type: 'bar',
    data: {
      labels: <?= $jsonPatientInfo ?>,
      datasets: [
        {
          label: 'Average Processing Time',
          data: <?= $jsonAvgProcessingTimes ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.4)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        },
        {
          type: 'line',
          label: 'Target',
          data: Array(<?= count($patientInfo) ?>).fill(<?= $dataProcessingTime_target ?>),
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 2,
          borderDash: [5, 5],
          fill: false,
          radius: 0,
          tension: 0
        }
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Average Processing Time'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Patient Information'
          }
        }
      },
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          intersect: false
        }
      }
    }
  });

      /* KPI2b */

      <?php
  $currentYear = 2023; // Change this to the current year for KPI2b
  $dataErrorsTarget = 5; // Change this to the target value for KPI2b
?>

<?php
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Call the stored procedure
  $sql = "CALL GetDataErrorsAndInconsistencies($currentYear)";
  $result = $conn->query($sql);

  $months = array();
  $dataErrors = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $months[] = $row['month'];
      $dataErrors[] = $row['data_errors'];
    }
  } else {
    echo "No data available.";
  }

  $conn->close();

  $jsonMonths = json_encode($months);
  $jsonDataErrors = json_encode($dataErrors);
?>




      const kpi2b = document.getElementById('KPI2b');

      new Chart(kpi2b, {
    type: 'line',
    data: {
      labels: <?= $jsonMonths ?>,
      datasets: [
        {
          label: 'Data Errors',
          data: <?= $jsonDataErrors ?>,
          fill: false,
          borderColor: 'rgba(75, 192, 192, 1)',
          tension: 0.1
        },
        {
          label: 'Target',
          data: Array(<?= count($months) ?>).fill(<?= $dataErrorsTarget ?>),
          fill: false,
          borderColor: 'rgba(255, 99, 132, 1)',
          borderDash: [5, 5],
          tension: 0.1
        }
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Data Errors'
          }
        }
      },
      plugins: {
        legend: {
          display: true
        },
        tooltip: {
          intersect: false
        }
      }
    }
  });
</script>

