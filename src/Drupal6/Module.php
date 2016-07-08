<?php
namespace Fmizzell\Auditing\Drupal6;
use Fmizzell\Auditing\Report;

class Module extends Report
{
    public function generateReport()
    {
        $query = \Database::getConnection('default', 'legacy')->select('system', 's');
        $query->fields('s', array('name', 'info'));
        $query->condition('s.type', 'module');
        $query->condition('s.status', 1);
        $query->orderBy('s.name', 'ASC');
        $results = $query->execute();

        $title = "Enabled Modules";
        $report = "# {$title}" . PHP_EOL;
        $this->addMenuItem($title);

        $report .= "| Modules | Package | Version |" . PHP_EOL;
        $report .= "|---------|---------|---------|" . PHP_EOL;

        foreach ($results as $result) {
            $info = unserialize($result->info);
            $package = (isset($info['package'])) ? $info['package'] : "";
            if (substr_count($package, 'Core - required') == 0) {
                $report .= "| {$result->name} | {$info['package']} | {$info['version']} |" . PHP_EOL;
            }
        }

        $this->saveReport("module", $report);
    }
}