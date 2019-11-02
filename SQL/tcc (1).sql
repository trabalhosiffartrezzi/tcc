-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Nov-2019 às 01:39
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc`
--

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idcat`, `nome`) VALUES
(7, 'Lavagem de roupas'),
(8, 'Produtos Automotivos'),
(9, 'Limpeza da Casa'),
(11, 'Limpeza Pos Ordenha'),
(12, 'Aromatizantes');

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`idcidade`, `nomecidade`, `estadoid`) VALUES
(1, 'Acegua', 21),
(2, 'Ajuricaba', 21),
(3, 'Alpestre', 21),
(4, 'Ametista do Sul', 21),
(5, 'Boa Vista das Missoes', 21),
(6, 'Boa Vista do Burica', 21),
(7, 'Carazinho', 21),
(8, 'Casca', 21),
(9, 'Cerro Grande', 21),
(10, 'Chapada', 21),
(11, 'Chiapetta', 21),
(12, 'Constantina', 21),
(13, 'Cerro Largo', 21),
(14, 'Chapada', 21),
(15, 'Chiapetta', 21),
(16, 'Constantina', 21),
(17, 'Coronel Bicaco', 21),
(18, 'Cristal do Sul', 21),
(19, 'Cruz Alta', 21),
(20, 'Dois Irmaos das Missoes', 21),
(21, 'Entre Rios do Sul', 21),
(22, 'Erechim', 21),
(23, 'Erval Seco', 21),
(24, 'Frederico Westphalen', 21),
(25, 'Ijui', 21),
(26, 'Irai', 21),
(27, 'Jaboticaba', 21),
(28, 'Lajeado do Bugre', 21),
(29, 'Marau', 21),
(30, 'Palmeira das Missoes', 21),
(31, 'Palmitinho', 21),
(32, 'Panambi', 21),
(33, 'Parobe', 21),
(34, 'Passa Sete', 21),
(35, 'Passo Fundo', 21),
(36, 'Pinhal', 21),
(37, 'Pinheirinho do Vale', 21),
(38, 'Planalto', 21),
(39, 'Sagrada Familia', 21),
(40, 'Sarandi', 21),
(41, 'Seberi', 21),
(42, 'Sobradinho', 21),
(43, 'Taquarucu do Sul', 21),
(44, 'Trindade do Sul', 21),
(45, 'Tres Passos', 21),
(46, 'Tenente Portela', 21),
(47, 'Vicente Dutra', 21),
(48, 'Vista Alegre', 21),
(49, 'Vista Gaucha', 21),
(52, 'Bento Gonçalves', 21);

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`idenderec`, `rua`, `bairro`, `numero`, `complemento`, `cidadeid`) VALUES
(2, 'Linha Santo Antonio', 'Interior', 400, 'End Rural', 40),
(36, 'Vila Santo Antonio', 'Rural', 400, 'Perto da Igreja da Comunidade', 43),
(37, 'Ln Sete de Setembro', 'Rural', 0, 'Rural', 21);

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`idestado`, `nome`, `sigla`) VALUES
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amapa', 'AP'),
(4, 'Amazonas', 'AM'),
(5, 'Bahia', 'BA'),
(6, 'Ceara', 'CE'),
(7, 'Distrito Federal', 'DF'),
(8, 'Espirito Santo', 'ES'),
(9, 'Goias', 'GO'),
(10, 'Maranha', 'MA'),
(11, 'Mato Grosso', 'MT'),
(12, 'Mato Grosso do Sul', 'MS'),
(13, 'Minas Gerais', 'MG'),
(14, 'Para', 'PA'),
(15, 'Paraiba', 'PB'),
(16, 'Paraná', 'PR'),
(17, 'Pernambuco', 'PR'),
(18, 'Piaui', 'PI'),
(19, 'Rio de janeiro', 'RJ'),
(20, 'Rio Grande do Norte', 'RN'),
(21, 'Rio Grande do Sul', 'RS'),
(22, 'Rondonia', 'RO'),
(23, 'Roraima', 'RR'),
(24, 'Santa Catarina', 'SC'),
(25, 'Sao Paulo', 'SP'),
(26, 'Sergipe', 'SE'),
(27, 'Tocantins', 'TO');

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`idprod`, `nomeprod`, `descricao`, `valor`, `unidade`, `categoriaid`) VALUES
(15, 'Amaciante de Roupas 5L', 'Amacia e deixa odor agradável nas roupas', 11, 'Un', 7),
(18, 'Lava roupas concentrado brisa suave 5L', 'Detergente liquido para lavar roupas', 14, 'Un', 7),
(19, 'Desinfetante capim cheiroso 5L', 'Produto para sanitários', 11, 'Un', 9),
(20, 'Tira Mofo 5L', 'Remove mofo de paredes e calçadas e azulejos', 13, 'Un', 9);

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`iduser`, `nome`, `funcao`, `telefone`, `senha`, `cpf_cnpj`, `email`, `enderecoid`) VALUES
(3, 'Cassiano L. Trezzi', 'Vendedor', '55996666926', '3fbeeb2ab0cc0de04a10ce57e2a377a9', '029.526.080-75', 'cassiano.trezzi@gmail.com', 2),
(12, 'Valdelini Pereira da Luz', 'Administrador', '55999038190', 'f47bbee4232c293a1e81c79bc4a4cf0c', '000.111.222-33', 'toplimpotrabalho@gmail.co', 36);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
