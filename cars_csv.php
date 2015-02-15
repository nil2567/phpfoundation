<?php
require_once 'includes/cars_pdo.php';
if( isset($_POST['download']) ){
	header('Content-Type: text/csv');
	header('Content-Disposition: attachement;filename=cars.csv');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	header('Expires: 0');
	
	$csvoutput = fopen('php://output','w');
	$row = getRow($result);
	$headers = array_keys($row);
	fputcsv($csvoutput,$headers);
	fputcsv($csvoutput,$row);
	while( $row = getRow($result) ){
		fputcsv($csvoutput,$row);
	}
	fclose($csvoutput);
	exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Used Cars</title>
<link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="wrapper">
<?php
if (isset($error)) {
    echo "<p>$error</p>";
}
?>
    <h1>Used Cars for Sale</h1>
    <?php while ($row = getRow($result)) { ?>
    <h2><?php echo $row['make']; ?></h2>
    <ul>
        <li>Price: $<?php echo number_format($row['price'], 2); ?></li>
        <li>Year: <?php echo $row['yearmade']; ?></li>
        <li>Mileage: <?php echo number_format($row['mileage'], 0); ?></li>
        <li>Transmission: <?php echo $row['transmission']; ?></li>
    </ul>
    <p><?php echo $row['description']; ?></p>
    <hr>
    <?php } ?>
    <form method="post">
        <fieldset>
            <legend>Download Results in CSV Format</legend>
            <p>
                <input type="submit" name="download" id="download" value="Download File">
            </p>
        </fieldset>
    </form>
</div>
</body>
</html>