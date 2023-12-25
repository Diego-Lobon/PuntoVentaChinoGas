

const { mix } = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/filtroCliente.js', 'public/js')
   .sourceMaps();

mix.copy('node_modules/ziggy-js/dist/ziggy.js', 'public/js');