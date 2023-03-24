#!/usr/bin/php
<?php
require_once 'DittoClass.php';

// Define the command-line arguments
$options = getopt("f:y:h");

// If the -h flag is present, display the usage information and exit
if (isset($options['h'])) {
    echo<<<HELP
Usage:
   php utility.php
   OR
   php utility.php -f fileName.csv
   OR
   php utility.php -f fileName.csv -y year
   OR
   php utility.php -h

Options:
   -f    Input CSV file name
   -y    Year for calculating bonus and salary dates
   -h    Display this usage information
HELP;
    exit(0);
}

// If the -f flag is not present, exit with an error
if (!isset($options['f'])) {
    echo "Error: You must specify an input file with the -f option.\n";
    exit(1);
}

// Get the input file name
$fileName = strtolower($options['f']);

// Get the year (if specified)
$year = null;
if (isset($options['y'])) {
    $year = $options['y'];
    if (!is_numeric($year)) {
        echo "Error: Year must be a number.\n";
        exit(1);
    }
}

// Create a new instance of the DittoClass
$ditto = new DittoClass($fileName, $year);

// Calculate the bonus date, salary date, and CSV output
$ditto->findBonusDate();
$ditto->findSalaryDate();
$ditto->csvOutput();