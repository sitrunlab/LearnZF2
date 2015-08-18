<?php
/**
 * Generate report
 * adopted and modified version from http://stackoverflow.com/questions/28120280/how-to-generate-php-code-coverage-reports-from-xdebug-output
 */
require_once 'vendor/autoload.php';

use SebastianBergmann\FinderFacade\FinderFacade;

$finder = new FinderFacade(
    array('build/coverage'),
    array(),
    array('*.cov')
);

foreach ($finder->findFiles() as $key => $filename) {
    if (isset($codeCoverage)) {
        $_coverage = include($filename);
        $codeCoverage->filter()->addFilesToWhitelist($_coverage->filter()->getWhitelist());
        $codeCoverage->merge($_coverage);
        unset($_coverage);
    } else {
        $codeCoverage = include($filename);
    }
}

print "\nGenerating code coverage report in Clover format ...";
$writer = new PHP_CodeCoverage_Report_Clover();
$writer->process($codeCoverage, 'build/logs/clover.xml');
print "Generating code coverage report in Clover format done\n";
