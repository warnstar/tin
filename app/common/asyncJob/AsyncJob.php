<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2018/10/26
 * Time: 23:52
 */
namespace app\common\asyncJob;


use app\common\asyncJob\jobs\TestJob;
use app\common\base\ErrorTrait;

class AsyncJob
{
    use ErrorTrait;

    protected static $JobMaps = [
        TestJob::KEY => TestJob::class
    ];

    /**
     * @var $job JobProcessInterface
     */
    private $job;


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


        return false;
    }
}