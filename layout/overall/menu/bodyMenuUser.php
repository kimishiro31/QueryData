
    <nav id="divMaBar">
        <ul>
            <a href="myaccount.php">
                <li>
                    <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                    Minha Carteira
                </li>
            </a>
            <a href="userQueries.php">
                <li>
                    <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                    Consultar
                </li>
            </a>
            <a href="userQueries.php">
                <li>
                    <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                    Histórico de Consulta
                </li>
            </a>
            <a href="userDeposit.php">
                <li>
                    <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                    Compra de Moedas
                </li>
            </a>
            <a href="userPackages.php">
                <li>
                    <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                    Compra de Medalha
                </li>
            </a>
            <?php
            if(isAttendant($accountData['id'])) {
            ?>
                <a href="adminPanel.php">
                    <li>
                        <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                        Área Administrativa
                    </li>
                </a>
            <?php
            }
            ?>
            <a href="logout.php">
                <li>
                    <i class="fa fa-user fa-background pac" aria-hidden="true"></i>
                    Sair
                </li>
            </a>


        </ul>
    </nav>