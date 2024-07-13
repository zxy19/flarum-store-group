import app from 'flarum/common/app';

app.initializers.add('xypp/store-group', () => {
  console.log('[xypp/store-group] Hello, forum and admin!');
});
