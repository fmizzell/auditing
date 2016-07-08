<?php
namespace Fmizzell\Auditing;

abstract class Node extends Report
{
    abstract public function getContentTypes();

    abstract public function getNumberOfNodes($content_type);

    public function generateReport()
    {
        $contentTypes = $this->getContentTypes();

        $title = "Content";
        $this->addMenuItem($title);

        $report = "# {$title}" . PHP_EOL;

        $report .= "| Content Type | Machine Name | Number of Nodes |" . PHP_EOL;
        $report .= "|--------------|--------------|-----------------|" . PHP_EOL;

        foreach ($contentTypes as $contentTypeName => $info) {
            $numberOfNodes = $this->getNumberOfNodes($contentTypeName);
            $report .= "| {$info->name} | {$contentTypeName} | {$numberOfNodes} |" . PHP_EOL;
        }

        // Save the report to a file.
        $this->saveReport('node_count', $report);
    }

}