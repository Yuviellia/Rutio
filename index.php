<!DOCTYPE html>
<html lang="en">
<head>
    <link href="css/variables.css" type="text/css" rel="stylesheet">
    <link href="css/main.css" type="text/css" rel="stylesheet">
    <title>Rutio | Dashboard</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Habit Tracker</h1>
            <div class="clock">
                <span id="hours">07</span>:<span id="minutes">46</span> <span id="period">AM</span>
            </div>
        </div>

        <div class="reminder">Daily Reminder: Eat more veggies.</div>

        <ul class="task-list">
            <li>Reply to emails</li>
            <li>Do laundry</li>
            <li>Lunch date with Rachel</li>
            <li>Edit videos</li>
            <li>Buy dog food</li>
        </ul>

        <table>
            <tr>
                <th>Task</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
                <th>Sun</th>
                <th>Progress</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>Waking Up at 6 AM</td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" style="width: 70%;"></div>
                    </div>
                </td>
                <td>✔️</td>
            </tr>
            <!-- Repeat similar rows for other tasks -->
        </table>
    </div>

    <script>
        // JavaScript to update the clock
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes();
            const period = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12; // Convert to 12-hour format
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('period').textContent = period;
        }
        setInterval(updateClock, 1000); // Update every second
        updateClock(); // Initial call
    </script>
</body>
</html>
