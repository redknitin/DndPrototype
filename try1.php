<!doctype html><html>
<head><title></title></head>
<body>
<?php
function preference_history($row) {
	echo '<table border="1"><tr><th>Date</th><th>Preference</th><th>Status</th></tr>';
	foreach($row->preference_history as $iter)
	echo "<tr><td>{$iter->preference_date}</td><td>{$iter->preference}</td><td>{$iter->status}</td></tr>";
	echo '</table>';
}


if (isset($_POST['phoneno'])) {
	require 'vendor/autoload.php';

	Unirest::verifyPeer(false); // Disables SSL cert validation

	// These code snippets use an open-source library.
	$response = Unirest::get('https://dndcheck.p.mashape.com/index.php?mobilenos='.$_POST['phoneno'],
	  array(
		"X-Mashape-Key" => "1F8Z8C2qIHmshMcnMkr89B8joeuPp1owLd8jsnDoNTQMqxPl6b"
	  )
	);
?>

<!--
<?php
print_r($response);
?>
-->

<?php	
	$result = $response->body;
?>
	<table border="1">
		<tr>
			<th>Number</th>
			<th>DND Status</th>
			<th>Activated on</th>
			<th>Current NCPR Preference</th>
			<th>Preference History</th>
		</tr>
<?php foreach($result as $row): ?>
		<tr>
			<td><?php echo $row->mobilenumber; ?></td>
			<td><?php echo $row->DND_status; ?></td>
			<td><?php if ($row->DND_status!='off') echo $row->activation_date; ?></td>
			<td><?php if ($row->DND_status!='off') echo $row->current_preference; ?></td>
			<td><?php if ($row->DND_status!='off') preference_history($row); ?></td>
		</tr>
<?php endforeach; ?>
	</table>
<?php	
}
?>

<br>

<form method="post" action="">
<input type="tel" name="phoneno" placeholder="Phone No">
<input type="submit" value="Get DND Info">
</form>

</body></html>