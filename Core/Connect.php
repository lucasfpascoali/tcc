<?php

namespace Source\Core;

use \PDO;
use \PDOException;

/**
 * Connect Class, Singleton Pattern
 *
 */
class Connect
{
    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    private static PDO $instance;

    /**
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if(empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=". CONF_DB_HOST . ";dbname=". CONF_DB_NAME,
                    CONF_DB_USER,
                    CONF_DB_PASS,
                    self::OPTIONS
                );
            } catch (PDOException $exception) {
                die("<h1>Whoops! Erro ao Conectar...</h1>");
            }
        }

        return self::$instance;
    }

    /**
     * Connect Constructor
     */
    final public function __construct()
    {
    }

    /**
     * Connect clone
     */
    final public function __clone()
    {
    }

}