<!DOCTYPE html>
<html>
<head>
    <title>Online Test</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #eef2f7; padding: 20px; }
        h2 { text-align: center; margin-bottom: 30px; color: #333; }
        .question-box { background: #fff; padding: 25px; margin-bottom: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .question-title { font-weight: bold; margin-bottom: 10px; color: #222; }
        .options { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px; }
        .options label { flex: 1 1 calc(50% - 10px); background: #f7f7f7; padding: 12px; border-radius: 8px; cursor: pointer; border: 1px solid #ddd; transition: 0.3s; text-align: center; position: relative; }
        .options label:hover { background: #060606; color: white; }
        .options input[type="radio"] { display: none; }
        .options input[type="radio"]:checked+span { background: #0d40f8; color: white; display: block; border-radius: 0px; }
        button { background: #4CAF50; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-size: 15px; cursor: pointer; transition: 0.3s; }
        button:hover { background: #45a049; }
        .answer-box { margin-top: 15px; padding: 12px; background: #e8f5e9; border-left: 5px solid #4CAF50; border-radius: 6px; display: none; color: #222; }
        .view-btn { margin-top: 15px; background: #ddd208; }
        .view-btn:hover { background: #d2bd19; }
        .correct { background: #d4edda !important; border: 1px solid #28a745 !important; color: #155724 !important; }
        .wrong { background: #f8d7da !important; border: 1px solid #dc3545 !important; color: #721c24 !important; }
        .tick::after { content: "✔"; color: green; font-weight: bold; position: absolute; right: 10px; }
        .cross::after { content: "✘"; color: red; font-weight: bold; position: absolute; right: 10px; }
        #result-summary { display: none; text-align: center; margin-top: 20px; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        #result-summary h3 { color: #333; }
        #result-summary p { margin: 5px 0; font-size: 16px; }
        table.match-table { width:100%; margin-top:10px; border-collapse: collapse; }
        table.match-table th, table.match-table td { padding: 8px; border: 1px solid #ccc; }
        table.match-table select { padding: 6px; border-radius: 6px; }
    </style>
</head>
<body>

<h2>Online Test</h2>

<form method="post" action="#">
    <?php foreach ($questions as $row): ?>
        <div class="question-box" data-qid="<?= $row->Q_no ?>" data-viewed="0">

            <!-- Question -->
            <p class="question-title"><strong><?= $row->Q_no ?>. <?= $row->Question ?></strong></p>

            <?php if (!empty($row->Column_A) && !empty($row->Column_B)): ?>
                <!-- Match the Following -->
                <?php
                $colA_items = explode(",", $row->Column_A);
                $colB_items = explode(",", $row->Column_B);
                $letters = ["A","B","C","D","E"];
                ?>
                <table class="match-table">
                    <tr>
                        <th>Column A</th>
                        <th>Column B</th>
                    </tr>
                    <?php foreach ($colA_items as $i => $aItem): ?>
                        <tr>
                            <td><?= $letters[$i] ?>) <?= trim($aItem) ?></td>
                            <td>
                                <select name="match[<?= $row->Q_no ?>][<?= $letters[$i] ?>]">
                                    <option value="">-- Select --</option>
                                    <?php foreach ($colB_items as $j => $bItem): ?>
                                        <option value="<?= $j+1 ?>"><?= ($j+1) ?>) <?= trim($bItem) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            <?php else: ?>
                <!-- MCQ Options -->
                <div class="options" id="opts<?= $row->Q_no ?>">
                    <?php
                    $opts = [$row->Option_1, $row->Option_2, $row->Option_3, $row->Option_4];
                    foreach ($opts as $opt):
                        $opt_trim = trim((string) $opt);
                        if ($opt_trim == "") continue;
                        $isCorrect = (trim($row->Correct_Answer) === $opt_trim) ? 1 : 0;
                    ?>
                        <label data-correct="<?= $isCorrect ?>">
                            <input type="radio" name="answer[<?= $row->Q_no ?>]" value="<?= $opt_trim ?>">
                            <span><?= $opt_trim ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Answer Box -->
            <button type="button" class="view-btn"
                onclick="toggleAnswer('ans<?= $row->Q_no ?>','opts<?= $row->Q_no ?>', <?= $row->Q_no ?>)">View Answer</button>
            <div id="ans<?= $row->Q_no ?>" class="answer-box">
                <strong>Answer:</strong> <?= $row->Correct_Answer ?? $row->Answer_Key ?>
            </div>
        </div>
    <?php endforeach; ?>

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
    let viewAnswerCount = 0;

    function toggleAnswer(ansId, optId, qid) {
        var box = document.getElementById(ansId);
        let wasHidden = (box.style.display !== "block");
        box.style.display = (box.style.display === "block") ? "none" : "block";

        if (wasHidden) {
            viewAnswerCount++;
            document.querySelector(`.question-box[data-qid='${qid}']`).setAttribute("data-viewed", "1");

            let optGroup = document.getElementById(optId);
            if (optGroup) {
                let selected = optGroup.querySelector("input[type='radio']:checked");

                // Clear old marks
                optGroup.querySelectorAll("label").forEach(l => {
                    l.classList.remove("correct", "wrong", "tick", "cross");
                });

                if (selected) {
                    let label = selected.closest("label");
                    if (label.dataset.correct === "1") {
                        label.classList.add("correct", "tick");   // ✅ Correct one
                    } else {
                        label.classList.add("wrong", "cross");    // ❌ Wrong chosen
                        optGroup.querySelector("label[data-correct='1']").classList.add("correct", "tick");
                    }
                } else {
                    // Nothing selected → just show correct
                    optGroup.querySelector("label[data-correct='1']").classList.add("correct", "tick");
                }
            }
        }
    }

    document.querySelector("form").addEventListener("submit", function (e) {
        e.preventDefault();
        let totalQuestions = document.querySelectorAll(".question-box").length;
        let correct = 0, wrong = 0, attempted = 0;

        document.querySelectorAll(".question-box").forEach(qBox => {
            let optGroup = qBox.querySelector(".options");
            let selected = optGroup ? optGroup.querySelector("input[type='radio']:checked") : null;

            if (selected) {
                attempted++;
                let label = selected.closest("label");
                if (label.getAttribute("data-correct") === "1") {
                    label.classList.add("correct", "tick");
                    correct++;
                } else {
                    label.classList.add("wrong", "cross");
                    wrong++;
                    optGroup.querySelector("label[data-correct='1']").classList.add("correct", "tick");
                }
            }
        });

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
