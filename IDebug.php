<?php

declare(strict_types=1);

/*
 * This file is part of the ************************ package.
 * _____________                           _______________
 *  ______/     \__  _____  ____  ______  / /_  _________
 *   ____/ __   / / / / _ \/ __`\/ / __ \/ __ \/ __ \___
 *    __/ / /  / /_/ /  __/ /  \  / /_/ / / / / /_/ /__
 *      \_\ \_/\____/\___/_/   / / .___/_/ /_/ .___/
 *         \_\                /_/_/         /_/
 *
 * The PHP Framework For Code Poem As Free As Wind. <Query Yet Simple>
 * (c) 2010-2019 http://queryphp.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leevel\Debug;

use Closure;
use DebugBar\DataCollector\DataCollectorInterface;
use DebugBar\DebugBar;
use DebugBar\HttpDriverInterface;
use DebugBar\JavascriptRenderer as BaseJavascriptRenderer;
use DebugBar\RequestIdGeneratorInterface;
use DebugBar\Storage\StorageInterface;
use Leevel\Di\IContainer;
use Leevel\Http\IRequest;
use Leevel\Http\IResponse;
use Throwable;

/**
 * IDebug 接口.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2019.05.28
 *
 * @version 1.0
 */
interface IDebug
{
    /**
     * 添加数据收集器.
     *
     * @param \DebugBar\DataCollector\DataCollectorInterface $collector
     *
     * @throws \DebugBar\DebugBarException
     *
     * @return \DebugBar\DebugBar
     */
    public function addCollector(DataCollectorInterface $collector): DebugBar;

    /**
     * 检查是否已添加数据收集器.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasCollector(string $name): bool;

    /**
     * 返回数据收集器.
     *
     * @param string $name
     *
     * @throws \DebugBar\DebugBarException
     *
     * @return \DebugBar\DataCollector\DataCollectorInterface
     */
    public function getCollector(string $name): DataCollectorInterface;

    /**
     * 返回所有数据收集器的数组.
     *
     * @return \DebugBar\DataCollector\DataCollectorInterface[]
     */
    public function getCollectors(): array;

    /**
     * 设置请求 ID 生成器.
     *
     * @param \DebugBar\RequestIdGeneratorInterface $generator
     *
     * @return \DebugBar\DebugBar
     */
    public function setRequestIdGenerator(RequestIdGeneratorInterface $generator): DebugBar;

    /**
     * 返回请求 ID 生成器.
     *
     * @return \DebugBar\RequestIdGeneratorInterface
     */
    public function getRequestIdGenerator(): RequestIdGeneratorInterface;

    /**
     * 返回当前请求的 ID.
     *
     * @return string
     */
    public function getCurrentRequestId(): string;

    /**
     * 设置用于存储收集数据的存储后端.
     *
     * @param null|\DebugBar\Storage\StorageInterface $storage
     *
     * @return \DebugBar\DebugBar
     */
    public function setStorage(?StorageInterface $storage = null): DebugBar;

    /**
     * 返回用于存储收集数据的存储后端.
     *
     * @return \DebugBar\Storage\StorageInterface
     */
    public function getStorage(): StorageInterface;

    /**
     * 检查是否保持数据.
     *
     * @return bool
     */
    public function isDataPersisted(): bool;

    /**
     * 设置 HTTP 驱动.
     *
     * @param \DebugBar\HttpDriverInterface $driver
     *
     * @return \DebugBar\DebugBar
     */
    public function setHttpDriver(HttpDriverInterface $driver): DebugBar;

    /**
     * 返回 HTTP 驱动.
     *
     * 如果没有定义 HTTP 驱动，则会自动创建 \DebugBar\PhpHttpDriver.
     *
     * @return \DebugBar\HttpDriverInterface
     */
    public function getHttpDriver(): HttpDriverInterface;

    /**
     * 从收集器收集数据.
     *
     * @return array
     */
    public function collect(): array;

    /**
     * 返回收集的数据.
     *
     * 如果尚未收集到数据，将收集数据.
     *
     * @return array
     */
    public function getData(): array;

    /**
     * 返回包含数据的 HTTP 头数组.
     *
     * @param string $headerName
     * @param int    $maxHeaderLength
     * @param int    $maxTotalHeaderLength
     *
     * @return array
     */
    public function getDataAsHeaders(string $headerName = 'phpdebugbar', int $maxHeaderLength = 4096, int $maxTotalHeaderLength = 250000): array;

    /**
     * 通过 HTTP 头数组发送数据.
     *
     * @param null|bool $useOpenHandler
     * @param string    $headerName
     * @param int       $maxHeaderLength
     *
     * @return \DebugBar\DebugBar
     */
    public function sendDataInHeaders(?bool $useOpenHandler = null, string $headerName = 'phpdebugbar', int $maxHeaderLength = 4096): DebugBar;

    /**
     * 将数据存在 session 中.
     *
     * @return \DebugBar\DebugBar
     */
    public function stackData(): DebugBar;

    /**
     * 检查 session 中是否存在数据.
     *
     * @return bool
     */
    public function hasStackedData(): bool;

    /**
     * 返回 session 中保存的数据.
     *
     * @param bool $delete
     *
     * @return array
     */
    public function getStackedData(bool $delete = true): array;

    /**
     * 设置 session 中保存数据的 key.
     *
     * @param string $ns
     *
     * @return \DebugBar\DebugBar
     */
    public function setStackDataSessionNamespace(string $ns): DebugBar;

    /**
     * 获取 session 中保存数据的 key.
     *
     * @return string
     */
    public function getStackDataSessionNamespace(): string;

    /**
     * 设置是否仅使用 session 来保存数据，即使已启用存储.
     *
     * @param bool $enabled
     *
     * @return \DebugBar\DebugBar
     */
    public function setStackAlwaysUseSessionStorage(bool $enabled = true): DebugBar;

    /**
     * 检查 session 是否始终用于保存数据，即使已启用存储.
     *
     * @return bool
     */
    public function isStackAlwaysUseSessionStorage(): bool;

    /**
     * 返回此实例的 \DebugBar\JavascriptRenderer.
     *
     * @param null|string $baseUrl
     * @param null|string $basePath
     *
     * @return \DebugBar\JavascriptRenderer
     */
    public function getJavascriptRenderer(?string $baseUrl = null, ?string $basePath = null): BaseJavascriptRenderer;

    /**
     * 返回应用管理.
     *
     * @return \Leevel\Di\IContainer
     */
    public function getContainer(): IContainer;

    /**
     * 设置配置.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return \Leevel\Debug\IDebug
     */
    public function setOption(string $name, $value): self;

    /**
     * 响应.
     *
     * @param \Leevel\Http\IRequest  $request
     * @param \Leevel\Http\IResponse $response
     */
    public function handle(IRequest $request, IResponse $response): void;

    /**
     * 关闭调试.
     */
    public function disable(): void;

    /**
     * 启用调试.
     */
    public function enable(): void;

    /**
     * 添加一条消息.
     *
     * @param mixed  $message
     * @param string $label
     */
    public function message($message, string $label = 'info'): void;

    /**
     * 添加一条 emergency 消息.
     *
     * @param mixed $message
     */
    public function emergency($message): void;

    /**
     * 添加一条 alert 消息.
     *
     * @param mixed $message
     */
    public function alert($message): void;

    /**
     * 添加一条 critical 消息.
     *
     * @param mixed $message
     */
    public function critical($message): void;

    /**
     * 添加一条 error 消息.
     *
     * @param mixed $message
     */
    public function error($message): void;

    /**
     * 添加一条 warning 消息.
     *
     * @param mixed $message
     */
    public function warning($message): void;

    /**
     * 添加一条 notice 消息.
     *
     * @param mixed $message
     */
    public function notice($message): void;

    /**
     * 添加一条 info 消息.
     *
     * @param mixed $message
     */
    public function info($message): void;

    /**
     * 添加一条 debug 消息.
     *
     * @param mixed $message
     */
    public function debug($message): void;

    /**
     * 添加一条 log 消息.
     *
     * @param mixed $message
     */
    public function log($message): void;

    /**
     * 开始调试时间.
     *
     * @param string      $name
     * @param null|string $label
     */
    public function time(string $name, ?string $label = null): void;

    /**
     * 停止调试时间.
     *
     * @param string $name
     */
    public function end(string $name): void;

    /**
     * 添加一个时间调试.
     *
     * @param string $label
     * @param float  $start
     * @param float  $end
     */
    public function addTime(string $label, float $start, float $end): void;

    /**
     * 调试闭包执行时间.
     *
     * @param string   $label
     * @param \Closure $closure
     */
    public function closureTime(string $label, Closure $closure): void;

    /**
     * 添加异常.
     *
     * @param \Throwable $e
     */
    public function exception(Throwable $e): void;

    /**
     * 获取 JSON 渲染.
     *
     * @return \Leevel\Debug\JsonRenderer
     */
    public function getJsonRenderer(): JsonRenderer;

    /**
     * 获取 Console 渲染.
     *
     * @return \Leevel\Debug\ConsoleRenderer
     */
    public function getConsoleRenderer(): ConsoleRenderer;

    /**
     * 初始化.
     */
    public function bootstrap(): void;

    /**
     * 是否初始化.
     *
     * @return bool
     */
    public function isBootstrap(): bool;
}
