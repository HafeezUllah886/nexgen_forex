<?php

use Carbon\Carbon;

function firstDateofCurrentMonth()
{
    $startOfMonth = Carbon::now()->startOfMonth();

    return $startOfMonth->format('Y-m-d');
}

function lastDateofCurrentMonth()
{
    $endOfMonth = Carbon::now()->endOfMonth();

    return $endOfMonth->format('Y-m-d');
}
