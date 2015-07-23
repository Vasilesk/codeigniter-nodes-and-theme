<h2>
<?php
echo $node['title'];
?>
</h2>
	<small>
		<p><span class="glyphicon glyphicon-time"></span>
		<?php
		echo date('H:i Y-m-d', $node['created']);
		?>
		</p>
	</small>
<?php
echo $node['body_value'];
?>
<h3>Комментарии.</h3>
