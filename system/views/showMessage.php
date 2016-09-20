<!doctype html>
<html lang="en">
	<head>
		<meta charset="<?php echo CHARSET; ?>">
		<link rel="shortcut icon" href="<?php echo STATICURL; ?>/base/cps/image/favicon.ico">
		<title><?php echo $msgTitle; ?></title>
		<link rel="stylesheet" href="<?php echo STATICURL; ?>/base/cps/css/error.css">
	</head>
	<body>
		<div class="ct">
			<div class="status-tip status-tip-<?php echo $messageType; ?>">
				<i></i>
				<p><?php echo $message ?></p>
				<p><span id="wait" class='badge badge-info'><?php echo isset( $timeout ) && $autoJump ? $timeout : ''; ?></span></p>
				<?php if ( $autoJump ): ?>
					<a id="href" href="<?php echo $jumpUrl ?>" class="tip-url"></a>
					<script>
						(function() {
							var wait = document.getElementById('wait'),
								href = document.getElementById('href').href;

							var interval = setInterval(function() {
								var time = --wait.innerHTML;
								if (time === 0) {
									location.href = href;
									clearInterval(interval);
								}
							}, 1000);
						})();
					</script>
				<?php else: ?>
					<?php foreach ( $jumpLinksOptions as $linkName => $url ): ?>
						<a class="tip-url" href="<?php echo $url; ?>"><?php echo $linkName; ?></a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( isset( $script ) ): ?>
			<script>
	<?php echo $script; ?>
			</script>
		<?php endif; ?>
	</body>
</html>