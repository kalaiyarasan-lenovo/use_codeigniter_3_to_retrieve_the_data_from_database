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
            background: #131414ff;
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

        .view-btn {
            margin-top: 15px;
            background: #ddd208ff;
        }

        .view-btn:hover {
            background: #d2bd19ff;
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

        /* ✅ Result Summary */
        #result-summary {
            display: none;
            text-align: center;
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        #pagination {
            text-align: center;
            margin: 20px 0;
        }

        #pagination button {
            margin: 5px;
            background: #007bff;
        }

        #pagination button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <h2>Online MCQ Test</h2>

    <form method="post" action="#">
        <div id="question-container">
            <?php $q_no = 1;
            foreach ($data as $row): ?>
                <div class="question-box" data-qid="<?= $row->q_no ?>">

                    <!-- English Question -->
                    <?php if (!empty($row->English_Question)): ?>
                        <p class="question-title"><strong><?= $q_no ?>. <?= $row->English_Question ?></strong></p>
                    <?php endif; ?>

                    <!-- Statements / Assertions / Reasons -->
                    <?php
                    foreach ($row as $col => $val) {
                        if (stripos($col, "English_statement") !== false && $val !== null && trim($val) !== '') {
                            echo "<p>" . trim($val) . "</p>";
                        }
                    }
                    if (!empty($row->English_Assertion))
                        echo "<p>Assertion: " . $row->English_Assertion . "</p>";
                    if (!empty($row->English_Reason))
                        echo "<p>Reason: " . $row->English_Reason . "</p>";

                    if (!empty($row->Tamil_Question))
                        echo "<p class='question-title'><strong>" . $q_no . ". " . $row->Tamil_Question . "</strong></p>";

                    foreach ($row as $col => $val) {
                        if (stripos($col, "Tamil_statement") !== false && $val !== null && trim($val) !== '') {
                            echo "<p>" . trim($val) . "</p>";
                        }
                    }
                    if (!empty($row->Tamil_Assertion))
                        echo "<p>Assertion: " . $row->Tamil_Assertion . "</p>";
                    if (!empty($row->Tamil_Reason))
                        echo "<p>Reason: " . $row->Tamil_Reason . "</p>";
                    ?>

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
                            for ($i = 0; $i < $max_count; $i++): ?>
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
                            $eng_options = [$row->E_option_1, $row->E_option_2, $row->E_option_3, $row->E_option_4];
                            $tam_options = [$row->T_option_1, $row->T_option_2, $row->T_option_3, $row->T_option_4];

                            foreach ($eng_options as $index => $opt):
                                $opt_trim = trim((string) $opt);
                                if ($opt_trim == "")
                                    continue; ?>
                                <label
                                    data-correct="<?= ($row->English_answer == $opt_trim || $row->Tamil_answer == trim((string) $tam_options[$index])) ? '1' : '0' ?>">
                                    <input type="radio" name="answer[<?= $row->q_no ?>]" value="<?= $opt_trim ?>">
                                    <span><?= $opt_trim ?><?php if (!empty($tam_options[$index]))
                                          echo " / " . trim((string) $tam_options[$index]); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- ✅ Answer View Button + Answer Box -->
                    <button type="button" class="view-btn"
                        onclick="toggleAnswer('ans<?= $q_no ?>','opts<?= $q_no ?>','<?= $row->q_no ?>')">View Correct
                        Answer</button>
                    <div id="ans<?= $q_no ?>" class="answer-box">
                        <strong>Answer:</strong> <?= $row->English_answer ?> / <?= $row->Tamil_answer ?>
                    </div>

                </div>
                <?php $q_no++; endforeach; ?>
        </div>

        <!-- Pagination -->
        <div id="pagination">
            <button type="button" id="prevBtn">Previous</button>
            <button type="button" id="nextBtn">Next</button>
            <button type="submit" id="submitBtn">Submit</button>
            <button type="button" onclick="window.history.back()">Back</button>

        </div>
    </form>

    <!-- ✅ Result Summary -->
    <div id="result-summary">
        <h3 id="answered"></h3>
        <p style="color:green;">Correct Answer(s): <span id="correct"></span></p>
        <p style="color:red;">Wrong Answer(s): <span id="wrong"></span></p>
        <p>Total questions Attempted: <span id="attempted"></span></p>
        <p style="color:blue;">View Answer(s) Clicked: <span id="viewed"></span></p>
    </div>

    <script>
        let viewAnswerCount = 0; // ✅ counter for view answer clicks
        let currentPage = 1;
        const questionsPerPage = 10;
        const questions = document.querySelectorAll(".question-box");
        const totalPages = Math.ceil(questions.length / questionsPerPage);

        function showPage(page) {
            questions.forEach((q, index) => {
                q.style.display = (index >= (page - 1) * questionsPerPage && index < page * questionsPerPage) ? "block" : "none";
            });
            document.getElementById("prevBtn").style.display = (page === 1) ? "none" : "inline-block";
            document.getElementById("nextBtn").style.display = (page === totalPages) ? "none" : "inline-block";
            document.getElementById("submitBtn").style.display = (page === totalPages) ? "inline-block" : "none";
        }

        document.getElementById("prevBtn").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        document.getElementById("nextBtn").addEventListener("click", () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        // ✅ Initial load
        showPage(currentPage);

        function toggleAnswer(ansId, optId, qid) {
            var box = document.getElementById(ansId);
            let wasHidden = (box.style.display !== "block");

            box.style.display = (box.style.display === "block") ? "none" : "block";

            if (wasHidden) {
                viewAnswerCount++;
                if (qid) {
                    document.querySelector(`.question-box[data-qid='${qid}']`)
                        .setAttribute("data-viewed", "1");
                }
            }

            if (box.style.display === "block") {
                let options = document.querySelectorAll("#" + optId + " label");
                options.forEach(opt => {
                    opt.classList.remove("correct", "wrong");
                    if (opt.getAttribute("data-correct") === "1") {
                        opt.classList.add("correct");
                    } else if (opt.querySelector("input").checked) {
                        opt.classList.add("wrong");
                    }
                });
            }
        }

        // ✅ Evaluate results when form is submitted
        document.querySelector("form").addEventListener("submit", function (e) {
            e.preventDefault();

            let totalQuestions = document.querySelectorAll(".question-box").length;
            let correct = 0, wrong = 0, attempted = 0;

            document.querySelectorAll(".question-box").forEach(qBox => {
                let optGroup = qBox.querySelector(".options");
                let selected = optGroup ? optGroup.querySelector("input[type='radio']:checked") : null;
                let viewed = qBox.getAttribute("data-viewed") === "1";

                if (selected) {
                    attempted++;
                    if (!viewed) { // ✅ only count if "View Answer" not clicked
                        let label = selected.closest("label");
                        if (label.getAttribute("data-correct") === "1") {
                            correct++;
                        } else {
                            wrong++;
                        }
                    }
                }
            });

            // ✅ Show summary
            document.getElementById("result-summary").style.display = "block";
            document.getElementById("answered").innerText = `You answered ${attempted}/${totalQuestions} questions`;
            document.getElementById("correct").innerText = correct;
            document.getElementById("wrong").innerText = wrong;
            document.getElementById("attempted").innerText = attempted;
            document.getElementById("viewed").innerText = viewAnswerCount;

            document.getElementById("result-summary").scrollIntoView({ behavior: "smooth" });
        });
    </script>

</body>

</html>