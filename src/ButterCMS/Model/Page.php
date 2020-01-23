<?php

namespace ButterCMS\Model;

class Page extends Model
{
    protected $slug;
    protected $page_type;
    protected $fields;

    public function getField($fieldName, $default = null)
    {
        return isset($this->fields[$fieldName]) ? $this->fields[$fieldName] : $default;
    }

    public function resizeField($fieldName, $params = null)
    {
        $path = $this->fields[$fieldName];
        if ($params) {
            $t = explode('/', $path);
            $filename = $t[count($t) - 1];
            $path = str_ireplace('cdn.buttercms.com', 'fs.buttercms.com', $path);
            $commands = $this->resizeCommands($params);
            $path = str_ireplace($filename, $commands, $path);
            $path .= "/$filename";
        }
        return $path;
    }

    private function resizeCommands(array $params)
    {
        $cntr = 0;
        $response = 'resize=';
        foreach ($params as $key => $value) {
            if ($cntr > 0) {
                $response .= ',';
            }
            $response .= "$key:$value";
            $cntr++;
        }
        return $response;
    }
}
