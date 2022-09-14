<h1 align="center">🔗 QueryData
</h1>
<p align="center">Aplicação no qual permite a consulta do nome de uma pessoa através de uma requisição.</p>

### Video de Demonstração

### Desenvolvedores e Suporte
- +55 (11) 9 9448-9463 - Thiago

### Requisitos Recomendados

- S.O Ubuntu >= 18.04 / Windows 10
- APACHE2 >= 2.0
- PHP >= 8.0
- MYSQL >= 6.0
- PHPMYADMIN >= 2.0

### Requisitos Necessários

- Conta do tipo [Vendedor] no MercadoPago
- Email e Celular
- Conta no Zenvia


<h1 align="center">
    💬 Informátivos
</h1>
    O tutorial a seguir, ensina a fazer desde a preparação da máquina até a configuração da aplicação, utilizando de uma máquina virtual/vps recem comprado.

<h1 id="summary" align="center">
    :spiral_notepad: Cronograma
</h1>

- <a href="#preparation">Preparação do Ambiente</a>
- <a href="#apache">Instalação do Apache</a>
- <a href="#mysql">Instalação do Mysql</a>
- <a href="#php">Instalação do PhP</a>
- <a href="#phpmyadmin">Instalação do Phpmyadmin</a>
- <a href="#app">Instalação da Aplicação QD</a>


<h1 id="preparation" align="center">
    <a href="#summary">:computer: Preparação do Ambiente</a>
</h1>

O comando a seguir, fará com que o sistema operacional verifique as atualizações e a seguir faça a atualização desses pacote.
> *O sistema vai abrir uma caixa de seleção para você, aperte enter e deixe prosseguir
```
sudo apt update && sudo apt upgrade -y
```

O comando a seguir, fará com que seja instalado algumas depêndencias que serão utilizado por alguns dos serviços que iremos instalar
```
sudo apt install software-properties-common apt-transport-https -y
```

O comando a seguir, fará com que a porta 80/TCP seja liberada e tenha a descrição de identificação como Apache.
```
sudo ufw allow 80/tcp comment 'Apache'
```


O comando a seguir, fará com que a porta 443/TCP seja liberada e tenha a descrição de identificação como HTTP/HTTPS.
```
sudo ufw allow 443/tcp comment 'HTTP/HTTPS'
```

O comando a seguir, fará com que a porta 22/TCP seja liberada e tenha a descrição de identificação como SSH.
```
sudo ufw allow 22/tcp comment 'SSH'
```

O comando a seguir, fará com que o Firewall seja habilitado.
> * Após inserir o comando, ele vai te perguntar se deseja prosseguir e que poderá atrapalhar a conexão SSH, entretanto a gente já liberou a porta responsável pela conexão, então pode confirmar(Yes) e prosseguir
```
sudo ufw enable
```

O comando a seguir, fará com que você veja o status do Firewall
> O comando precisa te retornar da mesma forma que a imagem mostra
> ![image](https://user-images.githubusercontent.com/63885847/189701682-85581a53-6ee7-46cd-b7f8-f2f6151ea26c.png)
```
sudo systemctl is-enabled apache2.service
```

<h1 id="apache" align="center">
    <a href="#summary">:books: Instalação do Apache</a>
</h1>

O comando a seguir, fará com que a aplicação Apache seja instalada
```
sudo apt install apache2 -y
```

O comando a seguir, fará com que você veja o status do Apache
> O comando precisa te retornar <b>Enabled</b>, caso o mesmo te retornar disabled, inicie o apache com o comando <b>sudo systemctl enable apache2.service</b>
```
sudo systemctl is-enabled apache2.service
```

<h1 id="mysql" align="center">
    <a href="#summary">:books: Instalação do Mysql</a>
</h1>

O comando a seguir, fará com que a aplicação Mysql seja instalada
```
sudo apt install mysql-server -y
```

O comando a seguir, fará com que você acesse o Prompt do Mysql
```
sudo mysql
```

O comando a seguir, fará com que você acesse o Prompt do Mysql
> No campo <b>SUASENHA</b>, altere com sua senha, o recomendado é igual ou acima de 08 caracteres, contendo letras maíuscula e minuscula, caracteres especial, e números, por exemplo: SeNh@dm!n!str@t!va2022
```
ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'SUASENHA';
```

O comando a seguir, fará com que a gente consiga fazer consultas não relacionadas
```
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
```

O comando a seguir, fará com que você saia do Mysql
```
exit
```

O comando a seguir, faz com que o Mysql faça alguns ajuste de segurança
> Ao executar o comando abaixo, para as seguintes perguntas, você dara a resposta abaixo:</br>
> 
> P1) <b>Enter password for user root: </b></br>
> R1) Digite a sua senha, que você colocou no root do mysql.</br>
> 
> P2) <b>Press y|Y for Yes, any other key for No:</b></br>
> R2) No</br>
> 
> P3) <b>Change the password for root ?</b></br>
> R3) No</br>
> 
> P4) <b>Remove anonymous users? (Press y|Y for Yes, any other key for No) :</b></br>
> R4) Yes</br>
> 
> P5) <b>Disallow root login remotely? (Press y|Y for Yes, any other key for No) :</b></br>
> R5) Yes</br>
> 
> P6) <b>Remove test database and access to it? (Press y|Y for Yes, any other key for No) :</b></br>
> R6) Yes</br>
> 
> P7) <b>Reload privilege tables now? (Press y|Y for Yes, any other key for No) :</b></br>
> R7) Yes
```
sudo mysql_secure_installation
```

<h1 id="php" align="center">
    <a href="#summary">:books: Instalação do PhP</a>
</h1>


O comando a seguir, fará com que você instale o repositorio de instalação do PhP
```
sudo add-apt-repository ppa:ondrej/php -y
```

O comando a seguir, vai verificar se existe atualização do repositorio e a seguir vai aplicar a mesma
```
sudo apt update && sudo apt upgrade -y 
```

O comando a seguir, vai fazer a instalação do PhP versão 8.1.x
```
sudo apt install php8.1 libapache2-mod-php8.1 -y
```

O comando a seguir, vai reinicializar o serviço apache, para que sincronize com o PhP
```
sudo systemctl restart apache2
```

<h1 id="phpmyadmin" align="center">
    <a href="#summary">:books: Instalação do Phpmyadmin</a>
</h1>

O comando a seguir, fará com que você instale o phpmyadmin
```
sudo apt install phpmyadmin -y
```

> Após a execução do comando, se atente as caixas de opção que seram apresentado a você:</br>
> Na primeira opção, ele vai te perguntar com qual serviço o Phpmyadmin trabalhará, você vai apertar a tecla [TAB], em seguida [ESPAÇO], e por ultimo [ENTER], ficando da forma abaixo:
> ![image](https://user-images.githubusercontent.com/63885847/189715376-a664dcf6-28a6-42ab-942d-85fce579e5d7.png)</br>
> Após isso, a próxima tela que será apresentada é a de senha, coloque a mesma senha que foi inserido no Mysql, após isso será solicitado a confirmação da senha, coloque novamente a mesma senha, as telas serão:
> ![image](https://user-images.githubusercontent.com/63885847/189715757-5b724d38-ce27-4735-a333-e0be26abebf3.png)
> ![image](https://user-images.githubusercontent.com/63885847/189715761-04a10f0c-ecde-4bca-a3f1-a630257b4777.png)

O comando a seguir, fará com que você entre na tela de edição de texto
```
sudo nano /etc/phpmyadmin/config.inc.php
```

É necessário que após a linha <b>$cfg['Servers'][$i]['export_templates'] = 'pma__export_templates';</b>, você cole a linha abaixo, e após isso clique <b>CTRL+X</b>, em seguida digite <b>Yes</b>, e por ultimo clique em [ENTER]
> Devido a incompatibilidade do php >= 8.0 com o phpmyadmin, caso não seja inserido a tag abaixo, a todo momento que for utilizado do phpmyadmin, será informado algum erro para você.
```
$cfg['SendErrorReports'] = 'never';
```

<h1 id="app" align="center">
    <a href="#summary">:books: Instalação da Aplicação QD</a>
</h1>


O comando a seguir, fará com que você entre na pasta mencionada
```
cd /var/www/html
```

O comando a seguir, fará com que baixe dentro da pasta o repositório do projeto
```
sudo git clone https://github.com/kimishiro31/QueryData
```

O comando a seguir, fará com que mova todos os arquivos do projeto, para a pasta de inicialização da aplicação web
```
sudo mv /var/www/html/QueryData/* /var/www/html/
```

O comando a seguir, fará com que remova a pasta .gitattributes
```
sudo rm .gitattributes
```

O comando a seguir, fará com que remova a pasta .git
```
sudo rm -Rf .git
```

O comando a seguir, fará com que remova a pasta .vscode
```
sudo rm -Rf .vscode
```

O comando a seguir, fará com que remova a pasta QueryData
```
sudo rm -Rf QueryData
```
