import app from 'flarum/forum/app';
import { addFrontendProviders } from "@xypp-store/forum"
import Group from 'flarum/common/models/Group';
import StoreItem from '@xypp-store/common/models/StoreItem';
import PurchaseHistory from '@xypp-store/common/models/PurchaseHistory';
import { getBox } from './getBox';

app.initializers.add('xypp/store-group', () => {
  addFrontendProviders(
    "group",
    app.translator.trans("xypp-store-group.forum.name") as string,
    async function (datas) {
      await app.store.find("groups");
      (app.store.all("groups") as Group[])
        .filter((g) => g.id() != "2")
        .forEach((group: Group) => {
          const id = group.id();
          id && (datas[id] = group.namePlural());
        });
    },
    getBox
  )
});
