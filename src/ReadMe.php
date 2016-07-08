<?php
namespace Fmizzell\Auditing;

class ReadMe extends Report
{
    private $reporters;

    public function __construct(array $reporters)
    {
        $this->reporters = $reporters;
    }

    public function generateReport() {
        $toc = "";
        $files = "";

        foreach ($this->reporters as $reporter) {
            $toc .= $reporter->getMenu();
            $files .= $reporter->getFilesInclude();
        }

        $data = $toc . PHP_EOL . $files;
        $this->saveReport("README", $data);
    }

}