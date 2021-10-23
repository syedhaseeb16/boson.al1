let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/plugins/' + directory;
const dist = 'public/vendor/core/plugins/' + directory;

mix
    .js(source + '/resources/assets/js/marketplace.js', dist + '/js')
    .js(source + '/resources/assets/js/marketplace-product.js', dist + '/js')
    .js(source + '/resources/assets/js/marketplace-vendor.js', dist + '/js')
    .js(source + '/resources/assets/js/discount.js', dist + '/js')
    .js(source + '/resources/assets/js/store-revenue.js', dist + '/js')
    .sass(source + '/resources/assets/sass/style.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/rtl.scss', dist + '/css')

    .copyDirectory(dist + '/js', source + '/public/js')
    .copyDirectory(dist + '/css', source + '/public/css');
