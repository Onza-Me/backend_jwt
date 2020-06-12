<?php

namespace OnzaMe\JWT\Console;

class PackageCommandsHandler
{
    /**
     * @param string $dir
     * @param string $namespace
     * @return string[]
     */
    public function getCommands(string $dir = '', string $namespace = 'OnzaMe\JWT\Console\Commands\\'): array
    {
        $dir = empty($dir) ? __DIR__.'/Commands' : $dir;
        return array_map(
            fn ($v) => $namespace.str_replace('.php', '', $v),
            array_filter(scandir($dir), fn ($v) => preg_match('/\.php$/', $v))
        );
    }
}
