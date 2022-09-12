<div id="divHeaderMenu">
	<div id="divHeaderLogo">
		<img src="layout\images\logo.png"/>
	</div>
	<nav id="navHeaderBar">
		<ul>
			<li>
				<a href="index.php">Início</a>
			</li>
			<li>
				<a href="packages.php">Pacotes</a>
			</li>
			<li>
				<a href="doubts.php">Duvidas</a>
			</li>
			<li>
				<a href="qsm.php">Quem somos?</a>
			</li>
			<li>
				<a href="rules.php">Termo de Uso</a>
			</li>
			<li>
				<a href="contacts.php">Contatos</a>
			</li>
			<li id="divHeaderLogin">
				<?php 
				if(getLoggedIn() === false) {
				?>
					<a href="login.php">
						<i style="font-size: 18px;"class="fa fa-user fa-background pac" aria-hidden="true"></i> LOGIN
					</a>
				<?php
				}
				else {
				?>
					<a href="myaccount.php">
						<i style="font-size: 18px;"class="fa fa-user fa-background pac" aria-hidden="true"></i> Painel de Usuário
					</a>
				<?php
				}
				?>
			</li>
		</ul>
	</nav>
</div>
