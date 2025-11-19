/**
 * Simple PHP Form Builder and Submission App
 *
 * This script implements a basic form builder and submission system using file-based storage.
 * It provides the following features:
 * - Home page with navigation links.
 * - Create a new form with a title and multiple questions.
 * - List all created forms.
 * - View a form and submit answers.
 * - Store form definitions and responses as JSON files.
 *
 * Main Components:
 * 1. Routing: Determines the page to display based on the 'page' GET parameter.
 * 2. header_html($title): Outputs the HTML header and opening tags for the page.
 * 3. footer_html(): Outputs the closing HTML tags for the page.
 * 4. Home Page ('home'): Displays navigation links to create or list forms.
 * 5. Form Storage: Uses a directory ('forms') to store form definitions and responses as JSON files.
 * 6. Create Form ('create'): Handles form creation via POST, saves form data, and provides a UI to add questions dynamically.
 * 7. List Forms ('list'): Lists all saved forms with links to view each form.
 * 8. View Form ('view'): Displays a form for users to answer questions and submit responses.
 * 9. Submit Form ('submit'): Handles form submission, saves responses, and displays a thank you message.
 * 10. Error Handling: Displays a "Page not found" message for unknown routes or missing forms.
 *
 * Security Notes:
 * - Form and response file names are sanitized to prevent directory traversal.
 * - User input is escaped with htmlspecialchars() when displayed.
 *
 * Usage:
 * - Place this script in a PHP-enabled web server.
 * - Forms and responses are stored in the 'forms' directory relative to the script.
 */
<?php
// src/index.php

// Simple router for demonstration
$page = $_GET['page'] ?? 'home';

function header_html($title = "Formant") {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>$title</title>
        <meta charset='utf-8'>
        <style>
            body { font-family: Arial, sans-serif; margin: 2em; }
            .container { max-width: 700px; margin: auto; }
            .form-section { margin-bottom: 2em; }
            input, textarea, select { width: 100%; padding: 0.5em; margin: 0.5em 0; }
            button { padding: 0.5em 1em; }
            .question { margin-bottom: 1em; }
        </style>
    </head>
    <body>
    <div class='container'>";
}

function footer_html() {
    echo "</div></body></html>";
}

if ($page === 'home') {
    header_html();
    echo "<h1>Formant</h1>
    <p><a href='?page=create'>Create a new form</a></p>
    <p><a href='?page=list'>View all forms</a></p>";
    footer_html();
    exit;
}

// Simple file-based storage for demonstration
define('FORM_DIR', __DIR__ . '/../forms');
if (!is_dir(FORM_DIR)) mkdir(FORM_DIR, 0777, true);

if ($page === 'create') {
    header_html("Create Form");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $questions = $_POST['questions'] ?? [];
        if ($title && $questions) {
            $form = [
                'title' => $title,
                'questions' => array_values(array_filter($questions)),
                'created' => time()
            ];
            $id = uniqid('form_', true);
            file_put_contents(FORM_DIR . "/$id.json", json_encode($form));
            echo "<p>Form created! <a href='?page=view&id=$id'>View form</a></p>";
            footer_html();
            exit;
        } else {
            echo "<p style='color:red'>Please provide a title and at least one question.</p>";
        }
    }
    ?>
    <h2>Create a New Form</h2>
    <form method="post">
        <div class="form-section">
            <label>Form Title:</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-section" id="questions">
            <label>Questions:</label>
            <div class="question">
                <input type="text" name="questions[]" placeholder="Enter a question" required>
            </div>
        </div>
        <button type="button" onclick="addQuestion()">Add another question</button>
        <button type="submit">Create Form</button>
    </form>
    <script>
    function addQuestion() {
        const div = document.createElement('div');
        div.className = 'question';
        div.innerHTML = '<input type="text" name="questions[]" placeholder="Enter a question" required>';
        document.getElementById('questions').appendChild(div);
    }
    </script>
    <?php
    footer_html();
    exit;
}

if ($page === 'list') {
    header_html("All Forms");
    echo "<h2>All Forms</h2><ul>";
    foreach (glob(FORM_DIR . '/*.json') as $file) {
        $id = basename($file, '.json');
        $form = json_decode(file_get_contents($file), true);
        echo "<li><a href='?page=view&id=$id'>" . htmlspecialchars($form['title']) . "</a></li>";
    }
    echo "</ul><p><a href='?page=home'>Back to home</a></p>";
    footer_html();
    exit;
}

if ($page === 'view' && isset($_GET['id'])) {
    $id = preg_replace('/[^a-zA-Z0-9_\.\-]/', '', $_GET['id']);
    $file = FORM_DIR . "/$id.json";
    if (!file_exists($file)) {
        header_html("Form Not Found");
        echo "<p>Form not found.</p>";
        footer_html();
        exit;
    }
    $form = json_decode(file_get_contents($file), true);
    header_html(htmlspecialchars($form['title']));
    echo "<h2>" . htmlspecialchars($form['title']) . "</h2>";
    echo "<form method='post' action='?page=submit&id=$id'>";
    foreach ($form['questions'] as $i => $q) {
        echo "<div class='form-section'><label>" . htmlspecialchars($q) . "</label>
        <input type='text' name='answers[$i]' required></div>";
    }
    echo "<button type='submit'>Submit</button></form>";
    echo "<p><a href='?page=home'>Back to home</a></p>";
    footer_html();
    exit;
}

if ($page === 'submit' && isset($_GET['id'])) {
    $id = preg_replace('/[^a-zA-Z0-9_\.\-]/', '', $_GET['id']);
    $file = FORM_DIR . "/$id.json";
    if (!file_exists($file)) {
        header_html("Form Not Found");
        echo "<p>Form not found.</p>";
        footer_html();
        exit;
    }
    $form = json_decode(file_get_contents($file), true);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
        $answers = $_POST['answers'];
        $response = [
            'time' => time(),
            'answers' => $answers
        ];
        $responses_file = FORM_DIR . "/$id.responses.json";
        $responses = file_exists($responses_file) ? json_decode(file_get_contents($responses_file), true) : [];
        $responses[] = $response;
        file_put_contents($responses_file, json_encode($responses));
        header_html("Thank You");
        echo "<h2>Thank you for your response!</h2>";
        echo "<p><a href='?page=home'>Back to home</a></p>";
        footer_html();
        exit;
    }
}

header_html("Page Not Found");
echo "<p>Page not found.</p>";
footer_html();