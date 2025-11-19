<?php
// File: /workspaces/formant/src/presentation/home.php

// Simulate data for recently viewed forms, draft responses, and submitted responses
$recentForms = [
    ['id' => 1, 'title' => 'Employee Feedback Form', 'lastViewed' => '2023-10-01'],
    ['id' => 2, 'title' => 'Customer Satisfaction Survey', 'lastViewed' => '2023-10-02'],
    ['id' => 3, 'title' => 'Project Evaluation Form', 'lastViewed' => '2023-10-03'],
];

$draftResponses = [
    ['id' => 101, 'formTitle' => 'Employee Feedback Form', 'lastEdited' => '2023-10-04'],
    ['id' => 102, 'formTitle' => 'Customer Satisfaction Survey', 'lastEdited' => '2023-10-05'],
];

$submittedResponses = [
    ['id' => 201, 'formTitle' => 'Employee Feedback Form', 'submittedOn' => '2023-10-06'],
    ['id' => 202, 'formTitle' => 'Customer Satisfaction Survey', 'submittedOn' => '2023-10-07'],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        .section {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Dashboard</h1>

    <div class="section">
        <h2>Recently Viewed Forms</h2>
        <table>
            <thead>
                <tr>
                    <th>Form Title</th>
                    <th>Last Viewed</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentForms as $form): ?>
                    <tr>
                        <td><?= htmlspecialchars($form['title']) ?></td>
                        <td><?= htmlspecialchars($form['lastViewed']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Draft Responses</h2>
        <table>
            <thead>
                <tr>
                    <th>Form Title</th>
                    <th>Last Edited</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($draftResponses as $draft): ?>
                    <tr>
                        <td><?= htmlspecialchars($draft['formTitle']) ?></td>
                        <td><?= htmlspecialchars($draft['lastEdited']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Submitted Responses</h2>
        <table>
            <thead>
                <tr>
                    <th>Form Title</th>
                    <th>Submitted On</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submittedResponses as $response): ?>
                    <tr>
                        <td><?= htmlspecialchars($response['formTitle']) ?></td>
                        <td><?= htmlspecialchars($response['submittedOn']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>