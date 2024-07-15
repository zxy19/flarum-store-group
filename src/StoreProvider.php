<?php

namespace Xypp\StoreGroup;

use Flarum\Group\Group;
use Flarum\User\User;
use Xypp\Store\Context\PurchaseContext;
use Xypp\Store\PurchaseHistory;
use Xypp\Store\StoreItem;
use Xypp\Store\Context\ExpireContext;

class StoreProvider extends \Xypp\Store\AbstractStoreProvider
{
    public $name = "group";
    public function purchase(StoreItem $item, User $user, PurchaseHistory|null $old = null, PurchaseContext $context): string
    {
        $toGetGrop = Group::findOrFail($item->provider_data);
        if ($toGetGrop->id == Group::MEMBER_ID || $user->groups()->get()->contains($toGetGrop)) {
            $context->exceptionWith("xypp-store-group.forum.fail.has_own");
        }
        $user->groups()->save($toGetGrop);
        return true;
    }
    public function expire(PurchaseHistory $item, ExpireContext $expireContext): bool
    {
        $storeItem = $expireContext->getStoreItem();
        $user = $expireContext->getUser();
        $toGetGrop = Group::find($storeItem->provider_data);
        if ($toGetGrop && $user) {
            if ($toGetGrop->id != Group::MEMBER_ID && $user->groups()->get()->contains($toGetGrop)) {
                $user->groups()->detach($toGetGrop->id);
            }
        }
        return true;
    }
    public function canPurchase(StoreItem $item, User $user): bool|string
    {
        if ($user->groups()->get()->contains($item->provider_data)) {
            return "xypp-store-group.forum.fail.has_own";
        }
        return true;
    }
    public function canUseItem(PurchaseHistory $item, User $user): bool|string
    {
        return false;
    }
}