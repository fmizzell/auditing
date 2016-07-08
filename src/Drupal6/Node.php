<?php
namespace Fmizzell\Auditing\Drupal6;
use Fmizzell\Auditing\Node as Base;
class Node extends Base
{
    public function getContentTypes() {
        $content_type = new ContentType();
        return $content_type->getContentTypes();
    }

    public function getNumberOfNodes($content_type) {
        $query = \Database::getConnection('default', 'legacy')->select('node', 'n');
        $query->condition('n.type', $content_type);
        $countQuery = $query->countQuery();
        $result = $countQuery->execute()->fetchCol();
        return $result[0];
    }

    public function generateReport() {
        parent::generateReport();

        $counter = 0;
        foreach ($this->getContentTypes() as $contentTypeName => $info) {
            // Generate a nodes table
            $report = "";

            if ($counter == 0) {
                $title = "Nodes";
                $this->addMenuItem($title);
                $report = "# {$title}" . PHP_EOL;
            }
            $counter++;

            $report .= "## {$contentTypeName}" . PHP_EOL;
            $report .= "| Title | URL |" . PHP_EOL;
            $report .= "|-------|-----|" . PHP_EOL;

            $query = \Database::getConnection('default', 'legacy')->select('node', 'n');
            $query->fields('n', array('nid', 'title'));
            $query->condition('n.type', $contentTypeName);
            $results = $query->execute();

            foreach ($results as $result) {
                $canonical_url = "node/{$result->nid}";

                // Get the alias for the node.
                $query = \Database::getConnection('default', 'legacy')->select('url_alias', 'ua');
                $query->fields('ua', array('dst'));
                $query->condition('ua.src', $canonical_url);
                $alias = $query->execute()->fetchCol()[0];
                $report .= "| {$result->title} | {$alias} |" . PHP_EOL;
            }

            $this->saveReport($contentTypeName, $report, "node");
        }
    }

}
