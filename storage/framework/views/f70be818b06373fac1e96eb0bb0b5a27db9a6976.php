<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
  <title>Table preview</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
	<div class="container">
		<a href="/">
		<div><img src="/svg/icon.svg" style="height: 25px;"></div>
		<div>Test Table</div>
		</a>
		<div class="row custom-container">
				<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Change</th>
                            <th>Insert</th>
                            <th>Update with Regex</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($labels as $label) { ?>
                            <tr>
                            	<th><?php echo e($label->id); ?></th>
                                <td><?php echo e($label->name); ?></td>
                                <td>
                                 <button class="btn btn-warning btn-sm" onclick="changeLabelName(<?php echo e($label->id); ?>, '<?php echo e($label->name); ?>')">Change Name</button>
                                </td>
                                <td>
                                	<button type="button" class="btn btn-info" onclick="insertLabelName(<?php echo e($label->id); ?>, '<?php echo e($label->name); ?>')">Insert</button>
                                </td>
                                <td>
                                	<button type="button" class="btn btn-success" onclick="updateLabelName(<?php echo e($label->id); ?>, '<?php echo e($label->name); ?>')">Update</button>
                                </td>
                                <td>
                                	<button type="button" class="btn btn-danger" onclick="deleteLabel(<?php echo e($label->id); ?>)">Delete</button>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
			</div>
		</div>
	<script>
		function changeLabelName(labelid, name) {
			$.post("/label/" + labelid + "/change", {name: name}, function(data) {
				if (data) {

					console.log(data);
					
					alert("Name changed to " + data['updated']);

					location.reload();

				} else {
					alert("Error");
				}
			});
		}
		function insertLabelName(labelid, name) {
			$.post("/label/" + labelid + "/insert", {name: name}, function(data) {
				if (data) {

					console.log(data);
					
					alert("Name " + data['insert'] + " inserted");

					location.reload();

				} else {
					alert("Error");
				}
			});
		}
		function updateLabelName(labelid, name) {
			$.post("/label/" + labelid + "/update", {name: name}, function(data) {
				if (data) {

					console.log(data);
					
					alert("Name " + name + " updated to " + data['origin']);

					location.reload();

				} else {
					alert("Error");
				}
			});
		}
		function deleteLabel(labelid) {
			$.post("/label/" + labelid + "/delete", function(data) {
				if (data) {

					console.log(data);
					
					alert("ID " + data['id'] + " deleted");

					location.reload();

				} else {
					alert("Error");
				}
			});
		}
	</script>
</html>
<?php /**PATH /home/rado-pcloud/pcloud/example/example-app/resources/views/table/table.blade.php ENDPATH**/ ?>