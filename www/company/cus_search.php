<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>会員検索</title>
    <style>
        .list-group-item-action:hover {
            background-color: lightblue;
        }
            /* ボタンのマージンを設定 */
    .btn {
        margin: 3px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="my-3">会員検索</h1>
        <?php
        
        require '../../dbconfig.php'; 
        session_start(); 
        require '../../dbconfig2.php';
        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        $mail = $_SESSION['mail'];
        $stmt = $pdo->prepare("SELECT work, jigyousho, city,techo_num,techo,types,train_line,train_station FROM bizdiverse_company WHERE mail = :mail");
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();

        $result_company = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sortOptions = isset($_GET['sortOptions']) ? explode(',', $_GET['sortOptions']) : [];

        function generateUrl($option, $currentOptions) {
            if (in_array($option, $currentOptions)) {
                $currentOptions = array_diff($currentOptions, [$option]);
            } else {
                $currentOptions[] = $option;
            }
            return '?sortOptions=' . implode(',', $currentOptions);
        }
        ?>

<div class="mb-3">
    <button onclick="location.href='<?php echo generateUrl('city', $sortOptions); ?>'" class="btn <?php echo in_array('city', $sortOptions) ? 'btn-primary' : 'btn-secondary'; ?>">市区町村で絞る</button>
    <button onclick="location.href='<?php echo generateUrl('work', $sortOptions); ?>'" class="btn <?php echo in_array('work', $sortOptions) ? 'btn-primary' : 'btn-secondary'; ?>">こだわり条件で絞る</button>
    <button onclick="location.href='<?php echo generateUrl('jigyousho', $sortOptions); ?>'" class="btn <?php echo in_array('jigyousho', $sortOptions) ? 'btn-primary' : 'btn-secondary'; ?>">事業所条件で絞る</button>
    <button onclick="location.href='<?php echo generateUrl('types', $sortOptions); ?>'" class="btn <?php echo in_array('types', $sortOptions) ? 'btn-primary' : 'btn-secondary'; ?>">障害種別で絞る</button>
    <button onclick="location.href='<?php echo generateUrl('techo', $sortOptions); ?>'" class="btn <?php echo in_array('techo', $sortOptions) ? 'btn-primary' : 'btn-secondary'; ?>">手帳有無で絞る</button>
    <button onclick="location.href='<?php echo generateUrl('techo_num', $sortOptions); ?>'" class="btn <?php echo in_array('techo_num', $sortOptions) ? 'btn-primary' : 'btn-secondary'; ?>">手帳等級で絞る</button>
    <button onclick="location.href='<?php echo generateUrl('train_line', $sortOptions); ?>'" class="btn <?php echo in_array('train_line', $sortOptions) ? 'btn-primary' : 'btn-secondary'; ?>">路線で絞る</button>
    <button onclick="location.href='<?php echo generateUrl('train_station', $sortOptions); ?>'" class="btn <?php echo in_array('train_station', $sortOptions) ? 'btn-primary' : 'btn-secondary'; ?>">駅で絞る</button>
</div>

<ul class="list-group">
<?php
    if (count($result_company) > 0) {
        $sortOptions = isset($_GET['sortOptions']) ? explode(',', $_GET['sortOptions']) : [];
        $uniqueResults = [];
        $noResultFlag = false;

    foreach ($result_company as $row_company) {

        $cities = !is_null($row_company["city"]) ? explode(',', $row_company["city"]) : ['%'];
        $train_lines = !is_null($row_company["train_line"]) ? explode(',', $row_company["train_line"]) : ['%'];
        $train_stations = !is_null($row_company["train_station"]) ? explode(',', $row_company["train_station"]) : ['%'];
      
                            $works = explode(',', $row_company["work"]);
                            $jigyoushos = explode(',', $row_company["jigyousho"]);
                            // If the sort option isn't selected, reset to the full list
                            if (!in_array('city', $sortOptions)) {
                                $cities = ['%'];
                            }
                            if (!in_array('train_station', $sortOptions)) {
                                $train_stations = ['%'];
                            }
                            if (!in_array('train_line', $sortOptions)) {
                                $train_lines = ['%'];
                            }

                            if (!in_array('work', $sortOptions)) {
                                $works = ['%'];
                            }
                            if (!in_array('jigyousho', $sortOptions)) {
                                $jigyoushos = ['%'];
                            }
                            // 手帳のフィルタリングのための条件を追加
                            $types = in_array('types', $sortOptions) ? explode(',', $row_company["types"]) : ['%'];
                            $techos = in_array('techo', $sortOptions) ? explode(',', $row_company["techo"]) : ['%'];
                            $techo_nums = in_array('techo_num', $sortOptions) ? explode(',', $row_company["techo_num"]) : ['%'];


                    foreach ($cities as $city) {
                        foreach ($train_lines as $train_line) {
                            foreach ($train_stations as $train_station) {
                                foreach ($works as $work) {
                                    foreach ($types as $type) {
                                        foreach ($jigyoushos as $jigyousho) {
                                            foreach ($techos as $techo) { // 手帳のループを追加
                                                foreach ($techo_nums as $techo_num) { 

                                                    $city = is_null($city) ? '%' : trim($city);
                                                    $train_line = is_null($train_line) ? '%' : trim($train_line);
                                                    $train_station = is_null($train_station) ? '%' : trim($train_station);
                                                    $work = is_null($work) ? '%' : trim($work);
                                                    $jigyousho = is_null($jigyousho) ? '%' : trim($jigyousho);
                                                    $type = is_null($type) ? '%' : trim($type);
                                                    $techo = is_null($techo) ? '%' : trim($techo);
                                                    $techo_num = is_null($techo_num) ? '%' : trim($techo_num);
                                                    
                                                    $stmt = $pdo->prepare("SELECT * FROM bizdiverse_user 
                                                    WHERE city LIKE :city AND work LIKE :work AND jigyousho 
                                                    LIKE :jigyousho AND techo LIKE :techo AND techo_num LIKE :techo_num AND types LIKE :types
                                                    AND train_line LIKE :train_line AND train_station LIKE :train_station");


                                                        $stmt->bindValue(':city', $city === '%' ? $city : '%'.$city.'%', PDO::PARAM_STR);
                                                        $stmt->bindValue(':work', $work === '%' ? $work : '%'.$work.'%', PDO::PARAM_STR);
                                                        $stmt->bindValue(':jigyousho', $jigyousho === '%' ? $jigyousho : '%'.$jigyousho.'%', PDO::PARAM_STR);
                                                        $stmt->bindValue(':types', $type === '%' ? $type : '%'.$type.'%', PDO::PARAM_STR); // typesのバインド
                                                        $stmt->bindValue(':techo', $techo === '%' ? $techo : '%'.$techo.'%', PDO::PARAM_STR); // 手帳のバインド
                                                        $stmt->bindValue(':techo_num', $techo_num === '%' ? $techo_num : '%'.$techo_num.'%', PDO::PARAM_STR);  // 手帳等級のバインド
                                                        $stmt->bindValue(':train_line', $train_line === '%' ? $train_line : '%'.$train_line.'%', PDO::PARAM_STR);
                                                        $stmt->bindValue(':train_station', $train_station === '%' ? $train_station : '%'.$train_station.'%', PDO::PARAM_STR);
                
                                                        
                                                        

                                                        $stmt->execute();

                                                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if (count($result) > 0) {
                                                            $noResultFlag = true; 
                                                            foreach ($result as $row) {
                                                                if (!array_key_exists($row['id'], $uniqueResults)) {
                                                                    $uniqueResults[$row['id']] = $row;
                                                                    echo "<a href='details.php?id=".$row["id"]."' class='list-group-item list-group-item-action'>
                                                                    ニックネーム：" . $row["kana"]. " <br> エリア：" . $row["city"]. " <br> 路線：" . $row["train_line"]. " <br> 駅：" . $row["train_station"].  
                                                                    " <br> 希望職種・こだわり条件：" . $row["work"]. " <br> 施設条件：" . $row["jigyousho"]. 
                                                                    " <br> 障害種別：" . $row["types"]." <br> 手帳の有無：" . $row["techo"]." <br> 手帳等級：" . $row["techo_num"].
                                                                    "</a>";
                                                                    }
                                                                }
                                                            }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if ($noResultFlag === false) {
        echo "<li class='list-group-item'>0 results</li>";
        }
    }
    else {
            echo "<li class='list-group-item'>No attributes found in bizdiverse_company with mail: " . $mail . "</li>";
        }
        ?>
        </ul>
        <button class="btn btn-primary my-3" onclick="location.href='dash_com.php'">Back</button>
    </div>

    <footer class="text-center mb-4 pt-3">
        <p>&copy; BizDiverse</p>
    </footer>
</body>

</html>
