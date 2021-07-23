<?php

// LOCAL - MAMP
    // define('HOST'       , '127.0.0.1'       );
    // define('DBNAME'     , 'unbreakble_box'  );
    // define('USER'       , 'root'            );
    // define('PASSWORD'   , 'root'            );

// WEB - INITYFREE
    // define('HOST'       , 'sql200.epizy.com'        );
    // define('DBNAME'     , 'epiz_29215994_smashed'   );
    // define('USER'       , 'epiz_29215994'           );
    // define('PASSWORD'   , 'Hy55QIMDeEn'             );

// WEB - DB 4 FREE
    // define('HOST'       , 'db4free.net'    );
    // define('DBNAME'     , 'smashedboxdb'   );
    // define('USER'       , 'root_smashed'   );
    // define('PASSWORD'   , 'TAunrBApLYGLru4');

// WEB - HEROKU (smashed-box-beckend)
    define('HOST'       , 'us-cdbr-east-04.cleardb.com' );
    define('DBNAME'     , 'heroku_f8611d16df426e6'      );
    define('USER'       , 'bc5758a825e4d6'              );
    define('PASSWORD'   , 'aa7c67cc'                    );
 
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