<?php
namespace OnzaMe\JWT\Console\Commands;

use Illuminate\Console\Command;
use OnzaMe\JWT\Services\Contracts\JwtRsaGenerator;

class JwtRsaGenerateCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $signature = 'jwt:rsa:generate {--force}';

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
        app(JwtRsaGenerator::class)->generate();
    }
}
