
<?php
  $satisfactionTarget = 8; // Change this to the target satisfaction score for KPI3a
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
  $sql = "CALL GetPatientSatisfactionScores()";
  $result = $conn->query($sql);

  $patientIDs = array();
  $satisfactionScores = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $patientIDs[] = $row['id'];
      $satisfactionScores[] = $row['satisfaction_score'];
    }
  } else {
    echo "No data available.";
  }

  $conn->close();

  $jsonPatientIDs = json_encode($patientIDs);
  $jsonSatisfactionScores = json_encode($satisfactionScores);
?>

<div class="col-md-6 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>
        KPI3a: <u>Patient Satisfaction Scores related to Personalized Risk Assessments and Preventive Recommendations</u><br>
        Target: <?= $satisfactionTarget ?> or above
      </strong>
    </div>
    <div class="card-body">
      <canvas id="KPI3a"></canvas>
    </div>
  </div>
</div>

<script>
  const kpi3a = document.getElementById('KPI3a');

  new Chart(kpi3a, {
    type: 'radar',
    data: {
      labels: <?= $jsonPatientIDs ?>,
      datasets: [
        {
          label: 'Satisfaction Score',
          data: <?= $jsonSatisfactionScores ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.4)',
          borderColor: 'rgba(54, 162, 235, 1)',
          pointBackgroundColor: 'rgba(54, 162, 235, 1)',
          pointBorderColor: '#fff',
          pointRadius: 4,
          pointHoverRadius: 5
        }
      ]
    },
    options: {
      scales: {
        r: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Satisfaction Score'
          },
          angleLines: {
            display: false
          },
          grid: {
            circular: true
          },
          pointLabels: {
            display: true
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
</script>

<?php
  $interventionTarget = 100; // Change this to the target number of successful interventions or treatments for KPI3b
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
  $sql = "CALL GetSuccessfulInterventions($interventionTarget)";
  $result = $conn->query($sql);

  $quarters = array();
  $interventionCounts = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $quarters[] = $row['quarter'];
      $interventionCounts[] = $row['intervention_count'];
    }
  } else {
    echo "No data available.";
  }

  $conn->close();

  $jsonQuarters = json_encode($quarters);
  $jsonInterventionCounts = json_encode($interventionCounts);
?>

<div class="col-md-6 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>
        KPI3b: <u>Number of Successful Interventions or Treatments based on Provided Recommendations</u><br>
        Target: <?= $interventionTarget ?> or above
      </strong>
    </div>
    <div class="card-body">
      <canvas id="KPI3b"></canvas>
    </div>
  </div>
</div>

<script>
  const kpi3b = document.getElementById('KPI3b');

  new Chart(kpi3b, {
    type: 'bar',
    data: {
      labels: <?= $jsonQuarters ?>,
      datasets: [
        {
          type: 'bar',
          label: 'Intervention Count',
          data: <?= $jsonInterventionCounts ?>,
          borderWidth: 1,
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.8)'
        },
        {
          type: 'line',
          label: 'Target',
          data: Array(<?= count($quarters) ?>).fill(<?= $interventionTarget ?>),
          borderWidth: 1.2,
          fill: false,
          borderColor: 'black',
          pointBackgroundColor: 'black',
          pointRadius: 0,
          pointStyle: 'line'
        }
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Intervention Count'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Quarter'
          },
          grid: {
            display: false
          }
        }
      },
      plugins: {
        tooltip: {
          intersect: false
        },
        legend: {
          position: 'bottom',
          labels: {
            usePointStyle: true
          }
        }
      },
      interaction: {
        mode: 'index'
      }
    }
  });

</script>
