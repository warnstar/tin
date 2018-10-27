<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/24
 * Time: 23:23
 */
namespace console\actions;

use app\common\asyncJob\AsyncJob;
use app\common\asyncJob\jobs\TestJob;
use Swoole\Client;
use Swoole\Server;
use Tin\ConsoleActionInterface;

class Async implements ConsoleActionInterface
{
    public function run($args)
    {
        $action = !empty($args[0]) ? $args[0] : null;
        switch ($action)
        {
            case 'start' :
                $this->start();
                break;
            case 'stop' :
                $this->stop();
                break;
            case 'test':
                $this->test();
                break;
            default:
                echo "请输入操作选项 {start | test }\n";
        }
    }

    protected function start()
    {
        $server = new Server("0.0.0.0", 9502);
        $server->set(array('task_worker_num' => 4));
        $server->on('receive', function(Server $server, $fd, $reactor_id, $data) {
            $task_id = $server->task($data);
        });

        $server->on('task', function (Server $server, $task_id, $reactor_id, $data) {
            $asyncJob = new AsyncJob();
            if ($asyncJob->execute($data)) {
            } else {
                dump($asyncJob->getErrors());
            }

            $server->finish("");
        });

        $server->on('finish', function ($server, $task_id, $data) {

        });

        $server->start();
    }

    public function test()
    {
        $client = new Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $client->on("connect", function(Client $cli) {

            $job = [
                'job' => TestJob::KEY,
                'data' => "testJob"
            ];

            $cli->send(json_encode($job, true));

            $cli->close();
        });
        $client->on("receive", function($cli, $data){
            echo "received: {$data}\n";
        });
        $client->on("error", function($cli){
            echo "connect failed\n";
        });
        $client->on("close", function($cli){
            echo "connection close\n";
        });
        $client->connect("127.0.0.1", 9502, 0.5);
    }

    public function stop()
    {

    }
}