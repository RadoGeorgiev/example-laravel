<?php $__env->startSection('title', $message->title); ?>

<?php $__env->startSection('content'); ?>

	<h3><?php echo e($message->title); ?></h3>
	<p><?php echo e($message->content); ?></p>
	<br>
	<a href="/">Back</a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rado-pcloud/pcloud/example/example-app/resources/views/message.blade.php ENDPATH**/ ?>