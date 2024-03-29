<?php

namespace App\Console\Commands;

use App\Classes\Socket\StatementSocket;
use Illuminate\Console\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class StatementServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socket:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start statement socket';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start statement socket');

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new StatementSocket()
                )
            ),
            8080
        );

        $server->run();
    }
}
