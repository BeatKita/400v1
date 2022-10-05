<?php

namespace PERCOLATOR\MinQuiz\Utils\Database;
require '../config/app.php';
use PDO, PDOException;

class PdoDb
{

    private static $connect = null;
    private PDO $conx;

    public function __construct()
    {

        global $conf;

        try {
            $this->conx = new PDO('mysql:host=' . $conf['db']['host'] . ';dbname=' . $conf['db']['database'], $conf['db']['user'], $conf['db']['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
            $this->conx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $message = 'Erreur ! ' . $e->getMessage() . '<hr />';
            die($message);
        }
    }

    public function requeteSimple(string $table,string $fetchmode = 'fetchAll') {
        return $this->conx->query('SELECT * FROM '. $table .' WHERE ID = 1',PDO::FETCH_ASSOC)->{$fetchmode}();
    }

    public function requeteRandomQ($table,string $fetchmode = 'fetchAll') {
        return $this->conx->query('SELECT * FROM '. $table .' ORDER BY RAND() LIMIT 6 ',PDO::FETCH_ASSOC)->{$fetchmode}();
    }

    public function requeteRandomA($table,string $fetchmode = 'fetchAll') {
        return $this->conx->query('SELECT * FROM '. $table .' WHERE ' . $table . '.id = question-id.' . $table . '',PDO::FETCH_ASSOC)->{$fetchmode}();
    }
    
    // Retourne l'id de la dernière insertion par auto-incrément dans la base de données
    public function dernierIndex(): string
    {
        return $this->conx->lastInsertId();
    }
}
