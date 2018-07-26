<?php
/**
 * This file is part of Tin.
 */
namespace Tin;

class Watcher
{
    const DIRWATCHER_CHANGED = IN_MODIFY | IN_CLOSE_WRITE | IN_MOVE | IN_CREATE | IN_DELETE;

    public static function run($watcherDirs = [], $waitTime = 10)
    {
        $fd = inotify_init();

        if (count($watcherDirs) > 0) {
            foreach ($watcherDirs as $dir) {
                //递归监听目录
                self::addDirToWatch($dir, $fd);
            }
        }

        //加入到swoole的事件循环中
        swoole_event_add($fd, function ($fd) use ($waitTime) {
            $events = inotify_read($fd);
            if ($events) {
                foreach ($events as $k => $event) {
                    if (preg_match("/\.php$/i", $event['name']) && $k == 0) {
                        printConsole("{$event['name']}文件发生了改变, 准备重载swoole服务器!");
                        Application::swServer()->reload();
                        sleep($waitTime);
                    }
                }
            }
        });
    }

    /**
     * @param $dir
     * @param $fd
     * @return array
     */
    private static function addDirToWatch($dir, $fd)
    {
        if (is_dir($dir)) {
            inotify_add_watch($fd, $dir, self::DIRWATCHER_CHANGED);

            $files = [];
            $child_dirs = scandir($dir);
            foreach ($child_dirs as $child_dir) {
                //'.'和'..'是Linux系统中的当前目录和上一级目录，必须排除掉，
                //否则会进入死循环，报segmentation falt 错误
                if ($child_dir != '.' && $child_dir != '..') {
                    if (is_dir($dir.'/'.$child_dir)) {
                        $files[$child_dir] = self::addDirToWatch($dir.'/'.$child_dir, $fd);
                    }
                }
            }
            return $files;
        } else {
            return $dir;
        }
    }
}
