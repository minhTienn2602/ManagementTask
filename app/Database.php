<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'taskmanagementdb';

    public function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $pdo = new PDO($dsn, $this->username, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }
}
?>