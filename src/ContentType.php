<?php
namespace Fmizzell\Auditing;
abstract class ContentType extends Report
{

    abstract public function getContentTypes();

    abstract public function getContentTypeFieldInfo($content_type);

    public function generateReport()
    {


        $count = 0;
        $contentTypes = $this->getContentTypes();
        foreach ($contentTypes as $contentTypeName => $info) {

            if ($count == 0) {
                $title = "Content Types";
                $report = "# {$title}" . PHP_EOL;
                $this->addMenuItem($title);
            }
            $count++;

            $report .= "## {$info->name}" . PHP_EOL;

            //$this->addMenuItem($info->name, 1);

            $report .= "{$info->description}" . PHP_EOL;
            $report .= "### Field Information" . PHP_EOL;
            $report .= "| Field Name | Machine Name | Type |" . PHP_EOL;
            $report .= "|------------|--------------|------|" . PHP_EOL;

            $fields_info = $this->getContentTypeFieldInfo($contentTypeName);

            foreach ($fields_info as $field_name => $info) {
                $name = $field_name;
                $label = $info['label'];
                $notes = $info['description'];
                $type = $info['type'];

                $report .= "| {$label} | {$name} | {$type} |" . PHP_EOL;
            }

            $this->saveReport($contentTypeName, $report, 'content_type');
        }
    }
}