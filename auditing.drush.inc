<?php

/**
 * Implements hook_drush_command().
 */
function auditing_drush_command(){
    $items['auditing'] = array(
        'description' => "Generate all the reports.",
        'arguments' => array(
            'drupal_version' => 'What version of Drupal are we auditing (ex. 6). Version 6 and 7 are supported.',
        ),
    );
    return $items;
}

function drush_auditing($drupal_version) {
    $namespace = "\\Fmizzell\\Auditing\\Drupal{$drupal_version}\\";

    $report_classes = array('Node', 'ContentType', 'File', 'User', 'View', 'Module');

    $reporters = [];

    foreach ($report_classes as $class_name) {
        $class = $namespace . $class_name;
        $reporter = new $class();
        $reporter->generateReport();
        $reporters[] = $reporter;
    }

    $readme = new \Fmizzell\Auditing\ReadMe($reporters);
    $readme->generateReport();
}
