<?php
namespace Fmizzell\Auditing;
class Report
{
    private $menu = "";
    private $includes = "";

    protected function createDirectory($path) {
        if (!file_exists($path)) {
            mkdir($path);
        }
    }

    protected function reportsDirectory() {
        // Create a folder to save the reports.
        $public_files_path = drupal_realpath(file_default_scheme() . '://');
        $reports_directory = $public_files_path . "/auditing";

        $this->createDirectory($reports_directory);

        return $reports_directory;
    }

    protected function saveReport($filename, $data, $subdir = NULL) {
        $reports_directory = $this->reportsDirectory();

        if ($subdir) {
            $reports_directory .= "/{$subdir}";
            $this->createDirectory($reports_directory);
        }

        // Save the report to a file.
        file_put_contents($reports_directory . "/{$filename}.md", $data);

        $this->addFile($filename, $subdir);
    }

    protected function addMenuItem($title, $position = 0) {
        $link = str_replace(" ", "-", strtolower($title));
        $this->menu .= $this->getTabs($position)."* [{$title}](#{$link})" . PHP_EOL;
    }

    private function getTabs($number_of_tabs) {
        $tabs = "";
        for ($i = 0; $i < $number_of_tabs; $i++) {
           $tabs .= "\t";
        }
        return $tabs;
    }

    public function getMenu() {
        return $this->menu;
    }

    private function addFile($filename, $subdir = NULL) {
        $dir = ($subdir) ? "{$subdir}/" : "";
        $include = "{% include \"./" . $dir . "{$filename}.md\" %}" . PHP_EOL;
        $this->includes .= $include;
    }

    public function getFilesInclude() {
        return $this->includes;
    }
}