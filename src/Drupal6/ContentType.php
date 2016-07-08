<?php
namespace Fmizzell\Auditing\Drupal6;
use Fmizzell\Auditing\ContentType as Base;
class ContentType extends Base
{
    public function getContentTypes()
    {
        $query = \Database::getConnection('default', 'legacy')->select('node_type', 'n');
        $query->fields('n', array('type', 'name', 'description'));
        $results = $query->execute();
        $results = $results->fetchAllAssoc('type');
        return $results;
    }

    public function getContentTypeFieldInfo($content_type)
    {
        $fields_info = array();

        $query = \Database::getConnection('default', 'legacy')->select('content_node_field_instance', 'fi');
        $query->fields('fi', array('field_name', 'label', 'description'));
        $query->condition('fi.type_name', $content_type);
        $results = $query->execute();
        $field_instances_info = $results->fetchAllAssoc('field_name');

        foreach ($field_instances_info as $field_name => $instance_info) {
            $fields_info[$field_name]['label'] = $instance_info->label;

            $description = strip_tags($instance_info->description);
            $description = str_replace(array("\n","\r"), '', $description);
            $fields_info[$field_name]['description'] = $description;

            $query = \Database::getConnection('default', 'legacy')->select('content_node_field', 'f');
            $query->fields('f', array('type'));
            $query->condition('f.field_name', $field_name);
            $results = $query->execute();
            $fields_info[$field_name]['type'] = $results->fetchCol()[0];
        }
        return $fields_info;
    }
}