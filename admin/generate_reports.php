<?php
// Include database connection (replace with your database connection file)
include('../connection.php');


// Default values for reports
$selectedCategory = "appointments"; // Default report category
$startDate = ""; // Start date filter
$endDate = ""; // End date filter

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedCategory = $_POST['category'] ?? "appointments";
    $startDate = $_POST['start_date'] ?? "";
    $endDate = $_POST['end_date'] ?? "";
    // Generate the report based on selected category and date filters
    $reportData = generateReport($selectedCategory, $startDate, $endDate);
}

// Function to generate report data
function generateReport($category, $startDate, $endDate) {
    global $conn;
    $data = [];
    $dateFilter = "";

    if (!empty($startDate) && !empty($endDate)) {
        $dateFilter = " WHERE `date` BETWEEN '$startDate' AND '$endDate'";
    }

    switch ($category) {
        case "appointments":
            $sql = "SELECT COUNT(*) AS total_appointments, 
                           SUM(hospital_charge + service_charge + dr_fee) AS total_earnings
                    FROM appointment $dateFilter";
            break;

        case "users":
            $sql = "SELECT COUNT(*) AS total_users FROM users";
            break;

        case "doctors":
            $sql = "SELECT COUNT(DISTINCT doctor_id) AS total_doctors,
                           SUM(dr_fee) AS total_earnings 
                    FROM appointment $dateFilter";
            break;

        case "hostel":
            $sql = "SELECT SUM(hostel_charge_per_day * DATEDIFF(check_out_date, check_in_date)) AS total_earnings,
                           COUNT(DISTINCT pet_id) AS total_pets
                    FROM hostel $dateFilter";
            break;

        default:
            return ["error" => "Invalid category selected"];
    }

    $result = $conn->query($sql);
    if ($result) {
        $data = $result->fetch_assoc();
    } else {
        $data = ["error" => "Failed to generate report: " . $conn->error];
    }

    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4">Admin Report Dashboard</h1>

    <!-- Filters Section -->
    <div class="card">
        <div class="card-header bg-primary text-white">Filters</div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-4">
                    <label for="category" class="form-label">Report Category</label>
                    <select id="category" name="category" class="form-select">
                        <option value="appointments" <?= $selectedCategory === "appointments" ? "selected" : "" ?>>Appointments</option>
                        <option value="users" <?= $selectedCategory === "users" ? "selected" : "" ?>>Users</option>
                        <option value="doctors" <?= $selectedCategory === "doctors" ? "selected" : "" ?>>Doctors</option>
                        <option value="hostel" <?= $selectedCategory === "hostel" ? "selected" : "" ?>>Hostel</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?= $startDate ?>">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?= $endDate ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Display Section -->
    <div class="card">
        <div class="card-header bg-success text-white">Report Results</div>
        <div class="card-body">
            <?php if (isset($reportData)) : ?>
                <?php if (!empty($reportData['error'])) : ?>
                    <p class="text-danger"><?= $reportData['error'] ?></p>
                <?php else : ?>
                    <ul class="list-group">
                        <?php foreach ($reportData as $key => $value) : ?>
                            <li class="list-group-item">
                                <strong><?= ucfirst(str_replace('_', ' ', $key)) ?>:</strong> <?= is_numeric($value) ? number_format($value) : $value ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php else : ?>
                <p class="text-muted">No report generated. Please use the filters above to generate a report.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Visual Chart Section -->
    <div class="card">
        <div class="card-header bg-info text-white">Visual Data</div>
        <div class="card-body">
            <canvas id="chartCanvas"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('chartCanvas').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Appointments', 'Users', 'Doctors', 'Hostel'],
            datasets: [{
                label: 'Report Summary',
                data: [<?= $reportData['total_appointments'] ?? 0 ?>, <?= $reportData['total_users'] ?? 0 ?>, <?= $reportData['total_doctors'] ?? 0 ?>, <?= $reportData['total_pets'] ?? 0 ?>],
                backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)', 'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

</body>
</html>
