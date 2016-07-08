<?php
namespace Fmizzell\Auditing\Drupal6;
use Fmizzell\Auditing\Report;

class File extends Report
{
    public function generateReport()
    {
        $query = \Database::getConnection('default', 'legacy')->select('files', 'f');
        $countQuery = $query->countQuery();
        $result = $countQuery->execute()->fetchCol();
        $number_of_files = $result[0];

        $title = "Files";
        $report = "# {$title}" . PHP_EOL;
        $this->addMenuItem($title);

        $report .= "| Number of Files |" . PHP_EOL;
        $report .= "|-----------------|" . PHP_EOL;
        $report .= "| {$number_of_files} |" . PHP_EOL . PHP_EOL;

        //select distinct filemime from files;
        $query = \Database::getConnection('default', 'legacy')->select('files', 'f');
        $query->fields('f', array('filemime'));
        $query->distinct();
        $results = $query->execute()->fetchCol();

        $report .= "| MIME Types | Number of Files |" . PHP_EOL;
        $report .= "|------------|-----------------|" . PHP_EOL;
        foreach ($results as $result) {
            // Number of files per mimetype.
            $query = \Database::getConnection('default', 'legacy')->select('files', 'f');
            $query->fields('f', array('filemime'));
            $query->condition('f.filemime', $result);
            $count = $query->countQuery();
            $num_files = $count->execute()->fetchCol()[0];

            $report .= "| {$result} | {$num_files} |" . PHP_EOL;
        }

        $this->saveReport("file", $report);
    }
}