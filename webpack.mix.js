const mix = require('laravel-mix');

mix
  .js('resources/ui/', 'public/ui/js/app.js')
  .sass('resources/ui/styles/index.scss', 'public/ui/css/app.css');
