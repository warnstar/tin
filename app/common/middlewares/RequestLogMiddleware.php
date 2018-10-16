<?php
/**
 * This file is part of Tin.
 */
namespace app\common\middlewares;

use Tin\Http\Request;
use Tin\Middleware\Middleware;
use app\Utils;

class RequestLogMiddleware extends Middleware
{
    public function handle(Request $request)
    {

        // 打印命令行
        printConsole(
            sprintf(
                '%s Fd=%s %s %s %s',
                date('Y-m-d H:i:s'),
                $request->getFd(),
                $request->getMethod(),
                $request->getUri()->getPath(),
                $request->response->getStatusCode()
            )
        );

        // 日志输出到文件
        $log = [
            'user' => [
                'user_id' => $request->user->id
            ],
            'request' => [
                'method' => $request->getMethod(),
                'path' => $request->getUri()->getPath(),
                'query' => $request->getUri()->getQuery(),
                'headers' => $request->getHeaders(),
                'queryParams' => $request->getQueryParams(),
                'bodyParams' => $request->getParsedBody()
            ]
        ];

        Utils::file_put_contents(APP_PATH . '/runtime/request/' . date('Y-m-d') . '.log', json_encode($log, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n\n", FILE_APPEND);

        yield $request;

    }
}
