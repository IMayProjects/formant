<?php
function loadEnv($filePath)
{
    if (!file_exists($filePath))
        throw new Exception("Could not find specified .env file: {$filePath}");

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        //skip comments
        if (strpos(trim($line), '#') === 0) continue;

        // Parse env value
        [$name,$value] = explode('=', $line,2);
        $name = trim($name);
        $value = trim($value);

        // Set env value
        $_ENV[$name] = $value;
    }
}