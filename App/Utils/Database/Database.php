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

    public function requeteSimple(string $sql,string $fetchmode = 'fetchAll') {
        return $this->conx->query($sql,PDO::FETCH_ASSOC)->{$fetchmode}();
    }

    public function requeteRandomQ($table,string $fetchmode = 'fetchAll') {
        return $this->conx->query('SELECT * FROM `'. $table .'` ORDER BY RAND() LIMIT 6 ',PDO::FETCH_ASSOC)->{$fetchmode}();
    }

    public function requeteRandomA($table,string $fetchmode = 'fetchAll') {
        return $this->conx->query('SELECT * FROM '. $table .' WHERE '. $table .'.id = '. $table .'.question_id',PDO::FETCH_ASSOC)->{$fetchmode}();
    }
    public function request(string $selected, string $from, bool $where = false, string $key = '', string $val = '', bool $order = false, string $whatOrder = '', string $direction = 'DESC', bool $limit = false, string $howMany = '', string $fetchMode = 'fetchAll')
    {
        $completion = '';

        if ($where) {
            $completion = ' WHERE ' . $key . '=' . $val;
        }
        if ($order) {
            $completion .= ' ORDER BY ' . $whatOrder . ' ' . $direction;
        }
        if ($limit) {
            $completion .= ' LIMIT ' . $howMany;
        }
        if (!$where && !$order && !$limit) {
            $completion = null;
        }
        $sql = 'SELECT ' . $selected . ' FROM ' . $from . $completion;
        return $this->dbh->query($sql, PDO::FETCH_ASSOC)->{$fetchMode}();
    }

    // Retourne l'id de la dernière insertion par auto-incrément dans la base de données
    public function dernierIndex(): string
    {
        return $this->conx->lastInsertId();
    }
}
