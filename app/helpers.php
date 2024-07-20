<?php

/**
 * Format a number as currency in Indonesian Rupiah using NumberFormatter
 *
 * @param  float  $amount  The number to format as currency
 * @return false|string The formatted currency as a string, or false on failure
 */
function currencyFormatterIDR($amount): false|string
{
    $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
    $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);

    return $formatter->formatCurrency($amount, 'IDR');
}

/**
 * Format a number using NumberFormatter
 *
 * @param  float  $amount  The number to format
 * @return false|string The formatted number as a string, or false on failure
 */
function numberFormatter($amount): false|string
{
    $formatter = new NumberFormatter('id_ID', NumberFormatter::DEFAULT_STYLE);
    $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 0);

    return $formatter->format($amount);
}
