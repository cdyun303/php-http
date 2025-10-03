<?php
/**
 * @desc HttpEnforcer.php
 * @author cdyun(121625706@qq.com)
 * @date 2025/9/23 21:53
 */
declare(strict_types=1);

namespace Cdyun\PhpHttp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use support\Log;

class HttpEnforcer
{
    /**
     * HTTP 客户端实例
     */
    private static $instance;

    /**
     * 获取 HTTP 客户端实例
     * @return Client
     */
    private static function handler(): Client
    {
        if (!self::$instance) {
            self::$instance = new Client();
        }
        return self::$instance;
    }

    /**
     * @param string $method - 请求方法 (GET, POST, PUT, DELETE 等)
     * @param string $url - 请求的 URL
     * @param array $options - 请求选项 (headers, body, query, json,form_params 等)
     * GET传参用query，POST传参用json，PUT传参用form_params
     * @return array 返回响应数据
     * @author cdyun(121625706@qq.com)
     * @desc HTTP 请求
     */
    public static function request(string $method, string $url, array $options = []): array
    {
        try {
            $response = self::handler()->request($method, $url, $options);
            if ($response->getStatusCode() != 200) {
                throw new \RuntimeException('cURL响应状态码错误：' . $response->getStatusCode());
            }
            return [
                'statusCode' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
                'headers' => $response->getHeaders(),
            ];
        } catch (GuzzleException $e) {
            Log::error("cURL请求失败:", [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \RuntimeException('cURL请求失败'.$e->getMessage());
        }
    }
}