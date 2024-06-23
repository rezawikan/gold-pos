<?php

function currencyFormatterIDR($amount): false|string
{
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
    $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);

    return $formatter->formatCurrency($amount, 'IDR');
}
