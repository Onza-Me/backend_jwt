<?php
namespace OnzaMe\JWT\Console\Commands;

use Illuminate\Console\Command;
use phpseclib\Crypt\RSA;

class JwtRsaGenerateCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $signature = 'jwt:rsa:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate RSA keys for JWT RS256";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createRsaFiles(config('jwt.rsa'));
    }

    protected function createRsaFiles(array $configs)
    {
        $path = $configs['path'];
        $keySize = $configs['key_size'];

        if (empty($path)) {
            throw new Exception('Please enter path for keys');
        } elseif (!file_exists($path)) {
            mkdir($path, '0664', true);
        }

        $rsa = new RSA();

        /**
         * Extracting variables
         *
         * @var $privatekey
         * @var $publickey
         */
        extract($rsa->createKey($keySize));

        $this->safetySaveContent($path.'/'.$configs['private_filename'], $privatekey);
        $this->safetySaveContent($path.'/'.$configs['public_filename'], $publickey);
    }

    protected function safetySaveContent($filepath, $content)
    {
        $this->createBackupFile($filepath);
        $this->putToFile($filepath, $content);
    }

    protected function createBackupFile($filepath, $postfix = null)
    {
        if (file_exists($filepath)) {
            $oldContent = file_get_contents($filepath);
            $this->putToFile($filepath.'.'.(empty($postfix) ? time() : $postfix).'.bak', $oldContent);
        }
    }

    protected function putToFile($filepath, $content)
    {
        file_put_contents($filepath, $content);
    }
}
