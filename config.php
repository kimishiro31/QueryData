<?php

	$config['site_title'] = 'Titulo do Site'; // Titulo do site
	$config['site_initials'] = 'Iniciais do Site'; // Nome do site
	$config['site_description'] = 'Descrição do Site'; // Descrição do site
	$config['site_url'] = 'localhost'; // URL do site para futuras verificações por email

    $config['sqlUser'] = 'usuario'; // USUARIO DO MYSQL
	$config['sqlPassword'] = 'senha'; // SENHA DO MYSQL
	$config['sqlDatabase'] = 'banco'; // NOME DA DATABASE DO MYSQL
	$config['sqlHost'] = 'localhost'; // HOST DO MYSQL

	#########################################
	## CONFIGURAÇÕES GERAIS 
	#########################################

	$config['accountValidation'] = '1 minutes'; // Tempo de espera para reenvio de codigo
	$config['timeLogout'] = 5000; // Tempo de sessão para logout
	$config['rowsPerPage'] = 10; // Quantidade de resultados por pagina
	$config['timeRefresh'] = 10; // Tempo de refresh em minutos da pagina admin
	$config['timeNewVisit'] = '02 hours'; // tempo para reconhecer uma nova visita
	

	$config['status'] = array(
		0 => 'Desativado',
		1 => 'Ativado'
	);

	$config['statusVerify'] = array(
		0 => 'Não Verificado',
		1 => 'Verificado'
	);

	
	$config['ConfigMVV'] = array(
		'mission' => 'Ajudar na consulta de dados, para que menos pessoas sejam vitimas de golpes.',
		'vision' => 'Ser o parceiro preferencial de nossos clientes em consulta.',
		'value' => '* Agir com discrição, segurança.</br>* Qualidade e confiabilidade.</br>* Superar as expectativas de nossos clientes.'
	);

	
	$config['siteDHEnabled'] = array(
		'Monday' => array(
			'start' => '08:00',
			'end' => '19:00'
		),
		'Tuesday' => array(
			'start' => '08:00',
			'end' => '19:00'
		),
		'Wednesday' => array(
			'start' => '08:00',
			'end' => '19:00'
		),
		'Thursday' => array(
			'start' => '08:00',
			'end' => '19:00'
		),
		'Friday' => array(
			'start' => '08:00',
			'end' => '19:00'
		),
		'Saturday' => array(
			'start' => '08:00',
			'end' => '19:00'
		),
		'Sunday' => array(
			'start' => '08:00',
			'end' => '19:00'
		)
	);


	#########################################
	## CONFIGURAÇÕES DAS CONSULTAS 
	#########################################

	$config['configQueries'] = array(
		1 => array(
			'name' => 'Nome + Data de Nascimento',
			'description' => 'Resultado: Dados cadastrais, signo, rg, cpf, situação, score, renda presumida, contatos, parentes, vizinhos.',
			'cost' => 15.00
		),
		2 => array(
			'name' => 'CPF',
			'description' => 'Resultado: Dados cadastrais, telefones, endereços, RG, familiares, renda presumida, profissão, score, classe social, poder aquisitivo, empregos, e-mails, endereços e etc...',
			'cost' => 15.0
		),
		3 => array(
			'name' => 'CNPJ',
			'description' => 'Resultado: Dados cadastrais de empresas na base da Receita Federal, situação cadastral, data da abertura, capital social, endereço, telefone, email, quadro de sócios e outras informações.',
			'cost' => 15.0
		),
		4 => array(
			'name' => 'Placa',
			'description' => 'Resultado: Dados cadastrais do titular, contatos, parentes do titular, endereços, vizinhos, dados do veículo...',
			'cost' => 30.0
		),
		5 => array(
			'name' => 'Score',
			'description' => 'Resultado: Nome do titular e pontuação do Score.',
			'cost' => 5.0
		),
		6 => array(
			'name' => 'Telefone',
			'description' => 'Resultado: nome completo do titular, data de nascimento, CPF, endereços e outras informações.',
			'cost' => 15.0
		)
	);

	#########################################
	## CONFIGURAÇÕES DO SHOP 
	#########################################


	$config['marketConfig'] = array(
		'accessToken' => 'TOKEN', // TOKEN DO MERCADO LIVRE
	);


	#########################################
	## CONFIGURAÇÕES DO ADMIN 
	#########################################

	
	$config['adminGroups'] = array(
		0 => 'Padrão',
		1 => 'Atendente',
		2 => 'Gerente',
		3 => 'Administrador'
	);
	
	$config['statusQuery'] = array(
		0 => 'Cancelado - Sem Reembolso',
		1 => 'Cancelado - Reembolsado',
		2 => 'Aguardando Atribuição',
		3 => 'Consultando',
		4 => 'Finalizado - Enviado por Email',
		5 => 'Finalizado - Enviado por Whatszap',
		6 => 'Finalizado - Enviado por Email/Whatszap'
	);

	#########################################
	## CONFIGURAÇÕES DE CONSULTA 
	#########################################

	$config['startCredits'] = 10; // Créditos Iniciais

	$config['typeCredits'] = array(
		1 => array(
			'name' => 'QDCoin',
			'time' => '3 hours'
		),
		2 => array(
			'name' => 'Vouncher - Medalha Bronze',
			'time' => '3 hours'
		),
		3 => array(
			'name' => 'Vouncher - Medalha Prata',
			'time' => '2 hours'
		),
		4 => array(
			'name' => 'Vouncher - Medalha Ouro',
			'time' => '30 minutes'
		)
	);

	#########################################
	## CONFIGURAÇÕES DE REGISTRO 
	#########################################


	$config['ofDate'] = true; // Precisa ser maior de idade para se registrar


	$config['accountConfirm'] = array(
		'email' => true,
		'phone' => true
	);

	#########################################
	## CONFIGURAÇÕES DE EMAIL 
	#########################################

	
    $config['mailHost'] = 'smtp';  // hoster do email
	$config['SMTPAuth'] = true; 
	$config['mailLogin'] = 'login';  // email
	$config['mailPassword'] = 'senha'; // senha do email
	$config['mailPort'] = 465; // porta

	$config['contacts'] = array(
		'email' => 'atendimento@email.com.br', 
		'whatsapp' => '0000000000000',
	);

	#########################################
	## CONFIGURAÇÕES DE SMS 
	#########################################

	$config['telConfig'] = array(
		'alias' => "usario31", // usuário do zenvia
		'code' => "code20" // senha do zenvia
	)

	


?>