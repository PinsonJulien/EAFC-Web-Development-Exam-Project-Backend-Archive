<?php

namespace App\Traits;

trait CSVUtils
{
    /**
     * Format a given value to the CSV standard.
     * double quotes should be doubled.
     * strings containing commas should be quoted.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function formatForCSV(mixed $value) : mixed
    {
        // Double the double quotes.
        if (str_contains($value, '"'))
            $value = str_replace('"', '""', $value);

        // Quote the values containing commas.
        if (str_contains($value, ','))
            $value = '"'.$value.'"';

        return $value;
    }
}
