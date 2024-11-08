<?php

namespace App\Core;

use App\Exceptions\Exception;

class Core {
    private string $app_name;
    private string $app_version;
    private bool $app_debug;
    private string $app_status;

    public function __construct()
    {
        $this->set_app_name();
        $this->set_app_version();
        $this->app_debug = boolval(env('APP_DEBUG'));
        $this->app_status = 'Running';
    }

    public function get_app_version()
    {
        return $this->app_version;
    }
    
    public function get_app_name()
    {
        return $this->app_name;
    }
    
    public function get_app_debug()
    {
        return $this->app_debug;
    }
    
    public function get_app_status()
    {
        return $this->app_status;
    }

    private function set_app_version()
    {
        $this->app_version = $this->get_from_version_file('version');
    }
    
    private function set_app_name()
    {
        $this->app_name = $this->get_from_version_file('name');
    }

    private function get_from_version_file(string $field)
    {
        $path =  __DIR__ . '/../../appversion.json';
        if(!file_exists($path))
            throw new Exception('App Version file missing', 500, [ 'The app version file was not found in ' . $path ]);

        $content = file_get_contents($path);
        
        return json_decode($content, true)[$field];
    }
}