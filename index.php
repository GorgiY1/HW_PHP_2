<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Календар</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 10px 0;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
    background-color: #b3d9ff; /* Світло-синій */
    color: #003366; /* Темно-синій текст */
    font-weight: bold;
}

/* Вихідні дні */
.weekend {
    background-color: violet; /* Світло-жовтий */
    
}

/* Святкові дні */
.holiday {
    background-color: lightsalmon; /* Світло-фіолетовий */
    color: #4b0082; /* Темно-фіолетовий текст */
}
        .box {
            width: 350px;
            margin: 20px;
            display: inline-block;
        }
        
    </style>
</head>
<body>
    <h1>Введіть рік для відображення календаря:</h1>
    <form method="post" action="">
        <label for="year">Рік:</label>
        <input type="number" name="year" id="year">
        <input type="submit" value="Показати календар">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST['year'])) {
        $year = intval($_POST['year']);
        echo "<h2>Календар на $year рік</h2>";
        echo "<div class='container'>";
        create_calendar($year);
        echo "</div>";
    }

    function create_calendar($year)
    {
        $holidays = [
            '06-28', // День Конституції
            '10-14', // День захисника України
            '05-01', // День праці
            '04-28', // Великдень (зразкові дати, мають бути обчислені для кожного року)
            '03-08', // Міжнародний жіночий день
            '05-09', // День перемоги
            '08-24', // День Незалежності
            '01-01', // Новий Рік
        ];

        for ($month=1; $month < 13; $month++) { 
            echo "<div class='box'><h3>".date('F',mktime(0,0,0,$month,1,$year))."</h3>";
            echo "<table>";
            echo "<tr>
                    <th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th>
                </tr>";
            
            $first_Day_Of_Month = mktime(0, 0, 0, $month, 1, $year);
            $days_In_Month = date('t',$first_Day_Of_Month);
            $day_Of_Week = date('N',$first_Day_Of_Month);

            echo "<tr>";

            // Пусті клітинки до першого дня місяця
            for ($i = 1; $i < $day_Of_Week; $i++) {
                echo "<td></td>";
            }

            // Дні місяця
            for ($day = 1; $day <= $days_In_Month; $day++) {
                $currentDate = sprintf("%02d-%02d", $month, $day);
                $class = '';
                $currentDayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
            
                if ($currentDayOfWeek == 6 || $currentDayOfWeek == 7) {
                    $class = 'weekend';
                }
                if (in_array($currentDate, $holidays)) {
                    $class = 'holiday';
                }
                echo "<td class='$class'>$day</td>";
                if ($currentDayOfWeek == 7) {
                    echo "</tr><tr>";
                }
            }

            // Пусті клітинки після останнього дня місяця
            for ($i = date('N', mktime(0, 0, 0, $month, $days_In_Month, $year)); $i < 7; $i++) {
                echo "<td></td>";
            }

            echo "</tr>";
            echo "</table></div>";
        }

    }
    ?>
</body>
</html>