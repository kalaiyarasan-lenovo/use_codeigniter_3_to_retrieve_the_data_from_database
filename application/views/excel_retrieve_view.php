<!DOCTYPE html>
<html>
<head>
    <title>MCQ Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            margin: 20px;
        }
        .question-box {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .options {
            margin-top: 10px;
        }
        .options label {
            display: block;
            padding: 5px;
            cursor: pointer;
        }
        .match-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .match-table th, .match-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .match-table th {
            background: #f1f1f1;
        }
    </style>
</head>
<body>

    <h2>Online MCQ Test</h2>
    <form method="post" action="#">

        <?php 
        $q_no = 1;
        foreach($data as $row): 
        ?>
            <div class="question-box">
                <!-- Question -->
                <h4><strong><?= $q_no ?>. <?= $row->English_Q ?> </strong></h4>
                <p><em><?= $row->Tamil_Q ?></em></p>

                <!-- MATCH THE FOLLOWING (if available) -->
                <?php if(!empty($row->E_List_1) && !empty($row->E_List_2)): ?>
                    <h4>Match the Following:</h4>
                    <table class="match-table">
                        <tr>
                            <th>List - I</th>
                            <th>List - II</th>
                        </tr>
                        <?php 
                        $list1_eng = explode("\n", $row->E_List_1);
                        $list1_tam = explode("\n", $row->T_list_1);

                        $list2_eng = explode("\n", $row->E_List_2);
                        $list2_tam = explode("\n", $row->T_list_2);

                        $max_count = max(count($list1_eng), count($list2_eng));

                        for($i=0; $i<$max_count; $i++): 
                        ?>
                            <tr>
                                <td>
                                    <?php if(isset($list1_eng[$i]) && trim($list1_eng[$i])!=""): ?>
                                        <?= trim($list1_eng[$i]) ?>
                                        <?php if(isset($list1_tam[$i]) && trim($list1_tam[$i])!=""): ?>
                                            / <?= trim($list1_tam[$i]) ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(isset($list2_eng[$i]) && trim($list2_eng[$i])!=""): ?>
                                        <?= trim($list2_eng[$i]) ?>
                                        <?php if(isset($list2_tam[$i]) && trim($list2_tam[$i])!=""): ?>
                                            / <?= trim($list2_tam[$i]) ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </table>
                <?php endif; ?>

                <!-- OPTIONS (always come last) -->
                <?php if(!empty($row->E_options)): ?>
                    <div class="options">
                        <?php 
                        $eng_options = explode("\n", $row->E_options);
                        $tam_options = explode("\n", $row->T_options);

                        foreach($eng_options as $index => $opt): 
                            $opt_trim = trim($opt);
                            if($opt_trim == "") continue;
                        ?>
                            <label>
                                <input type="radio" name="answer[<?= $row->q_no ?>]" value="<?= $opt_trim ?>">
                                <?= $opt_trim ?>
                                <?php if(isset($tam_options[$index]) && trim($tam_options[$index]) != ""): ?>
                                    / <?= trim($tam_options[$index]) ?>
                                <?php endif; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php 
        $q_no++;
        endforeach; 
        ?>

        <button type="submit">Submit</button>
    </form>

</body>
</html>
