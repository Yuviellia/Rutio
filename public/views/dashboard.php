<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="/public/css/variables.css" type="text/css" rel="stylesheet">
    <link href="/public/css/main.css" type="text/css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bf11c142bf.js" crossorigin="anonymous"></script>
    <script src="./public/js/clock.js" type="text/javascript" defer></script>
    <title>Rutio | Dashboard</title>
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="/todo">To Do List</a>
            <a href="/dashboard">Habit Tracker</a>
            <a href="/logout">Logout</a>
        </nav>

        <div id="header" class="section">
            <h1>Rutio</h1>
            <div class="clock">
                <span id="hours">07</span>:<span id="minutes">46</span> <span id="period">AM</span>
            </div>
        </div>

        <div id="habit-table-section" class="section">
            <h2>Habit Tracker</h2>
            <?php
            $days = ["mon", "tue", "wed", "thu", "fri", "sat", "sun"];
            if(!isset($startDate)) $startDate = new DateTime();
            $startDate->modify('monday this week');
            ?>

            <h3>
                <a href="/dashboard?startDate=<?=(clone $startDate)->modify('-1 week')->format('Y-m-d')?>">&lt;</a>
                <?=$startDate->format('Y-m-d')?>
                <a href="/dashboard?startDate=<?=(clone $startDate)->modify('+1 week')->format('Y-m-d')?>">&gt;</a>
            </h3>
            <table>
                <tr>
                    <th class="task-column">Task</th>
                    <th class="day-column">Mon</th>
                    <th class="day-column">Tue</th>
                    <th class="day-column">Wed</th>
                    <th class="day-column">Thu</th>
                    <th class="day-column">Fri</th>
                    <th class="day-column">Sat</th>
                    <th class="day-column">Sun</th>
                    <th class="progress-column">Progress</th>
                </tr>
                <?php if(isset($tags)) {foreach($tags as $tag):?>
                    <tr>
                        <td class="task-column">
                            <div class="task-cell">
                                <form action="/deleteG" method="post" enctype="multipart/form-data">
                                    <span><?=$tag["name"]?></span>
                                    <button type="submit" class="submit-button"><i class="fa-solid fa-trash"></i></button>
                                    <input type="hidden" name="tag" value="<?= htmlspecialchars($tag["id"]) ?>">
                                    <input type="hidden" name="startDate" value="<?= htmlspecialchars($startDate->format('Y-m-d')) ?>">
                                </form>
                            </div>
                        </td>
                        <?php
                        foreach ($days as $index => $day):
                            $startDateClone = clone $startDate;
                            $currentDate = $startDateClone->modify('+' . $index . ' days')->format('Y-m-d');

                            $isChecked = false;
                            if (isset($marks[$tag["id"]])) {
                                $i = 0;
                                foreach ($marks[$tag["id"]] as $entry) {
                                    $entryDate = new DateTime($entry["date"]);
                                    if ($entryDate >= $startDate && $entryDate < (clone $startDate)->modify('+7days')) $i++;
                                    if ($entry["date"] === $currentDate) {
                                        $isChecked = true;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <td class="day-column">
                                <form action="/mark" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($tag["id"]) ?>">
                                    <input type="hidden" name="date" value="<?= htmlspecialchars($currentDate) ?>">
                                    <input type="hidden" name="startDate" value="<?= htmlspecialchars($startDate->format('Y-m-d')) ?>">
                                    <label>
                                        <input type="checkbox" class="check-<?= $day; ?>" name="marked" value="1" <?= $isChecked ? 'checked' : '' ?> onchange="this.form.submit()">
                                    </label>
                                </form>
                            </td>
                        <?php endforeach; ?>
                        <td class="progress-column">
                            <div class="progress">
                                <div class="progress-bar" style="width: <?= $i / 7 * 100;?>%;"></div>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; }?>
                <tr>
                    <td>
                        <div>
                            <form action="/addG" method="post" enctype="multipart/form-data">
                                <div class="add-container">
                                    <input type="hidden" name="startDate" value="<?= htmlspecialchars($startDate->format('Y-m-d')) ?>">
                                    <span><input name="tag" type="text" placeholder="Add a new task..." class="task-input"></span>
                                    <button type="submit" class="submit-button"><i class="fa-solid fa-plus"></i></button>
                                </div>
                            </form>
                        </div>
                    </td>
                    <td class="day-column"></td> <td class="day-column"></td> <td class="day-column"></td> <td class="day-column"></td>
                    <td class="day-column"></td> <td class="day-column"></td> <td class="day-column"></td> <td class="progress-column"></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
