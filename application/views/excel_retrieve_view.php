<!DOCTYPE html>
<html>
<head>
    <title>MCQ Test</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2f7;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .question-box {
            background: #fff;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* ✅ Question titles only bold */
        .question-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #222;
        }

        .question-box p {
            margin: 5px 0;
            font-weight: normal; /* ✅ everything else normal */
        }

        /* Match the Following Styling */
        .match-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            table-layout: fixed;
        }

        .match-table th, .match-table td {
            border: 1px solid #ccc;
            padding: 12px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .match-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        /* Options styling */
        .options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .options label {
            flex: 1 1 calc(50% - 10px);
            background: #f7f7f7;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            border: 1px solid #ddd;
            transition: 0.3s;
            text-align: center;
        }

        .options label:hover {
            background: #e0f7e0;
            border-color: #4CAF50;
        }

        .options input[type="radio"] {
            display: none;
        }

        .options input[type="radio"]:checked + span {
            background: #4CAF50;
            color: white;
            display: block;
            border-radius: 8px;
        }

        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
            transition: 0.3s;
        }

        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<h2>Online MCQ Test</h2>

<form method="post" action="#">

<?php $q_no = 1; foreach($data as $row): ?>
<div class="question-box">

    <!-- English Question (BOLD + Question Number) -->
    <?php if(!empty($row->English_Question)): ?>
        <p class="question-title"><strong><?= $q_no ?>. <?= $row->English_Question ?></strong></p>
    <?php endif; ?>

    <!-- Dynamic English Statements -->
    <?php 
        foreach($row as $col => $val){
            if(stripos($col, "English_statement") !== false && $val !== null && trim($val) !== ''){
                echo "<p>".trim($val)."</p>";
            }
        }
    ?>

    <?php if(!empty($row->English_Assertion)) echo "<p>Assertion: ".$row->English_Assertion."</p>"; ?>
    <?php if(!empty($row->English_Reason)) echo "<p>Reason: ".$row->English_Reason."</p>"; ?>

    <!-- Tamil Question (BOLD + Question Number continues) -->
    <?php if(!empty($row->Tamil_Question)) echo "<p class='question-title'><strong>".$q_no.". ".$row->Tamil_Question."</strong></p>"; ?>

    <!-- Dynamic Tamil Statements -->
    <?php 
        foreach($row as $col => $val){
            if(stripos($col, "Tamil_statement") !== false && $val !== null && trim($val) !== ''){
                echo "<p>".trim($val)."</p>";
            }
        }
    ?>

    <?php if(!empty($row->Tamil_Assertion)) echo "<p>Assertion: ".$row->Tamil_Assertion."</p>"; ?>
    <?php if(!empty($row->Tamil_Reason)) echo "<p>Reason: ".$row->Tamil_Reason."</p>"; ?>

    <!-- Match the Following -->
    <?php if(!empty($row->English_match_left) && !empty($row->English_match_right)): ?>
    <h4>Match the Following:</h4>
    <table class="match-table">
        <tr>
            <th>List - I</th>
            <th>List - II</th>
        </tr>
        <?php
        $list1_eng = explode("\n", $row->English_match_left);
        $list2_eng = explode("\n", $row->English_match_right);
        $list1_tam = explode("\n", $row->Tamil_match_left);
        $list2_tam = explode("\n", $row->Tamil_match_right);

        $max_count = max(count($list1_eng), count($list2_eng));
        for($i=0; $i<$max_count; $i++):
        ?>
        <tr>
            <td>
                <strong><?= chr(65+$i) ?>.</strong>
                <div>
                    <?= isset($list1_eng[$i]) ? trim((string)$list1_eng[$i]) : '' ?>
                    <?php if(isset($list1_tam[$i]) && trim((string)$list1_tam[$i])!=""): ?>
                        <br><em><?= trim($list1_tam[$i]) ?></em>
                    <?php endif; ?>
                </div>
            </td>
            <td>
                <strong><?= $i+1 ?>.</strong>
                <div>
                    <?= isset($list2_eng[$i]) ? trim((string)$list2_eng[$i]) : '' ?>
                    <?php if(isset($list2_tam[$i]) && trim((string)$list2_tam[$i])!=""): ?>
                        <br><em><?= trim($list2_tam[$i]) ?></em>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endfor; ?>
    </table>
    <?php endif; ?>

    <!-- Options -->
    <?php if(!empty($row->E_option_1) || !empty($row->E_option_2) || !empty($row->E_option_3) || !empty($row->E_option_4)): ?>
    <div class="options">
        <?php 
        $eng_options = [
            $row->E_option_1,
            $row->E_option_2,
            $row->E_option_3,
            $row->E_option_4
        ];
        $tam_options = [
            $row->T_option_1,
            $row->T_option_2,
            $row->T_option_3,
            $row->T_option_4
        ];

        foreach($eng_options as $index => $opt):
            $opt_trim = trim((string)$opt);
            if($opt_trim == "") continue;
        ?>
        <label>
            <input type="radio" name="answer[<?= $row->q_no ?>]" value="<?= $opt_trim ?>">
            <span><?= $opt_trim ?><?php if(!empty($tam_options[$index])) echo " / ".trim((string)$tam_options[$index]); ?></span>
        </label>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>
<?php $q_no++; endforeach; ?>

<button type="submit">Submit</button>
</form>

</body>
</html>
