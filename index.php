<html>

<head>
    <title>
        Лабиринт
    </title>
    <style>
        body {
            background-color: #000000;
        }

        .notification {
            display: none;
            position: fixed;
            padding: 15px;
            z-index: 1;
            left: 10%;
            width: 200px;
            height: 25px;
            justify-content: center;
            align-items: center;
            background-color: white;
            color: black;
            border-radius: 10px;
        }

        form {
            width: 400px;
            height: 380px;
            padding: 40px;
            text-align: center;
            border-radius: 20px;
            backdrop-filter: blur(20px) brightness(200%);
            margin: auto auto;
            box-shadow: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
        }

        form input {
            width: 50%;
            height: 28px;
            margin-bottom: 15px;
            padding: 5px;
            border-radius: 10px;
        }

        .buttonin {
            border-radius: 10px;
            font-family: Arial, Helvetica, sans-serif;
            text-shadow: 0.02em 0.02em 0 Brown, 0 0 0.5em violet;
        }

        h1 {
            width: 100%;
            max-width: 500px;
            text-align: center;
            font-family: "Bungee Inline", cursive;
            margin: 50px auto;
            font-size: 5em;
            text-shadow: 0.02em 0.02em 0 Brown, 0 0 0.5em violet;
        }

        label {
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            box-shadow: 0 0 10px 10px #303030;
        }

        #table {
            box-shadow: 0 0 25px 0.5px #ffffff;
            border-radius: 10px;
        }

        .modal {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.65);
            visibility: hidden;
            backface-visibility: hidden;
            opacity: 0;
            transition: opacity .15s ease-in-out;
        }

        .modal-open {
            visibility: visible;
            backface-visibility: visible;
            opacity: 1;
            z-index: 1;
        }

        .modal-inner {
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            max-width: 35em;
            padding: 1em 1.5em;
            position: relative;
            margin: 2em;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.35);
        }

        .modal-close-icon {
            position: absolute;
            right: 1.5em;
        }

        .modal-content-inner {
            padding-right: 2em;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-bottom: 0.25em;
        }

        p {
            margin-bottom: 1em;
        }


        .modal-buttons-seperator {
            margin: 1.5em 0;
            margin-top: 0;
        }

        .modal-buttons {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
        }

        .startPoints {
            justify-content: center;
            align-items: center;
        }
    </style>

</head>

<body>
    <div id="notification" class="notification">
    </div>
    <div class="modal modal-open">
        <div class="modal-inner">
            <div class="modal-content">
                <div class="modal-close-icon">
                    <a href="javascript:void(0)" class="close-modal"><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
                <div class="modal-content-inner">
                    <h1>Maze</h1><br>
                    <p>This program finding the best way from one point to another.<br>
                        Maze - it's matrix with values 0 to 9. 0 - wall, 1-9 - steps.<br>
                        How to use:<br>
                        - set width and height of maze;<br>
                        - input values 0-9 in maze;<br>
                        - input start point like index of maze;<br>
                        - input end point like index of maze;<br>
                        - click calculate.
                        <br>
                    </p>
                </div>
                <hr class="modal-buttons-seperator">
                <div class="modal-buttons">
                    <button class="button button-primary close-modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h1>MAZE</h1>
            <label>SET MAZE</label>
            <label>Size</label>
            <input name="width" type="number" id="table-width" value="0" max="8" min="0"></br>
            <input name="height" type="number" id="table-height" value="0" max="8" min="0"></br>
            <label>MAZE</label>
            <table id="table">

            </table>
            <label>Start Point</label>
            <table>
                <tr>
                    <div id="startPoints">
                        <td><input name="startPointX" type="number" min="0"></td>
                        <td><input name="startPointY" type="number" min="0"></td>
                    </div>
                </tr>
            </table>
            <label>End Point</label>
            <table>
                <tr>
                    <td><input name="endPointX" type="number" min="0"></td>
                    <td><input name="endPointY" type="number" min="0"></td>
                </tr>
            </table>
            <div id="answer">
                <?php

                // define variables and set to empty values
                $row = $col = '';

                if (
                    $_SERVER['REQUEST_METHOD'] == 'POST'
                ) {
                    $row = test_input($_POST['width']);
                    $col = test_input($_POST['height']);
                    $start = [
                        intval($_POST['startPointX']),
                        intval($_POST['startPointY'])
                    ];
                    $end = [
                        intval($_POST['endPointX']),
                        intval($_POST['endPointY'])
                    ];
                    $maze = array();

                    for ($i = 0; $i < $row; $i++) {
                        $maze[$i] = array();

                        for ($j = 0; $j < $col; $j++) {
                            $name = 'row' . $i . $j;
                            $maze[$i][$j] = intval($_POST[$name]);
                        }
                    }
                    echo 'Start point - [' . $start[0] . ',' . $start[1] . ']<br>';
                    echo 'End point - [' . $end[0] . ',' . $end[1] . ']<br><br>';
                    echo 'Path: ' . json_encode(findShortestPath($maze, $start, $end));
                    //$path = find_path($maze, $start, $end);
                    //echo "Path:<br>" . json_encode($path);
                } else {
                    echo "Not corrected input";
                }

                function test_input($data)
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                function findShortestPath($maze, $start, $end)
                {
                    $queue = new SplQueue(); // Очередь для обхода в ширину
                    $visited = array(); // Список посещенных точек
                    $distances = array(); // Список расстояний до каждой точки
                    $prev = array(); // Список предыдущих точек на пути
                
                    // Инициализация начальной точки
                    $queue->enqueue($start);
                    $visited[$start[0]][$start[1]] = true;
                    $distances[$start[0]][$start[1]] = 0;

                    // Начинаем поиск в ширину
                    while (!$queue->isEmpty()) {
                        // Получаем следующую точку из очереди
                        $current = $queue->dequeue();

                        // Проверяем, является ли это конечной точкой
                        if ($current[0] === $end[0] && $current[1] === $end[1]) {
                            // Если да, то собираем путь из предыдущих точек
                            $path = array();
                            while ($current !== null) {
                                $path[] = $current;
                                $current = isset($prev[$current[0]][$current[1]]) ? $prev[$current[0]][$current[1]] : null;
                            }
                            $path = array_reverse($path);
                            return $path;
                        }

                        // Иначе, перебираем соседние точки и добавляем их в очередь
                        $neighbors = getNeighbors($maze, $current);
                        foreach ($neighbors as $neighbor) {
                            if (!isset($visited[$neighbor[0]][$neighbor[1]])) {
                                $queue->enqueue($neighbor);
                                $visited[$neighbor[0]][$neighbor[1]] = true;
                                $distances[$neighbor[0]][$neighbor[1]] = $distances[$current[0]][$current[1]] + $maze[$neighbor[0]][$neighbor[1]];
                                $prev[$neighbor[0]][$neighbor[1]] = $current;
                            }
                        }
                    }

                    // Если мы дошли до этой точки, то путь не был найден
                    return null;
                }

                // Функция для получения списка соседних точек
                function getNeighbors($maze, $point)
                {
                    $rows = count($maze);
                    $cols = count($maze[0]);
                    $neighbors = array();

                    $x = $point[0];
                    $y = $point[1];

                    // Соседние клетки с учетом значений
                    $moves = array(
                        array(-1, 0),
                        // Вверх
                        array(1, 0),
                        // Вниз
                        array(0, -1),
                        // Влево
                        array(0, 1) // Вправо
                    );

                    foreach ($moves as $move) {
                        $i = 1;
                        while (true) {
                            $nx = $x + $move[0] * $i;
                            $ny = $y + $move[1] * $i;

                            if ($nx < 0 || $ny < 0 || $nx >= $rows || $ny >= $cols || $maze[$nx][$ny] === 0) {
                                break;
                            }

                            $neighbors[] = array($nx, $ny);

                            if ($maze[$nx][$ny] === 1) {
                                break;
                            }

                            $i++;
                        }
                    }

                    return $neighbors;
                }

                ?>
            </div>
            <button type="submit" class="buttonin">Calculate</button>
        </form>
        <button class="buttonin open-modal">FAQ</button>
    </div>
    <script src="maze.js"></script>


</body>

</html>