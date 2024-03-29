<?php

declare(strict_types=1);

namespace Leevel\Debug;

/**
 * Console 渲染.
 */
class ConsoleRenderer
{
    /**
     * debug 管理.
     */
    protected Debug $debugBar;

    /**
     * 构造函数.
     */
    public function __construct(Debug $debugBar)
    {
        $this->debugBar = $debugBar;
    }

    /**
     * 渲染数据.
     */
    public function render(): string
    {
        return $this->console($this->debugBar->getData());
    }

    /**
     * 返回输出到浏览器.
     */
    protected function console(array $data): string
    {
        $content = [];
        $content[] = '<script type="text/javascript">
console.log( \'%cThe PHP Framework For Code Poem As Free As Wind %c(http://www.queryphp.com)\', \'font-weight: bold;color: #06359a;\', \'color: #02d629;\' );';

        foreach ($data as $key => $item) {
            if (\is_string($key)) {
                $content[] = 'console.log(\'\');';
                $content[] = 'console.log(\'%c '.$key.'\', \'color: blue; background: #045efc; color: #fff; padding: 8px 15px; -moz-border-radius: 15px; -webkit-border-radius: 15px; border-radius: 15px;\');';
                $content[] = 'console.log(\'\');';
            }
            if ($item) {
                $content[] = 'console.log('.json_encode($item, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT).');';
            }
        }

        $content[] = '</script>';

        return implode('', $content);
    }
}
