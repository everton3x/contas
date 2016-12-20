<?php

/*
 * Carrega libs
 */
require 'lib/functions.php';

/*
 * Carrega data sources
 */
require 'ds/receita.php';

/*
 * Define handler para disparar erros como exceções
 */
set_error_handler("exception_error_handler");

/*
 * Carrega configurações
 */
$config = parse_ini_file('config.ini', true);

/*
 * Conecta ao banco de dados
 */
$db = new PDO($config['db']['dsn']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
