-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Set-2019 às 01:16
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `idcat` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idcat`, `nome`) VALUES
(7, 'Lavagem de roupas'),
(8, 'Produtos Automotivos'),
(9, 'Limpeza da Casa'),
(11, 'Limpeza Pos Ordenha');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE `cidade` (
  `idcidade` int(11) NOT NULL,
  `nomecidade` varchar(25) DEFAULT NULL,
  `estadoid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(49, 'Vista Gaucha', 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `idenderec` int(11) NOT NULL,
  `rua` varchar(25) DEFAULT NULL,
  `bairro` varchar(10) DEFAULT NULL,
  `numero` int(7) DEFAULT NULL,
  `complemento` varchar(40) DEFAULT NULL,
  `cidadeid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`idenderec`, `rua`, `bairro`, `numero`, `complemento`, `cidadeid`) VALUES
(1, 'Linha Santo Antonio', 'Interior', 710, 'End Rural', 40),
(2, 'Linha Santo Antonio', 'Interior', 400, 'End Rural', 40);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

CREATE TABLE `estado` (
  `idestado` int(11) NOT NULL,
  `nome` varchar(25) DEFAULT NULL,
  `sigla` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `idpgto` int(11) NOT NULL,
  `condicaopgto` varchar(25) DEFAULT NULL,
  `prazopgto` varchar(15) DEFAULT NULL,
  `desconto` float(4,4) DEFAULT NULL,
  `observacao` varchar(40) DEFAULT NULL,
  `tipo` varchar(25) DEFAULT NULL,
  `vendapid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `idprod` int(11) NOT NULL,
  `nomeprod` varchar(50) DEFAULT NULL,
  `descricao` varchar(40) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `unidade` varchar(2) DEFAULT NULL,
  `categoriaid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`idprod`, `nomeprod`, `descricao`, `valor`, `unidade`, `categoriaid`) VALUES
(2, 'Alvejante s/ Cloro 5L', 'Remove manchas e sujeiras', 10, 'Un', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `iduser` int(11) NOT NULL,
  `nome` varchar(25) DEFAULT NULL,
  `funcao` varchar(10) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `senha` varchar(700) DEFAULT NULL,
  `cpf_cnpj` varchar(14) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `enderecoid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`iduser`, `nome`, `funcao`, `telefone`, `senha`, `cpf_cnpj`, `email`, `enderecoid`) VALUES
(1, 'Cassiano L. Trezzi', 'Sistema', '55996666926', 'trezzi11', '02952608075', 'cassiano.trezzi@gmail.com', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda_pedido`
--

CREATE TABLE `venda_pedido` (
  `idvendap` int(11) NOT NULL,
  `observacoes` varchar(40) DEFAULT NULL,
  `acompanhamento` varchar(20) DEFAULT NULL,
  `vtotal` float(7,4) DEFAULT NULL,
  `userclienteid` int(11) DEFAULT NULL,
  `uservendedorid` int(11) DEFAULT NULL,
  `enderecoid` int(11) DEFAULT NULL,
  `vpid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda_produto`
--

CREATE TABLE `venda_produto` (
  `idvp` int(11) NOT NULL,
  `observacoes` varchar(40) DEFAULT NULL,
  `qtde_unidade` int(7) DEFAULT NULL,
  `prodid` int(11) DEFAULT NULL,
  `vendapid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcat`);

--
-- Índices para tabela `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`idcidade`),
  ADD KEY `estadoid` (`estadoid`);

--
-- Índices para tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`idenderec`),
  ADD KEY `cidadeid` (`cidadeid`);

--
-- Índices para tabela `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idestado`);

--
-- Índices para tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`idpgto`),
  ADD KEY `vendapid` (`vendapid`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idprod`),
  ADD KEY `categoriaid` (`categoriaid`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`iduser`),
  ADD KEY `enderecoid` (`enderecoid`);

--
-- Índices para tabela `venda_pedido`
--
ALTER TABLE `venda_pedido`
  ADD PRIMARY KEY (`idvendap`),
  ADD KEY `userclienteid` (`userclienteid`),
  ADD KEY `uservendedorid` (`uservendedorid`),
  ADD KEY `enderecoid` (`enderecoid`),
  ADD KEY `vpid` (`vpid`);

--
-- Índices para tabela `venda_produto`
--
ALTER TABLE `venda_produto`
  ADD PRIMARY KEY (`idvp`),
  ADD KEY `prodid` (`prodid`),
  ADD KEY `vendapid` (`vendapid`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `cidade`
--
ALTER TABLE `cidade`
  MODIFY `idcidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `idenderec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `estado`
--
ALTER TABLE `estado`
  MODIFY `idestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `idpgto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `idprod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `venda_pedido`
--
ALTER TABLE `venda_pedido`
  MODIFY `idvendap` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `venda_produto`
--
ALTER TABLE `venda_produto`
  MODIFY `idvp` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cidade`
--
ALTER TABLE `cidade`
  ADD CONSTRAINT `cidade_ibfk_1` FOREIGN KEY (`estadoid`) REFERENCES `estado` (`idestado`);

--
-- Limitadores para a tabela `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`cidadeid`) REFERENCES `cidade` (`idcidade`);

--
-- Limitadores para a tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`vendapid`) REFERENCES `venda_pedido` (`idvendap`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`categoriaid`) REFERENCES `categoria` (`idcat`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`enderecoid`) REFERENCES `endereco` (`idenderec`);

--
-- Limitadores para a tabela `venda_pedido`
--
ALTER TABLE `venda_pedido`
  ADD CONSTRAINT `venda_pedido_ibfk_1` FOREIGN KEY (`userclienteid`) REFERENCES `usuario` (`iduser`),
  ADD CONSTRAINT `venda_pedido_ibfk_2` FOREIGN KEY (`uservendedorid`) REFERENCES `usuario` (`iduser`),
  ADD CONSTRAINT `venda_pedido_ibfk_3` FOREIGN KEY (`enderecoid`) REFERENCES `endereco` (`idenderec`),
  ADD CONSTRAINT `venda_pedido_ibfk_4` FOREIGN KEY (`vpid`) REFERENCES `venda_produto` (`idvp`);

--
-- Limitadores para a tabela `venda_produto`
--
ALTER TABLE `venda_produto`
  ADD CONSTRAINT `venda_produto_ibfk_1` FOREIGN KEY (`prodid`) REFERENCES `produto` (`idprod`),
  ADD CONSTRAINT `venda_produto_ibfk_2` FOREIGN KEY (`vendapid`) REFERENCES `venda_pedido` (`idvendap`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
