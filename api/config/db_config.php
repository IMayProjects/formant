<?php

use Pdo\Pgsql;

require_once 'dotenv_handler.php';
loadEnv('../../.env');
// credentials


// create connection

function get_connection()
{
    $host = $_ENV['DB_HOST'];
    $port = $_ENV['DB_PORT'];
    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASS'];
    $dbname = $_ENV['DB_NAME'];

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pgconn = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        echo "Connected to PostgreSQL!";

        return $pgconn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

$con = get_connection();

// Close connection

$sql = /** sql */ "
CREATE TABLE IF NOT EXISTS users (
id SERIAL PRIMARY KEY,
username VARCHAR(50) NOT NULL,
email VARCHAR(100)  NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";
$con->exec($sql);

?>