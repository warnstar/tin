# tin

### 部署
#### 安装
```
git clone https://github.com/warnstar/tin.git
cd tin
composer install
```

#### 启动
```
<<<<<<< HEAD
php public/index.php
=======
require_once __DIR__ .  './vendor/autoload.php';

$r = new \Tin\Router();

$r->get('/', \app\admin\controllers\IndexController::class . '@index');

$components['router'] =  $r;
$components['server'] = \Tin\HttpServer::build();

(new \Tin($components))->run();
>>>>>>> f7ecb70773f36db2777b2e5f03b1504adfc77093
```

### 路由配置
> 任意文件内配置路由对象，然后注入到application中启动
```php

// 实例化路由处理器对象
$r = new \Tin\Base\Router();

// 设置全局中间件
$r->addMiddleware(\app\middleware\TestMiddleware::class);

// 路由内设置中间件
$r->get('/mid2', \app\controllers\IndexController::class . '@index')->addMiddleware(\app\middleware\AbcMiddleware::class);

// 设置路由
$r->get('/users', \app\controllers\IndexController::class . '@index');
$r->get('/index/{id:\d+}', \app\controllers\IndexController::class . '@index');

// 设置路由组
$r->group("/test", function(\Tin\Base\Router $r){
    $r->get('/mid', \app\controllers\TestController::class . '@mid');
});

```



## 请求处理
### 获取请求参数
> 在action控制器运行
#### 获取请求头
```php
$this->request->getHeaders();
$this->request->getHeader("key");
``` 

#### 获取请求参数
```php
// query
$this->request->getQueryParams();
$this->request->getQueryParam("key");

// form or json
$this->request->getParsedBodyParam("key" , "default");
$this->request->getParsedBody();
```