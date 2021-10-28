<?php
namespace OnzaMe\JWT\Services;

use OnzaMe\JWT\Services\Contracts\FileSaver;

/**
 *
 */
class FileSaverService implements FileSaver
{
    protected bool $forceSave;
    protected bool $withBackup;

    public function __construct(bool $withBackup = false, bool $forceSave = false)
    {
        $this->forceSave = $forceSave;
        $this->withBackup = $withBackup;
    }

    public function save(string $filepath, $content): void
    {
        if (!$this->forceSave && file_exists($filepath)) {
            return;
        }
        if ($this->withBackup) {
            $this->createBackup($filepath);
        }
        $this->putToFile($filepath, $content);
    }

    public function createBackup(string $filepath): void
    {
        $oldContent = file_get_contents($filepath);
        $backupFilepath = $filepath.'.'.time().'.bak';

        $this->putToFile($backupFilepath, $oldContent);
    }

    protected function putToFile(string $filepath, $content)
    {
        file_put_contents($filepath, $content);
    }
}
