const mix = require('laravel-mix');

const tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');
mix
  .webpackConfig({
    resolve: {
      alias: {
        '@': __dirname + '/resources/ui/',
      },
    },
  })
  .js('resources/ui/', 'public/ui/js/app.js')
  .sass('resources/ui/styles/index.scss', 'public/ui/css/app.css')
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')],
  })
  .purgeCss({
    defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
    whitelistPatterns: [/^(?!.*tw-).*$/], // stay way from everything not tailwind
  });
