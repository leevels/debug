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
 * (c) 2010-2020 http://queryphp.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leevel\Debug\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Leevel\Kernel\IApp;

/**
 * 框架基础信息收集器.
 */
class LeevelCollector extends DataCollector implements Renderable
{
    /**
     * 应用.
     */
    protected IApp $app;

    /**
     * 构造函数.
     */
    public function __construct(IApp $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritDoc}
     */
    public function collect(): array
    {
        $app = $this->app;

        return [
            'version'     => $app::VERSION,
            'environment' => $app->environment(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'leevel';
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgets(): array
    {
        return [
            'version' => [
                'icon'    => 'github',
                'tooltip' => 'Version',
                'map'     => 'leevel.version',
                'default' => '',
            ],
            'environment' => [
                'icon'    => 'desktop',
                'tooltip' => 'Environment',
                'map'     => 'leevel.environment',
                'default' => '',
            ],
        ];
    }
}
