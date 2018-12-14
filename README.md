# Moeda PHP

Classe para formatação e cálculos de moedas em PHP.

## Exemplo de uso:

	<?php
	$moeda = new Moeda('R$ 1.234.567,89');
	$moeda->getBRL(true, 0);      // Retorna: R$ 1.234.568 (string)
	$moeda->getBRL(false, 0);     // Retorna: 1.234.568 (string)
	$moeda->getBRL(true, 2);      // Retorna: R$ 1.234.567,89 (string)
	$moeda->getEUR(true, 2);      // Retorna: 1 234 567.89 € (string)
	$moeda->getUSD(true, 2);      // Retorna: US$ 1,234,567.89 (string)
	$moeda->getFloat(1);          // Retorna: 1234567.9 (float)
