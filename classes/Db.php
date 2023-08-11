<?php

require_once __DIR__ . "/Functions.php";


class Db
{
    private $host = 'localhost';
    private $user = 'root';
    private $pwd = '';
    private $dbName = 'registration';
    protected $con;
    private $options = [PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC];

    public function openConnection()
    {
        try {

            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
            $connection = $this->con = new PDO($dsn, $this->user, $this->pwd, $this->options);
            return $connection;
        } catch (PDOException $e) {
            Functions::setSessionMessage('There is a problem with the connection . $e', 'success');
            Functions::redirect('index.php');
        }
    }




    public function executeQuery($query, $data = null, $fetchMode = 1)
    {
        $stmt = $this->openConnection()->prepare($query);
        if ($data !== null) {
            $row = $stmt->execute($data);
        }
        if ($data == null) {
            $row = $stmt->execute();
        }
        if ($fetchMode == 1) {

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        }
        if ($fetchMode == 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        if ($fetchMode == 3) {

            return $row;
        }
    }

    public function select($table, $row = "*", $join = null, $where = null)
    {
        $query = 'SELECT ' . $row . ' FROM ' . $table;
        if ($join != null) {
            $query .= ' JOIN ' . $join;
        }
        if ($where != null) {
            $query .= ' WHERE ' . $table . '.id = ' . $where;
        }
        return $query;
    }


    public function update($table, $row)
    {
        $query = 'UPDATE ' . $table . ' SET ' . $row . ' WHERE id = :id';
        return $query;
    }



    public function insert($table, $row, $values)
    {
        $query = 'INSERT INTO ' . $table . '('.$row. ')' . 'VALUES ('.$values.')';
        return $query;
    }


    public function delete($table)
    {
        $query = 'DELETE FROM ' . $table . ' WHERE id = :id';
        return $query;
    }
}
