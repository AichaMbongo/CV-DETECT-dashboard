


<!-- KPI1A -->

<?php
  $innovationTarget = 200; // Change this to the target number of innovative ideas for KPI1a

  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Call the stored procedure
  $sql = "CALL GetInnovativeIdeasCount()";
  $result = $conn->query($sql);

  $quarters = array();
  $innovativeIdeas = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $quarters[] = $row['quarter'];
      $innovativeIdeas[] = $row['idea_count'];
    }
  } else {
    echo "No data available.";
  }

  $conn->close();

  $jsonQuarters = json_encode($quarters);
  $jsonInnovativeIdeas = json_encode($innovativeIdeas);
?>
<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body" style="text-align:center;"><strong>
        KPI1a: <u>Number of innovative ideas implemented in CVD prediction models.</u><br>
        Year: 2023<br>
        Target: <?=$innovationTarget?>
      </strong></div>
    
    <div class="card-body"><canvas id="KPI1a"></canvas></div>
</div>
</div>

<script>
const kpi1a = document.getElementById('KPI1a');

new Chart(kpi1a, {
  type: 'bar',
  data: {
    labels: <?= $jsonQuarters ?>,
    datasets: [
      {
        type: 'bar',
        label: 'Number of Innovative Ideas',
        data: <?= $jsonInnovativeIdeas ?>,
        backgroundColor: 'rgba(238, 36, 56, 0.5)'
      },
      {
        type: 'line',
        label: 'Target',
        data: Array(<?= count($quarters) ?>).fill(<?= $innovationTarget ?>),
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
          text: 'Number of Ideas'
        }
      },
      x: {
        title: {
          display: true,
          text: 'Quarter'
        }
      }
    },
    plugins: {
      tooltip: {
        intersect: true
      },
      legend: {
        position: 'bottom',
        labels: {
          usePointStyle: true
        }
      }
    },
    interaction: {
      mode: 'point'
    }
  }
});
</script>
<!-- 
      /* KPI1b */ -->
      <?php
  $dataProcessingTarget = 30; // Change this to the target data processing time in seconds for KPI1b

  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Call the stored procedure
  $sql = "CALL GetProcessingTimeForYear()";
  $result = $conn->query($sql);

  $quarters = array();
  $dataProcessingTimes = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $quarters[] = $row['quarter'];
      $dataProcessingTimes[] = $row['processing_time'];
    }
  } else {
    echo "No data available.";
  }

  $conn->close();

  $jsonQuarters = json_encode($quarters);
  $jsonDataProcessingTimes = json_encode($dataProcessingTimes);
?>

<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body" style="text-align:center;"><strong >
        KPI1b: <u>Data Processing Time per Patient for Cardiovascular Disease Diagnosis</u><br>
        Year: 2023<br>
        Target: <?= $dataProcessingTarget?>
      </strong></div>
    <div class="card-body"><canvas id="KPI1b"></canvas></div>
</div>
</div>

<script>
const kpi1b = document.getElementById('KPI1b');

new Chart(kpi1b, {
  type: 'line',
  data: {
    labels: <?= $jsonQuarters ?>,
    datasets: [
      {
        type: 'line',
        label: 'Target',
        data: Array(<?= count($quarters) ?>).fill(<?= $dataProcessingTarget ?>),
        borderWidth: 0.8,
        fill: false,
        borderColor: 'black',
        pointBackgroundColor: 'black',
        pointRadius: 0,
        pointStyle: 'line'
      },
      {
        label: 'Processing Time',
        data: <?= $jsonDataProcessingTimes ?>,
        borderWidth: 3,
        borderColor: 'rgba(9, 50, 219, 0.75)',
        backgroundColor: 'rgba(9, 50, 219, 0.1)',
        fill: {
          target: '-1',
          above: 'rgba(85, 235, 90, 0.4)',   // Colour of the area above the target
          below: 'rgba(238, 36, 56, 0.77)'    // Colour of the area below the target
        }
      }
    ]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: 'Processing Time (seconds)'
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