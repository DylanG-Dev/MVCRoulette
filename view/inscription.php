<header id="head">
	<h2 class="alert alert-warning">Inscription</h2>
</header>
<br>
<?php if($message_erreur != '')
		echo "<div class=\"alert alert-danger errorMessage\">$message_erreur</div>";
?>

<form method="post" action="index.php">
	<table id="inscriptionTable">
		<tr>
			<td colspan="2"><input type="text" name="nom" placeholder="Identifiant" /></td>
		</tr>

		<tr>
			<td colspan="2"><input type="password" name="motdepasse" placeholder="Mot de passe" /></td>
		</tr>

		<tr>
			<td><br><a href="index.php?connexion"><div class="btn btn-info">Retour à la connexion</div></a></td>
			<td><br><a href="index.php?btnSignup"><input class="btn btn-primary" name="btnSignup" type="submit" value="S'inscrire" /></a></td>
		</tr> 
	</table>
</form>