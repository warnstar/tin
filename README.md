# tin
### 路由配置
配置文件：app/boot.php
```php
\Tin\Base\Router::get('/users', \app\controllers\IndexController::class . '@index');
\Tin\Base\Router::get('/index/{id:\d+}', \app\controllers\IndexController::class . '@index');
\Tin\Base\Router::post('/users', \app\controllers\IndexController::class . '@create');

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