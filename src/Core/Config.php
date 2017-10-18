<?php

namespace Core;

class Config
{
    protected $config;

    public static function parse($path)
    {
        if (!$path) {
            throw new \Exception('Config not provided');
        }

        if (!is_file($path)) {
            throw new \Exception('Config file not found');
        }

        $config = parse_ini_file($path, true);

        if (!$config || !count($config)) {
            throw new \Exception('Invalid config file');
        }

        return new self($config);
    }

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) === 'get') {
            $key = strtolower(preg_replace('/\B([A-Z])/', '_$1', substr($name, 3)));
            if (isset($this->config[$key])) {
                $value = $this->config[$key];

                if (is_array($value)) {
                    return new self($this->config[$key]);
                }

                return $value;
            }
        }
    }
}