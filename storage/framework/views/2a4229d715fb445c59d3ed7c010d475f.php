<!-- selected_users.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Users PDF</title>
</head>
<body>
    <h1>Users List</h1>

    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div <?php if(!$loop->last): ?> style="page-break-after: always;" <?php endif; ?>>
            <h3>Id: <?php echo e($user->id); ?></h3>
            <h3>First Name: <?php echo e($user->firstname); ?></h3>
            <h3>Last Name: <?php echo e($user->lastname); ?></h3>
            <h3>Email: <?php echo e($user->email); ?></h3>
            <h3>Address: <?php echo e($user->address); ?></h3>
            <h3>Phone: <?php echo e($user->phone); ?></h3><br>
            <?php
            $qrCode = QrCode::size(110)->generate("ID: $user->id , First Name: $user->firstname , Last Name: $user->lastname , Email: $user->email, Address: $user->address , Phone: $user->phone");
        ?>
        <h3>QR Code:</h3><img src="data:image/png;base64,<?php echo e(base64_encode($qrCode)); ?>" alt="QR Code"><br><br>
        <h3>Bar Code:</h3><img src="data:image/png;base64,<?php echo e(DNS1D::getBarcodePNG($user->id , 'C39')); ?>" alt="barCode">
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
</html>
<?php /**PATH /var/www/html/project/laravel_vue3/example-app/resources/views/pdf/selected_users.blade.php ENDPATH**/ ?>