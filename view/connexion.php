<header id="head">
	<h2 class="alert alert-warning">Connexion</h2>
</header>
<br>
<?php if($message_erreur != '')
	echo "<div class=\"alert alert-danger errorMessage\">$message_erreur</div>";
?>

<form method="post" action="index.php">
	<table id="connexionTable">
		<tr>
			<td colspan="3"><input type="text" name="nom" placeholder="Identifiant" /></td>
		</tr>

		<tr>
			<td colspan="3"><input type="password" name="motdepasse" placeholder="Mot de passe" /></td>
		</tr>

		<tr>
			<td><br><a href="#"><input class="btn btn-warning" name="btnErase" type="reset" value="Effacer" /></a></td>
			<td><br><a href="index.php?inscription"><div class="btn btn-info">S'inscrire</div></a></td>
			<td><br><a href="index.php?btnConnexion"><input class="btn btn-primary" name="btnConnexion" type="submit" value="Jouer" /></a></td>
		</tr> 
	</table>
</form>
<br><br>