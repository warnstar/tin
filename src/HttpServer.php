<?php
/**
 * This file is part of Tin.
 */

namespace Tin;

use Swoole\Server;
use Tin\Exception\ExitException;
use Tin\Http\Request;

class HttpServer
{
    private function __construct($config = [])
    {
    }

    public static function build($config = [])
    {
        return new self($config);
    }

    /**
     * @var $swServer Server
     */
    private $swServer;

    public $host = '0.0.0.0';

    public $port = '80';

    public $worker_num = 4;

    public $daemmonize = false;

    public $document_root = '../public';

    public function reload()
    {
        $this->swServer->reload();
    }

    public function run()
    {
        $http = new \Swoole\Http\Server($this->host, $this->port);

        // 设置全局swoole server变量
        $this->swServer = &$http;

        $http->set([
            'worker_num' => $this->worker_num,
            'daemonize' => $this->daemmonize,
            'backlog' => 128,
            'enable_static_handler' => true,
            'document_root' => $this->document_root
        ]);

        $http->on('start', function ($server) {
            echo "Tin已启动http服务器，监听80端口\n";

            // 开启热加载
            if (getenv('RUN_ENV') == 'DEV') {
                Watcher::run([
                    APP_ROOT . '/Tin',
                    APP_ROOT . '/app'
                ]);
            }
        });

        $http->on('ManagerStart', function (\Swoole\Http\Server $server) {
            echo 'ManagerStart: ' . PHP_EOL . PHP_EOL;
        });

        $http->on('WorkerStart', function (\Swoole\Http\Server $server, int $workerId) {
            // 通过重新加载外部文件来重载代码和释放之前占用的内存
        });

        $http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
            try {
                Tin::$app->router->execute(Request::createFromSwoole($request, $response));
            } catch (ExitException $e) {
            }
        });

        $http->on('WorkerError', function (\Swoole\Http\Server $serv, int $worker_id, int $worker_pid, int $exit_code, int $signal) {
            dump(func_get_args());
        });

        $http->start();
    }
}
