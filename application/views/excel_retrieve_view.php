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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .question-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #222;
        }

        .question-box p {
            margin: 5px 0;
            font-weight: normal;
        }

        .match-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            table-layout: fixed;
        }

        .match-table th,
        .match-table td {
            border: 1px solid #ccc;
            padding: 12px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .match-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

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
            position: relative;
        }

        .options label:hover {
            background: #e0f7e0;
            border-color: #4CAF50;
        }

        .options input[type="radio"] {
            display: none;
        }

        .options input[type="radio"]:checked+span {
            background: #4CAF50;
            color: white;
            display: block;
            border-radius: 8px;
        }

        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #45a049;
        }

        /* ✅ Answer Box */
        .answer-box {
            margin-top: 15px;
            padding: 12px;
            background: #e8f5e9;
            border-left: 5px solid #4CAF50;
            border-radius: 6px;
            display: none;
            color: #222;
        }

        .view-btn {
            margin-top: 15px;
            background: #2196F3;
        }

        .view-btn:hover {
            background: #1976D2;
        }

        /* ✅ Correct/Wrong Highlight */
        .correct {
            background: #d4edda !important;
            border: 1px solid #28a745 !important;
            color: #155724 !important;
        }

        .correct::after {
            content: " ✔";
            font-weight: bold;
            color: #28a745;
        }

        .wrong {
            background: #f8d7da !important;
            border: 1px solid #dc3545 !important;
            color: #721c24 !important;
        }

        .wrong::after {
            content: " ✖";
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>

<body>

    <h2>Online MCQ Test</h2>

    <form method="post" action="#">

        <?php $q_no = 1;
        foreach ($data as $row): ?>
            <div class="question-box">

                <!-- English Question -->
                <?php if (!empty($row->English_Question)): ?>
                    <p class="question-title"><strong><?= $q_no ?>. <?= $row->English_Question ?></strong></p>
                <?php endif; ?>

                <!-- English Statements -->
                <?php
                foreach ($row as $col => $val) {
                    if (stripos($col, "English_statement") !== false && $val !== null && trim($val) !== '') {
                        echo "<p>" . trim($val) . "</p>";
                    }
                }
                ?>

                <?php if (!empty($row->English_Assertion))
                    echo "<p>Assertion: " . $row->English_Assertion . "</p>"; ?>
                <?php if (!empty($row->English_Reason))
                    echo "<p>Reason: " . $row->English_Reason . "</p>"; ?>

                <!-- Tamil Question -->
                <?php if (!empty($row->Tamil_Question))
                    echo "<p class='question-title'><strong>" . $q_no . ". " . $row->Tamil_Question . "</strong></p>"; ?>

                <!-- Tamil Statements -->
                <?php
                foreach ($row as $col => $val) {
                    if (stripos($col, "Tamil_statement") !== false && $val !== null && trim($val) !== '') {
                        echo "<p>" . trim($val) . "</p>";
                    }
                }
                ?>

                <?php if (!empty($row->Tamil_Assertion))
                    echo "<p>Assertion: " . $row->Tamil_Assertion . "</p>"; ?>
                <?php if (!empty($row->Tamil_Reason))
                    echo "<p>Reason: " . $row->Tamil_Reason . "</p>"; ?>

                <!-- Match the Following -->
                <?php if (!empty($row->English_match_left) && !empty($row->English_match_right)): ?>
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
                        for ($i = 0; $i < $max_count; $i++):
                            ?>
                            <tr>
                                <td>
                                    <strong><?= chr(65 + $i) ?>.</strong>
                                    <div>
                                        <?= isset($list1_eng[$i]) ? trim((string) $list1_eng[$i]) : '' ?>
                                        <?php if (isset($list1_tam[$i]) && trim((string) $list1_tam[$i]) != ""): ?>
                                            <br><em><?= trim($list1_tam[$i]) ?></em>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <strong><?= $i + 1 ?>.</strong>
                                    <div>
                                        <?= isset($list2_eng[$i]) ? trim((string) $list2_eng[$i]) : '' ?>
                                        <?php if (isset($list2_tam[$i]) && trim((string) $list2_tam[$i]) != ""): ?>
                                            <br><em><?= trim($list2_tam[$i]) ?></em>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </table>
                <?php endif; ?>

                <!-- Options -->
                <?php if (!empty($row->E_option_1) || !empty($row->E_option_2) || !empty($row->E_option_3) || !empty($row->E_option_4)): ?>
                    <div class="options" id="opts<?= $q_no ?>">
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

                        foreach ($eng_options as $index => $opt):
                            $opt_trim = trim((string) $opt);
                            if ($opt_trim == "")
                                continue;
                            ?>
                            <label data-correct="<?= ($row->English_answer == $opt_trim || $row->Tamil_answer == trim((string)$tam_options[$index])) ? '1' : '0' ?>">
                                <input type="radio" name="answer[<?= $row->q_no ?>]" value="<?= $opt_trim ?>">
                                <span><?= $opt_trim ?><?php if (!empty($tam_options[$index]))
                                      echo " / " . trim((string) $tam_options[$index]); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- ✅ Answer View Button + Answer Box -->
                <button type="button" class="view-btn" onclick="toggleAnswer('ans<?= $q_no ?>','opts<?= $q_no ?>')">View Answer</button>
                <div id="ans<?= $q_no ?>" class="answer-box">
                    <strong>Answer:</strong><?= $row->English_answer ?>/<?= $row->Tamil_answer ?>
                </div>

            </div>
            <?php $q_no++; endforeach; ?>

        <button type="submit">Submit</button>
    </form>

    <script>
        function toggleAnswer(ansId, optId) {
            var box = document.getElementById(ansId);
            box.style.display = (box.style.display === "block") ? "none" : "block";

            if (box.style.display === "block") {
                let options = document.querySelectorAll("#" + optId + " label");
                options.forEach(opt => {
                    opt.classList.remove("correct", "wrong");
                    if (opt.getAttribute("data-correct") === "1") {
                        opt.classList.add("correct"); // ✅ mark correct option
                    } else if (opt.querySelector("input").checked) {
                        opt.classList.add("wrong"); // ❌ mark wrong if chosen
                    }
                });
            }
        }
    </script>

</body>

</html>