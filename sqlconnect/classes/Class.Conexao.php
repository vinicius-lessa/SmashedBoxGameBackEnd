<?php

// VERSÃO LOCAL

// define('HOST'       , '127.0.0.1'       );
// define('DBNAME'     , 'unbreakble_box'  );
// define('USER'       , 'root'            );
// define('PASSWORD'   , 'root'            );

define('HOST'       , 'sql200.epizy.com'        );
define('DBNAME'     , 'epiz_29215994_smashed'   );
define('USER'       , 'epiz_29215994'           );
define('PASSWORD'   , 'Hy55QIMDeEn'             );
 
class Conexao
{
    private static $pdo;
 
    private function __construct(){}
 
    public static function getConexao()
    {
        if (!isset(self::$pdo)) {
            $opt = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8' ];
            self::$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASSWORD,$opt);
        }
        return self::$pdo;
    }
}