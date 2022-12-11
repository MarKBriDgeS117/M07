<?php

class BaseDades
{

    public static $hostname = "localhost";
    public static $dbname = "dwes-mpont-concursgoss";
    public static $username = "marc";
    public static $pw = "Patata123";

    /**
     * Crea una connexió a la base de dades.
     *
     * @return $pdo Retorna la connexió. 
     */
    static function conectarse(): bool|PDO
    {
        try {
            $pdo = new PDO("mysql:host=" . BaseDades::$hostname . ";dbname=" . BaseDades::$dbname . "", "" . BaseDades::$username . "", "" . BaseDades::$pw . "");
            return $pdo;
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            return false;
        }
    }
}
