<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="/assets/styles.css">
	<meta charset="utf-8">
	<title>Welcome</title>
</head>
<body>
	<h1>Welcome <?= $user['first_name'] ?></h1>
	<? $count = 0;
		foreach($pokers as $poker) {
				$count++;
        } ?>
	<h2><?= $count ?> people poked you!</h2>
	<div>
		<div>
			<? foreach($pokers as $poker) { ?>
				<div class="post">
					<p><?= $poker['first_name'] ?> poked you <?= $poker['count'] ?> times.</p>
        		</div>
        	<?php } ?>
        </div>
	</div>
	<div>
		<h3>People you may want to poke</h3>
		<div>
			<?php foreach($friends as $friend) { ?>
				<div class="post">
					<p>Name: <?= $friend['first_name'] ?> <?= $friend['last_name'] ?></p>
					<p>Alias: <?= $friend['alias'] ?></p>
					<p>Email: <?= $friend['email'] ?></p>
					<p>Poke History: <?= $friend['poke_history'] ?> pokes</p>
        			<form action="/logins/poke_someone" method="post">
			        	<input type="hidden" value="<?= $friend['id'] ?>" name="getting_poked">
			        	<input type="submit" value="Poke!">
			        </form>
        		</div>
        	<?php } ?>
        </div>
	</div>
	<a href="logins/logoff_user"><button>Log Off</button></a>
</body>
</html>