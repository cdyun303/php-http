php模拟http请求
=====

### 安装

```
composer require cdyun/php-http
```

### 例子

```PHP
use Cdyun\PhpHttp\HttpEnforcer;

// 请求
HttpEnforcer::request($method, $url, $options = []);

// 请求参数
$options
- headers, body, query, json,form_params 等
- GET传参用query，POST传参用json，PUT传参用form_params

```

