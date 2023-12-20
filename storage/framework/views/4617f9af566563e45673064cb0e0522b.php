<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            body {
                background-color:#9b6d6d7d;
            }
        </style>

    </head>
    <body class="antialiased">
        <div id="app">
            <App />
        </div>

        <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

    </body>
</html>
<?php /**PATH /var/www/html/project/laravel_vue3/example-app/resources/views/welcome.blade.php ENDPATH**/ ?>