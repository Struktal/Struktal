<?php

/**
 * Output Data on a Website
 * @param $data mixed Data that should be displayed
 * @return void
 */
function output(mixed $data): void {
    echo htmlspecialchars($data);
}
