<?php

namespace ButterCMS\Model;

class Page extends Model
{
    protected $slug;
    protected $page_type;
    protected $fields;

    public function getField($key, $default = null)
    {
        if (is_null($key)) {
            return null;
        }
        if (isset($this->fields[$key])) {
            return $this->fields[$key];
        }

        $array = $this->fields;

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return value($default);
            }
            $array = $array[$segment];
        }
        return $array;
    }

    public function resizeField($key, $params = null)
    {
        $path = $this->getField($key);
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
