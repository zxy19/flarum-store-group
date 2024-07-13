import app from 'flarum/admin/app';

app.initializers.add('xypp/store-group', () => {
  console.log('[xypp/store-group] Hello, admin!');
});
