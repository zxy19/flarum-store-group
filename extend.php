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
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/less/admin.less'),
    new Extend\Locales(__DIR__ . '/locale'),
    (new \Xypp\Store\Extend\StoreItemProvider())
        ->simple(
            "group",
            function (StoreItem $item, User $user, PurchaseHistory|null $old = null, PurchaseContext $context): string {
                $toGetGrop = Group::findOrFail($item->provider_data);
                if ($toGetGrop->id == Group::MEMBER_ID || $user->groups()->get()->contains($toGetGrop)) {
                    $context->exceptionWith("xypp-store-group.forum.fail.has_own");
                }
                $user->groups()->save($toGetGrop);
                return true;
            },
            null,
            function (PurchaseHistory $item) {
                $storeItem = $item->store_item()->get();
                $user = User::find($item->user_id);
                $toGetGrop = Group::find($storeItem->provider_data);
                if ($toGetGrop && $user) {
                    if ($toGetGrop->id != Group::MEMBER_ID && $user->groups()->get()->contains($toGetGrop)) {
                        $user->groups()->detach($toGetGrop->id);
                    }
                }
                return true;
            }
        )
];
