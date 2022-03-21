const mix = require('laravel-mix');
let productionSourceMaps = false;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    devtool: 'eval-source-map',
    resolve: {
        extensions: ['.js', '.vue'],
        alias: {
            '@': __dirname + '/resources'
        }
    },
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules(?!\/foundation-sites)|bower_components/,
                use: {
                    loader: 'babel-loader'
                }
            }
        ]
    }
});

mix.js('resources/js/app.js', 'public/js').sourceMaps(productionSourceMaps, 'source-map')
    .extract(['vue']);
mix.sass('resources/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}