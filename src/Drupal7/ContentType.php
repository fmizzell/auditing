<?php
namespace Fmizzell\Auditing\Drupal7;
use Fmizzell\Auditing\ContentType as Base;
class ContentType extends Base
{
    public function getContentTypes()
    {
        return node_type_get_types();
    }

    public function getContentTypeFieldInfo($content_type)
    {
        $fields_info = array();

        $field_instances_info = field_info_instances('node', $content_type);
        foreach ($field_instances_info as $field_name => $instance_info) {
            $field_info = field_info_field($field_name);
            $fields_info[$field_name]['label'] = $instance_info['label'];
            $fields_info[$field_name]['description'] = $instance_info['description'];
            $fields_info[$field_name]['type'] = $field_info['type'];
        }
        return $fields_info;
    }
}