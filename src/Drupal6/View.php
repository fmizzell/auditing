<?php
namespace Fmizzell\Auditing\Drupal6;
use Fmizzell\Auditing\Report;

class View extends Report
{
    public function generateReport() {
        $query = \Database::getConnection('default', 'legacy')->select('views_view', 'v');
        $query->fields('v', array('name', 'description'));
        $results = $query->execute();

        $title = "Views";
        $report = "# {$title}" . PHP_EOL;
        $this->addMenuItem($title);

        $report .= "| Name | Description |" . PHP_EOL;
        $report .= "|------|-------------|" . PHP_EOL;

        foreach ($results as $result) {
            $report .= "| {$result->name} | {$result->description} |" . PHP_EOL;
        }

        $this->saveReport("view", $report);
    }
}