import PurchaseHistory from "@xypp-store/common/models/PurchaseHistory";
import StoreItem from "@xypp-store/common/models/StoreItem";
import app from "flarum/admin/app";
import Group from "flarum/common/models/Group";
import Placeholder from "flarum/common/components/Placeholder"
export function getBox(item: StoreItem, history?: PurchaseHistory) {
    const grp: Group | undefined = app.store.getById("group", item.provider_data() as string);
    if (!grp) {
        return <Placeholder text={app.translator.trans("xypp-store-group.forum.fail.not_found")} />
    }
    return <div className="group-class">
        <p><i className={"fas fa-" + grp.icon()}></i></p>
        <p>{grp.namePlural()}</p>
    </div>
}