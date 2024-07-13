<?php

/*
 * This file is part of xypp/store-group.
 *
 * Copyright (c) 2024 小鱼飘飘.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Xypp\StoreGroup;

use Flarum\Extend;
use Flarum\Group\Group;
use Flarum\User\User;
use Xypp\Store\Context\PurchaseContext;
use Xypp\Store\PurchaseHistory;
use Xypp\Store\StoreItem;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/less/forum.less'),
    new Extend\Locales(__DIR__ . '/locale'),
    (new \Xypp\Store\Extend\StoreItemProvider())
        ->simple(
            
        )
];
