<?php

/**
 * Classe Moeda
 *
 * Exemplo de uso:
 *
 * $moeda = new Moeda('R$ 1.234.567,89');
 * $moeda->getBRL(true, 0);      // Retorna: R$ 1.234.568 (string)
 * $moeda->getBRL(false, 0);     // Retorna: 1.234.568 (string)
 * $moeda->getBRL(true, 2);      // Retorna: R$ 1.234.567,89 (string)
 * $moeda->getEUR(true, 2);      // Retorna: 1 234 567.89 € (string)
 * $moeda->getUSD(true, 2);      // Retorna: US$ 1,234,567.89 (string)
 * $moeda->getFloat(1);          // Retorna: 1234567.9 (float)
 *
 * @author Felipe "LipESprY" Moraes <felipemdeoliveira@live.com>
 * @see https://github.com/lipespry/moeda-php-classe
 */

class Moeda
{
    protected $valor;

    /**
     * Construtor
     *
     * @param string|integer|float $val O valor a ser tratado e
     * que pode ser omitido caso defina-o posteriormente com
     * o método setVal
     * @return bool|object
     */
    public function __construct($val = null)
    {
        if (isset($val))
            return $this->setVal($val);
        return true;
    }

    /**
     * Define o valor a ser tratado
     *
     * @param string|integer|float $val   O valor a ser tratado
     * @param bool                 $excep Lança exceção em
     * casos de valor em formato inválido ou em branco
     * @return bool
     *
     * @throws \Exception (opcional)
     */
    public function setVal($val, $excep = false)
    {
        $val = preg_replace('/[^\d\.\,]+/', '', $val);
        // Inteiro
        if (preg_match('/^\d+$/', $val)) {
            $this->valor = (float) $val;
        } else
        // Float
        if (preg_match('/^\d+\.{1}\d+$/', $val)) {
            $this->valor = (float) $val;
        } else
        // Vírgula como separador decimal
        if (preg_match('/^[\d\.]+\,{1}\d+$/', $val)) {
            $this->valor = (float) str_replace(
                ',',
                '.',
                str_replace('.', '', $val)
            );
        } else {        // Formato inválido ou em branco
            if($excep)
                throw new \Exception(
                    'Moeda em formato inválido ou desconhecido.'
                );
            return false;
        }
        return true;
    }

    /**
     * Retorna o valor calculável pelo PHP
     *
     * @param integer $casasDecimais Número de casas decimais
     * @return bool|float
     */
    public function getFloat($casasDecimais = null)
    {
        if (!isset($this->valor))
            return false;
        else {
            if (isset($casasDecimais))
                return (float) number_format(
                    $this->valor,
                    $casasDecimais,
                    '.',
                    ''
                );
            else
                return (float) $this->valor;
        }
    }

    /**
     * Retorna o valor formatado em moeda BRL (Real brasileiro)
     *
     * @param bool $simbolo       Mostra o símbolo R$ antes do valor
     * @param int  $casasDecimais Número de casas decimais
     */
    public function getBRL($simbolo = null, $casasDecimais = 2)
    {
        if (!isset($this->valor))
            return false;
        else
            return (
                (isset($simbolo) && $simbolo) ? 'R$ ':''
            ).number_format($this->valor, $casasDecimais, ',', '.');
    }

    /**
     * Retorna o valor formatado em moeda USD (Dólar americano)
     *
     * @param bool $simbolo       Mostra o símbolo US$ antes do valor
     * @param int  $casasDecimais Número de casas decimais
     */
    public function getUSD($simbolo = null, $casasDecimais = 2)
    {
        if (!isset($this->valor))
            return false;
        else
            return (
                (isset($simbolo) && $simbolo) ? 'US$ ':''
            ).number_format($this->valor, $casasDecimais, '.', ',');
    }

    /**
     * Retorna o valor formatado em moeda EUR (Euro)
     *
     * @param bool $simbolo       Mostra o símbolo € depois do valor
     * @param int  $casasDecimais Número de casas decimais
     */
    public function getEUR($simbolo = null, $casasDecimais = 2)
    {
        if (!isset($this->valor))
            return false;
        else
            return number_format(
                $this->valor,
                $casasDecimais,
                '.',
                ' '
            ).((isset($simbolo) && $simbolo) ? ' €':'');
    }

}
