-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Maio-2024 às 20:56
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargo`
--

CREATE TABLE `cargo` (
  `CodCargo` int(11) NOT NULL,
  `Cargo` varchar(50) DEFAULT NULL,
  `Funcao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cargo`
--

INSERT INTO `cargo` (`CodCargo`, `Cargo`, `Funcao`) VALUES
(1, 'ADMINISTRADOR', 'NÃO APROVADOR'),
(2, 'GERENTE', 'APROVADOR'),
(3, 'ANALISTA', 'NÃO APROVADOR'),
(4, 'ASSISTENTE', 'NÃO APROVADOR'),
(5, 'ALMOXARIFE', 'NÃO APROVADOR'),
(6, 'OPERADOR', 'NÃO APROVADOR');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE `conta` (
  `Email` varchar(100) DEFAULT NULL,
  `Senha` varchar(100) DEFAULT NULL,
  `Matricula` int(11) NOT NULL,
  `contaStatus` varchar(50) DEFAULT NULL,
  `FK_DEPARTAMENTO_CodSetor` int(11) DEFAULT NULL,
  `FK_CARGO_CodCargo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `conta`
--

INSERT INTO `conta` (`Email`, `Senha`, `Matricula`, `contaStatus`, `FK_DEPARTAMENTO_CodSetor`, `FK_CARGO_CodCargo`) VALUES
('adm@adm.com', 'adm', 2024001, 'ATIVO', 2, 1),
('gerente@ti.com', 'ti', 2024002, 'ATIVO', 2, 2),
('fun@ti.com', 'ti', 2024003, 'ATIVO', 2, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamento`
--

CREATE TABLE `departamento` (
  `CodSetor` int(11) NOT NULL,
  `Setor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `departamento`
--

INSERT INTO `departamento` (`CodSetor`, `Setor`) VALUES
(1, 'ALMOXARIFADO'),
(2, 'T.I'),
(3, 'RH'),
(4, 'PRODUÇÃO'),
(5, 'FINANCEIRO'),
(6, 'LIMPEZA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE `item` (
  `ID_Item` int(11) NOT NULL,
  `Quantidade` int(11) DEFAULT NULL,
  `NomeItem` varchar(100) DEFAULT NULL,
  `DataRecebimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`ID_Item`, `Quantidade`, `NomeItem`, `DataRecebimento`) VALUES
(1, 100, 'Caneta Azul', '2024-05-25'),
(2, 100, 'Caneta Preta', '2024-05-30'),
(3, 100, 'Caneta Vermelha', '2024-05-30'),
(4, 100, 'Pacote Folha A4', '2024-05-30'),
(5, 100, 'Borracha', '2024-05-30'),
(6, 100, 'Lapis', '2024-05-30'),
(7, 50, 'Servo-Motor Nema 17', '2024-05-30'),
(8, 25, 'Sensor de Movimento', '2024-05-30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisicao`
--

CREATE TABLE `requisicao` (
  `QuantidadeItem` int(11) DEFAULT NULL,
  `CargoFuncionario` varchar(100) DEFAULT NULL,
  `ID_Solicitacao` int(11) NOT NULL,
  `NomeItem` varchar(100) DEFAULT NULL,
  `SetorFuncionario` varchar(100) DEFAULT NULL,
  `StatusSolicitacao` varchar(50) DEFAULT NULL,
  `DataSolicitacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `FK_ITEM_ID_Item` int(11) DEFAULT NULL,
  `FK_CONTA_Matricula` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `requisicao`
--

INSERT INTO `requisicao` (`QuantidadeItem`, `CargoFuncionario`, `ID_Solicitacao`, `NomeItem`, `SetorFuncionario`, `StatusSolicitacao`, `DataSolicitacao`, `FK_ITEM_ID_Item`, `FK_CONTA_Matricula`) VALUES
(1, 'ANALISTA', 1, 'Caneta Azul', 'T.I', 'ABERTA', '2024-05-30 03:00:00', 1, 2024003);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`CodCargo`);

--
-- Índices para tabela `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`Matricula`),
  ADD KEY `FK_CONTA_2` (`FK_DEPARTAMENTO_CodSetor`),
  ADD KEY `FK_CONTA_3` (`FK_CARGO_CodCargo`);

--
-- Índices para tabela `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`CodSetor`);

--
-- Índices para tabela `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ID_Item`);

--
-- Índices para tabela `requisicao`
--
ALTER TABLE `requisicao`
  ADD PRIMARY KEY (`ID_Solicitacao`),
  ADD KEY `FK_REQUISICAO_2` (`FK_ITEM_ID_Item`),
  ADD KEY `FK_REQUISICAO_3` (`FK_CONTA_Matricula`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cargo`
--
ALTER TABLE `cargo`
  MODIFY `CodCargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `departamento`
--
ALTER TABLE `departamento`
  MODIFY `CodSetor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `item`
--
ALTER TABLE `item`
  MODIFY `ID_Item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `requisicao`
--
ALTER TABLE `requisicao`
  MODIFY `ID_Solicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `conta`
--
ALTER TABLE `conta`
  ADD CONSTRAINT `FK_CONTA_2` FOREIGN KEY (`FK_DEPARTAMENTO_CodSetor`) REFERENCES `departamento` (`CodSetor`),
  ADD CONSTRAINT `FK_CONTA_3` FOREIGN KEY (`FK_CARGO_CodCargo`) REFERENCES `cargo` (`CodCargo`);

--
-- Limitadores para a tabela `requisicao`
--
ALTER TABLE `requisicao`
  ADD CONSTRAINT `FK_REQUISICAO_2` FOREIGN KEY (`FK_ITEM_ID_Item`) REFERENCES `item` (`ID_Item`),
  ADD CONSTRAINT `FK_REQUISICAO_3` FOREIGN KEY (`FK_CONTA_Matricula`) REFERENCES `conta` (`Matricula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
