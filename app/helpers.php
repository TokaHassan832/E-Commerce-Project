<?php

function presentPrice($price) {
    return sprintf('$%.2f', $price / 100);
}
