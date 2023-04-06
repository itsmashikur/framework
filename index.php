<?php
class Byte
{
    public $application;
    public function __construct()
    {
        spl_autoload_register(function () {
            $directories = ['system', 'controllers', 'routes', 'addons', 'config', 'models'];
            foreach ($directories as $directory) {
                $subDirectories = glob($directory . '/*', GLOB_ONLYDIR);
                $directories = array_merge(array($directory), $subDirectories);

                foreach ($directories as $dir) {
                    foreach (glob($dir . '/*.php') as $file) {
                        if (is_file($file)) {
                            require_once $file;
                        }
                    }
                }
            }
        });

        $this->application = new App();
    }
}

$byte = new Byte();