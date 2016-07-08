<?php
namespace Fmizzell\Auditing\Drupal7;
use Fmizzell\Auditing\Node as Base;
class Node extends Base
{

    public function getContentTypes()
    {
        return ContentType::getContentTypes();
    }

    public function getNumberOfNodes($content_type)
    {
        $query = db_select('node', 'n');
        $query->condition('n.type', $content_type);
        $countQuery = $query->countQuery();
        $result = $countQuery->execute()->fetchCol();
        return $result[0];
    }

}
