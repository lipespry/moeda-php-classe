<?php

namespace LSIApp\Modelos;

/**
 * Classe Moeda
 * @author Felipe "LipESprY" Moraes <felipemdeoliveira@live.com>
 */

class Moeda
{
    protected $valor;

    public function __construct($val = null)
    {
        if (isset($val))
            return $this->setVal($val);
        return true;
    }

    public function setVal($val)
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
            // Descomente aqui caso queira lançar exceção:
            /*throw new \Exception(
                'Moeda em formato inválido ou desconhecido.'
            );*/
            return false;
        }
        return true;
    }

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

    public function getBRL($simbolo = null, $casasDecimais = 2)
    {
        if (!isset($this->valor))
            return false;
        else
            return (
                (isset($simbolo) && $simbolo) ? 'R$ ':''
            ).number_format($this->valor, $casasDecimais, ',', '.');
    }

    public function getUSD($simbolo = null, $casasDecimais = 2)
    {
        if (!isset($this->valor))
            return false;
        else
            return (
                (isset($simbolo) && $simbolo) ? 'US$ ':''
            ).number_format($this->valor, $casasDecimais, '.', ',');
    }

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
