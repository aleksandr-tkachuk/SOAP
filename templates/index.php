<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskSOAP 1</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
</head>
<body>
<h3>Players Franse</h3>
<?= $player ?>

<h3>Stadium name</h3>
<?= $stadium ?>
<br><br>
<h4>Format:</h4> <?= date("Y-m-d") ?>
<form action="" method="POST">
    <div class="form-group">
        <input name="Ymd" type="text" class="form-control" placeholder="Y-m-d" style="width: 25%" required>
    </div>
    <label for="sel1">Select currency:</label>
    <select name="currency2" class="form-control" id="sel1" style="width: 25%" required>
        <option value=""></option>
        <?php foreach ($resCurl as $currency) { ?>
            <option value='<?= $currency['chCode'] ?>'><?= $currency['name'] ?></option>
        <?php } ?>
    </select>
    <button type="submit" class="btn btn-success">send</button>

</form>
<table class="table table-striped" style="width: 25%">
    <thead>
    <tr>
        <th><?= $curs[0] ?></th>
        <th><?= $curs[1] ?></th>
    </tr>
    </thead>
</table>
<br><br>
<form action="" method="POST">
    <div class="form-group">
        <label for="sel1">Select currency:</label>
        <select name="currency" class="form-control" id="sel1" style="width: 25%">
            <?php foreach ($resultCurrency as $currency) { ?>
                <option value='<?= $currency->VchCode ?>'><?= $currency->Vname ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit_currency" class="btn btn-success">send currency</button>
</form>

<table class="table table-striped" style="width: 25%">
    <thead>
    <tr>
        <th><?= $data[0] ?></th>
        <th><?= $data[2] ?></th>
        <th><?= $data[4] ?></th>
    </tr>
    </thead>
</table>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>
