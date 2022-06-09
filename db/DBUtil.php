<?php
require_once('DBConn.php');

class DBUtil {

    //INSERT , UPDATE , DELETE
    public static function executeUpdate($conn, $sql, ...$params): ?bool {
        try {
            $pstm = $conn->prepare($sql);
            return $pstm->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    //SELECT
    public static function executeQuery($conn, $sql, ...$params): ?array{
        try {
            $pstm = $conn->prepare($sql);
            $pstm->execute($params);
            return $pstm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function getConnection() {
        try{
            return (new DBConn())->getConnection();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
