</div> <!-- border-content END -->
					</div> <!-- content END -->
				<?php //include 'complement/menu-right.php'; ?>
			</aside><!-- body END -->
		</main>
			<footer>
			<div id="divContactsContainer">
				<a href="https://wa.me/<?php echo $contact['whatsapp'] ?>"> 
					<li class="classContactOption">
						<i style="font-size: 25px;"class="fa fa-whatsapp" aria-hidden="true"></i>
					</li>
				</a>

			</div>

			<div id="divFooterContent">
				<div id="divFooterContainer">
					<div id="divFooterFrame">
						<h3>Horário de Funcionamento</h3></br>
						<hr size="1" align="center" noshade></br></br>
						<p>
							Segunda-Feira <?php echo $dhEnabled['Monday']['start']; ?> até <?php echo $dhEnabled['Monday']['end']; ?></br>
							Terça-Feira <?php echo $dhEnabled['Tuesday']['start']; ?> até <?php echo $dhEnabled['Tuesday']['end']; ?></br>
							Quarta-Feira <?php echo $dhEnabled['Wednesday']['start']; ?> até <?php echo $dhEnabled['Wednesday']['end']; ?></br>
							Quinta-Feira <?php echo $dhEnabled['Thursday']['start']; ?> até <?php echo $dhEnabled['Thursday']['end']; ?></br>
							Sexta-Feira <?php echo $dhEnabled['Friday']['start']; ?> até <?php echo $dhEnabled['Friday']['end']; ?></br>
							Sabado <?php echo $dhEnabled['Saturday']['start']; ?> até <?php echo $dhEnabled['Saturday']['end']; ?></br>
							Domingo <?php echo $dhEnabled['Sunday']['start']; ?> até <?php echo $dhEnabled['Sunday']['end']; ?></br>
						</p>
					</div>
					<div id="divFooterFrame">
						<h3>Contatos</h3></br>
						<hr size="1" align="center" noshade></br></br>
						<p>Email: <?php echo $contact['email']; ?> </br> Whats: <?php echo $contact['whatsapp']; ?></p>
					</div>
					<div id="divFooterFrame">
						<h3>Outros</h3></br>
						<hr size="1" align="center" noshade></br></br>
						<p>
							<a href="privacyPolicy.php">Politica de Privacidade</a></br>
							<a href="coockiesPolicy.php">Politica de Coockies</a>
						</p>
					</div>
				</div>
			</div>
					<hr size="1" align="center" noshade></br></br>
					<p>Copyright &copy 2022</br>Designed By Thiago</br>v0.0.0</p>
			</footer>
	</body>
</html>