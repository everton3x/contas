<?php

/**
 * Função para transformar mensagens de erro em ErrorException. Veja {@see http://php.net/manual/pt_BR/class.errorexception.php ErrorException}
 * @param int $severity
 * @param string $message
 * @param string $file
 * @param int $line
 * @return void
 * @throws ErrorException
 */
function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}

/**
 * Formata o mês de AAAAMM para MM/AAAA
 * @param int $mes AAAAMM
 * @return string MM/AAAA
 */
function formata_mes(int $mes) : string {
    
    if(strlen($mes) === 6){
        $ano = substr($mes, 0, 4);
        $mes = substr($mes, 4, 2);
    }else{
        throw new UnexpectedValueException("Mẽs $mes de tamanho inválido!");
    }
    return "$mes/$ano";
}

function formata_mes_para_input(int $mes) : string {
    
    if(strlen($mes) === 6){
        $ano = substr($mes, 0, 4);
        $mes = substr($mes, 4, 2);
    }else{
        throw new UnexpectedValueException("Mẽs $mes de tamanho inválido!");
    }
    return "$ano-$mes";
}

/**
 * Formata datas de AAAA-MM-DD para DD/MM/AAAA
 * @param string $data AAAA-MM-DD
 * @return string DD/MM/AAAA
 * @throws UnexpectedValueException
 */
function formata_data(string $data) : string {
//    echo $data;
    if(strlen($data) === 10){
        $ano = substr($data, 0, 4);
        $mes = substr($data, 5, 2);
        $dia = substr($data, 8, 2);

        return "$dia/$mes/$ano";
    }else{
        throw new UnexpectedValueException("Data $data de tamanho inválido!");
    }
}

/**
 * Formata números.
 * 
 * @param number $numero 99999.00000
 * @return string 9.999,00
 */
function formata_numero($numero) : string {
    return number_format($numero, 2, ',', '.');
}

function desformata_mes(string $mes) : int {
    return (int) str_replace('-', '', $mes);
}

function mes_anterior(int $mes) : int {
    if(strlen($mes) === 6){
        $ano = substr($mes, 0, 4);
        $mes = substr($mes, 4, 2);
        
        $date = date_create("$ano-$mes-01");
        date_sub($date, date_interval_create_from_date_string('1 month'));
        return (int) date_format($date, 'Ym');
    }else{
        throw new UnexpectedValueException("Mẽs $mes de tamanho inválido!");
    }
}

function mes_seguinte(int $mes) : int {
    if(strlen($mes) === 6){
        $ano = substr($mes, 0, 4);
        $mes = substr($mes, 4, 2);
        
        $date = date_create("$ano-$mes-01");
        date_add($date, date_interval_create_from_date_string('1 month'));
        return (int) date_format($date, 'Ym');
    }else{
        throw new UnexpectedValueException("Mẽs $mes de tamanho inválido!");
    }
}