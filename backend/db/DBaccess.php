<?php
/**
 * DB-Verbindungsklasse
 * Verwaltet die Datenbankverbindung
 */
class DBaccess {
    private $db;

    public function __construct() {
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "webProjekt26";

        $this->db = new mysqli($host, $user, $password, $database);

        if ($this->db->connect_error) {
            throw new Exception("Connection Error: " . $this->db->connect_error);
        }
    }

    /**
     * Gibt die mysqli-Verbindung zurück
     */
    public function getConnection(): mysqli {
        return $this->db;
    }
}
?>