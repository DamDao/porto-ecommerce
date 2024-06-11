<?php
function percent($sale, $price)
{
    $percent = (1 - $sale / $price) * 100;
    return number_format($percent, 1);
}
