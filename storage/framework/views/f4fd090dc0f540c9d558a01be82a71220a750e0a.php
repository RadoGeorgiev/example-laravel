<?php $__env->startSection('title', 'Homepage'); ?>

<?php $__env->startSection('content'); ?>

	<h1>News feed</h1>
	<a href="/table">
        <div><img src="/svg/icon.svg" style="height: 25px;"></div>
	</a>
	<a href="/oldhome">old homepage link</a>
	<hr>

	Post a message:

	<form action="/create" method="POST">

		<input type="text" name="title" placeholder="Title">

		<input type="text" name="content" placeholder="Content">

		<button type="submit">Submit</button>

	</form>

	<br>

	Recent Messages:

	<ul>
		<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li>
				<strong><?php echo e($message->title); ?></strong>
				<br>
				<?php echo e($message->content); ?>

				<br>
				<?php echo e($message->created_at->diffForHumans()); ?> <!-- try => diffForHumans() => 1 min ago, 2 weeks ago, etc. -->
				<br>
				<a href="/message/<?php echo e($message->id); ?>">Read</a>
			</li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rado-pcloud/pcloud/example/example-app/resources/views/newhome.blade.php ENDPATH**/ ?>