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
            background: #060606;
            border-color: #030303;
            color: white;
        }

        .options input[type="radio"] {
            display: none;
        }

        .options input[type="radio"]:checked+span {
            background: #0d40f8;
            color: white;
            display: block;
            border-radius: 0px;
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
            background: #ddd208ff;
        }

        .view-btn:hover {
            background: #d2bd19ff;
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

        #result-summary h3 {
            color: #333;
        }

        #result-summary p {
            margin: 5px 0;
            font-size: 16px;
        }

        /* ✅ Pagination Controls */
        #pagination {
            text-align: center;
            margin: 20px 0;
        }

        #pagination button {
            margin: 5px;
            background: #007BFF;
        }

        #pagination button:hover {
            background: #0056b3;
        }

        #page-info {
            font-weight: bold;
            margin: 0 10px;
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
                <button type="button" class="view-btn" onclick="toggleAnswer('ans<?= $q_no ?>','opts<?= $q_no ?>')">
                    View Correct Answer
                </button>
                <div id="ans<?= $q_no ?>" class="answer-box">
                    <strong>Answer:</strong> <?= $row->English_answer ?>/<?= $row->Tamil_answer ?>
                </div>

            </div>
            <?php $q_no++; endforeach; ?>

        <!-- ✅ Pagination Controls -->
        <div id="pagination">
            <button type="button" id="prevBtn" onclick="prevPage()">Previous</button>
            <span id="page-info"></span>
            <button type="button" id="nextBtn" onclick="nextPage()">Next</button>
        </div>

        <button type="submit">Submit</button>
        <button type="button" onclick="window.history.back()">Back</button>
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
const questionsPerPage = 10;   // ✅ Show 10 questions per page
const questions = document.querySelectorAll(".question-box");
const totalPages = Math.ceil(questions.length / questionsPerPage);

// ✅ Show/Hide Answers
function toggleAnswer(ansId, optId) {
    var box = document.getElementById(ansId);
    let wasHidden = (box.style.display !== "block");

    box.style.display = (box.style.display === "block") ? "none" : "block";

    if (wasHidden) {
        viewAnswerCount++;
        box.closest(".question-box").setAttribute("data-viewed", "1");
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

// ✅ Pagination Logic
function showPage(page) {
    questions.forEach((q, i) => {
        q.style.display = (i >= (page - 1) * questionsPerPage && i < page * questionsPerPage) ? "block" : "none";
    });

    document.getElementById("page-info").innerText = `Page ${page} of ${totalPages}`;
    document.getElementById("prevBtn").style.display = (page === 1) ? "none" : "inline-block";
    document.getElementById("nextBtn").style.display = (page === totalPages) ? "none" : "inline-block";
}

function nextPage() {
    if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
}

// ✅ Initialize first page
showPage(currentPage);

// ✅ Evaluate results when form is submitted
document.querySelector("form").addEventListener("submit", function(e) {
    e.preventDefault();

    let totalQuestions = document.querySelectorAll(".question-box").length;
    let correct = 0, wrong = 0, attempted = 0;

    document.querySelectorAll(".question-box").forEach(qBox => {
        let optGroup = qBox.querySelector(".options");
        let selected = optGroup ? optGroup.querySelector("input[type='radio']:checked") : null;
        let viewed = qBox.getAttribute("data-viewed") === "1";

        if (selected) {
            attempted++;
            if (!viewed) {
                let label = selected.closest("label");
                if (label.getAttribute("data-correct") === "1") {
                    correct++;
                } else {
                    wrong++;
                }
            }
        }
    });

    document.getElementById("result-summary").style.display = "block";
    document.getElementById("answered").innerText = `You answered ${attempted}/${totalQuestions} questions`;
    document.getElementById("correct").innerText = correct;
    document.getElementById("wrong").innerText = wrong;
    document.getElementById("attempted").innerText = attempted;
    document.getElementById("viewed").innerText = viewAnswerCount;

    document.getElementById("result-summary").scrollIntoView({behavior: "smooth"});
});
</script>

</body>
</html>
