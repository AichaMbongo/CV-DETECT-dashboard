<?php
  $currentQuarter = "Q2 2023"; // Change this to the current quarter
  $costSavingsTarget = 500000; // Change this to the target cost savings for KPI4a
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
  $sql = "CALL GetCostSavings($costSavingsTarget)";
  $result = $conn->query($sql);

  $quarters = array();
  $costSavings = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $quarters[] = $row['quarter'];
      $costSavings[] = $row['cost_savings'];
    }
  } else {
    echo "No data available.";
  }

  $conn->close();

  $jsonQuarters = json_encode($quarters);
  $jsonCostSavings = json_encode($costSavings);
?>

<div class="col-md-6 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>
        KPI4a: <u>Cost Savings Achieved through Early Detection and Prevention of Cardiovascular Diseases</u><br>
        Target: $<?= number_format($costSavingsTarget, 2) ?>
      </strong>
    </div>
    <div class="card-body">
      <canvas id="KPI4a"></canvas>
    </div>
  </div>
</div>

<script>
  const kpi4a = document.getElementById('KPI4a');

  new Chart(kpi4a, {
    type: 'pie',
    data: {
      labels: <?= $jsonQuarters ?>,
      datasets: [
        {
          label: 'Cost Savings',
          data: <?= $jsonCostSavings ?>,
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(221, 0, 170, 0.8)',
            'rgba(30, 144, 255, 0.8)',
            'rgba(0, 255, 127, 0.8)',
            'rgba(255, 215, 0, 0.8)'
          ]
        }
      ]
    },
    options: {
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });

  
</script>


<!-- kpia4b -->
<?php
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Call the stored procedure
  $sql = "CALL GetReductionData()";
  $result = $conn->query($sql);

  $categories = array();
  $hospitalizations = array();
  $expenditures = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $categories[] = $row['category_subcategory']; // Modified to use the concatenated column
      $hospitalizations[] = $row['hospitalizations'];
      $expenditures[] = $row['expenditures'];
    }
  } else {
    echo "No data available.";
  }

  $conn->close();

  $jsonCategories = json_encode($categories);
  $jsonHospitalizations = json_encode($hospitalizations);
  $jsonExpenditures = json_encode($expenditures);
?>

<div class="col-md-6 my-1">
  <div class="card">
    <div class="card-body text-center">
      <strong>
        KPI4b: <u>Hospitalizations and Healthcare Expenditures associated with Cardiovascular Diseases</u>
      </strong>
    </div>
    <div class="card-body">
      <canvas id="KPI4bChart"></canvas>
    </div>
  </div>
</div>

<script>
  const kpi4bChart = document.getElementById('KPI4bChart');

  new Chart(kpi4bChart, {
    type: 'bar',
    data: {
      labels: <?= $jsonCategories ?>,
      datasets: [
        {
          label: 'Hospitalizations',
          data: <?= $jsonHospitalizations ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.8)'
        },
        {
          label: 'Expenditures',
          data: <?= $jsonExpenditures ?>,
          backgroundColor: 'rgba(255, 99, 132, 0.8)'
        }
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          stacked: true,
          title: {
            display: true,
            text: 'Count/Value'
          }
        },
        x: {
          stacked: true,
          title: {
            display: true,
            text: 'Categories'
          }
        }
      },
      plugins: {
        tooltip: {
          mode: 'index',
          intersect: false
        }
      },
      responsive: true
    }
  });
</script>
