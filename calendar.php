<?php
session_start();
include('db.php'); // DB connection file

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Function to fetch all diet plans
function fetchAllDietPlans($username, $month, $year, $conn) {
    $start_date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
    $end_date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-31";

    $stmt = $conn->prepare("
        SELECT dish_name, meal_time, meal_date 
        FROM diet_plans 
        WHERE user_id = (SELECT id FROM users WHERE username = ?) 
        AND meal_date BETWEEN ? AND ?
    ");
    $stmt->bind_param("sss", $username, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $dietPlans = [];
    while ($row = $result->fetch_assoc()) {
        $formattedMeal = ucfirst($row['meal_time']) . ": " . $row['dish_name'];
        $dietPlans[$row['meal_date']][] = $formattedMeal;
    }

    return $dietPlans;
}

$dietPlans = fetchAllDietPlans($username, date('m'), date('Y'), $conn);
$dietPlansJson = json_encode($dietPlans);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Diet Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("image/calendarbackground.png");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 20px;
        }

        .calendar-container {
            max-width: 900px;
            margin: auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .day {
            height: 100px;
            border: 1px solid #ddd;
            background: #fafafa;
            position: relative;
            padding: 5px;
            font-size: 14px;
            overflow-y: auto;
        }

        .diet-plan {
            background: #cceeff;
            padding: 3px;
            margin-top: 4px;
            border-radius: 4px;
            font-size: 12px;
        }

        .day-name {
            font-weight: bold;
            text-align: center;
            background-color: #f1f1f1;
        }

        .back-button {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="calendar-container">
    <div class="back-button">
        <a href="dashboard.php">🔙 Back to Dashboard</a>
    </div>

    <div class="calendar-header">
        <button onclick="changeMonth(-1)">← Prev</button>
        <h2 id="month-title">Month Year</h2>
        <button onclick="changeMonth(1)">Next →</button>
    </div>

    <div class="calendar-grid" id="calendar-grid"></div>
</div>

<script>
let dietPlans = <?= $dietPlansJson ?>;

let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

function loadCalendar() {
    const monthName = new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long' });
    document.getElementById('month-title').textContent = `${monthName} ${currentYear}`;

    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    const lastDate = new Date(currentYear, currentMonth + 1, 0).getDate();

    const grid = document.getElementById('calendar-grid');
    grid.innerHTML = '';

    // Add day names
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    dayNames.forEach(day => {
        const div = document.createElement('div');
        div.className = 'day-name';
        div.textContent = day;
        grid.appendChild(div);
    });

    // Empty cells before the first day
    for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement('div');
        grid.appendChild(empty);
    }

    // Fill the days
    for (let d = 1; d <= lastDate; d++) {
        const date = new Date(currentYear, currentMonth, d);
        const dateStr = date.toISOString().split('T')[0];

        const div = document.createElement('div');
        div.className = 'day';
        div.innerHTML = `<strong>${d}</strong>`;

        if (dietPlans[dateStr]) {
            dietPlans[dateStr].forEach(plan => {
                const planDiv = document.createElement('div');
                planDiv.className = 'diet-plan';
                planDiv.textContent = plan;
                div.appendChild(planDiv);
            });
        }

        grid.appendChild(div);
    }
}

function changeMonth(offset) {
    currentMonth += offset;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    } else if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    loadCalendar();
}

loadCalendar();
</script>
</body>
</html>
