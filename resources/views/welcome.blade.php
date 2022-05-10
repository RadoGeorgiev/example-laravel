<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<a href="/table">
        <div><img src="/svg/icon.svg" style="height: 25px;"></div>
</a>
<body>

                <div>WELLCOME EXAMPLE PAGE</div>
                <hr>
                <div>Date/time print: {{date('Y-m-d H:i:s')}}</div>
                <hr>
                <div>
                <header>Test buttons</header>
                <hr>
                <button type="button" class="btn btn-primary">Insert</button>
                <button type="button" class="btn btn-secondary">Update</button>
                <button type="button" class="btn btn-success">Delete</button>
                </div>
                <hr>
                <button type="button" class="btn btn-danger">Danger</button>
                <button type="button" class="btn btn-warning" onclick="sqlSelect()">Sql Select</button>
                <button type="button" class="btn btn-info" onclick="sqlCountAll()">CountAll</button>
    </body>
    <script>
        function sqlSelect() {
            $.get("/sql-select", function(data) {
                if (data) {
                    console.log(data);
                    alert(data[0]['name']);
                } else {
                    alert("Error");
                }
            });
        }
        function sqlCountAll() {
            $.get("/sql-count", function(data) {
                if (data) {
                    console.log(data);
                    alert(data[0]['count(*)']);
                } else {
                    alert("Error");
                }
            });
        }
    </script>
</html>
    