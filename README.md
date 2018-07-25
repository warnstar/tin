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
php public/index.php
```

### 路由配置
> 任意文件内配置路由对象，然后注入到application中启动
```php
$r = new \Tin\Base\Router();
$r->get('/users', \app\controllers\IndexController::class . '@index');
$r->get('/index/{id:\d+}', \app\controllers\IndexController::class . '@index');

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