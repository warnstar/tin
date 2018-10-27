<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/26
 * Time: 23:52
 */
namespace app\common\asyncJob;


use app\common\asyncJob\jobs\MinaTplMsgJob;
use app\common\asyncJob\jobs\TestJob;
use app\common\base\ErrorTrait;
use Swoole\Client;

class AsyncJob
{
    use ErrorTrait;

    protected static $JobMaps = [
        TestJob::KEY => TestJob::class,
        MinaTplMsgJob::KEY => MinaTplMsgJob::class,
    ];

    /**
     * @var $job JobProcessInterface
     */
    private $job;

    /**
     * @param string $job
     * @param null $data
     * @return bool
     */
    public static function createJob(string $job, $data = null)
    {
        if (!isset(self::$JobMaps[$job])) {
            throw new \Exception("任务未注册：{$job}");
        }

        $jobData = [
            'job' => $job,
            'data' => $data
        ];

        $client = new Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $client->on("connect", function(Client $cli) use ($jobData) {
            $cli->send(json_encode($jobData, true));

            $cli->close();
        });
        $client->on("receive", function($cli, $data){
            echo "received: {$data}\n";
        });
        $client->on("error", function($cli) use ($jobData){
            echo "连接异步任务服务器失败\n";
        });
        $client->on("close", function($cli){

        });
        $client->connect(getenv("async.server"), getenv("async.port"), 0.5);

        return true;
    }

    /**
     * @param string $job
     * @return self
     */
    public function setJob(string $job)
    {
        $this->job = new $job();

        return $this;
    }

    public function execute(string $data)
    {
        $dataOrigin = json_decode($data, true);
        if ($dataOrigin) {
            if (!empty($dataOrigin['job'])) {
                if (empty(self::$JobMaps[$dataOrigin['job']])) {
                    $this->addError('not_found', sprintf("任务未注册: %s", $dataOrigin['job']));
                    return false;
                }

                if ($this->setJob(self::$JobMaps[$dataOrigin['job']])) {
                    $jobData = isset($dataOrigin['data']) ? $dataOrigin['data'] : null;

                    try {
                        $this->job->process($jobData);
                        echo sprintf("任务：%s -> 处理成功\n", $dataOrigin['job']);

                        return true;
                    } catch (JobFailException $e) {
                        $this->addError('FAIL', $e->getMessage());
                    }
                }
            } else {
                $this->addError('PARAM', '请设置正确任务格式');
            }
        } else {
            $this->addError('not_found', "异常数据格式：{$data}\n");
        }

        echo sprintf("任务：%s -> 处理失败{%s}\n", $dataOrigin['job'], $this->getErrorFirstString());

        return false;
    }
}