-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/05/2024 às 17:06
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_tcc`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargo`
--

CREATE TABLE `cargo` (
  `CodCargo` int(11) NOT NULL,
  `Cargo` varchar(50) DEFAULT NULL,
  `Funcao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cargo`
--

INSERT INTO `cargo` (`CodCargo`, `Cargo`, `Funcao`) VALUES
(1, 'Gerente', 'APROVADOR'),
(2, 'Analista', 'NÃO APROVADOR'),
(3, 'Assistente', 'NÃO APROVADOR');

-- --------------------------------------------------------

--
-- Estrutura para tabela `conta`
--

CREATE TABLE `conta` (
  `Email` varchar(100) DEFAULT NULL,
  `Senha` varchar(100) DEFAULT NULL,
  `Matricula` int(11) NOT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `FK_DEPARTAMENTO_CodSetor` int(11) DEFAULT NULL,
  `FK_CARGO_CodCargo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `departamento`
--

CREATE TABLE `departamento` (
  `CodSetor` int(11) NOT NULL,
  `Setor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `departamento`
--

INSERT INTO `departamento` (`CodSetor`, `Setor`) VALUES
(1, 'Recursos Humanos'),
(2, 'Financeiro'),
(3, 'TI'),
(4, 'Logística');

-- --------------------------------------------------------

--
-- Estrutura para tabela `item`
--

CREATE TABLE `item` (
  `ID_Item` int(11) NOT NULL,
  `Quantidade` int(11) DEFAULT NULL,
  `NomeItem` varchar(100) DEFAULT NULL,
  `DataRecebimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `item`
--

INSERT INTO `item` (`ID_Item`, `Quantidade`, `NomeItem`, `DataRecebimento`) VALUES
(1, 100, 'Caneta azul', '2024-05-13'),
(2, 150, 'Caneta preta', '2024-05-13'),
(3, 80, 'Caneta vermelha', '2024-05-13'),
(4, 500, 'Parafuso', '2024-05-13'),
(5, 20, 'Pacote de folha A4', '2024-05-13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `requisicao`
--

CREATE TABLE `requisicao` (
  `QuantidadeItem` int(11) DEFAULT NULL,
  `CargoFuncionario` varchar(100) DEFAULT NULL,
  `ID_Solicitacao` int(11) NOT NULL,
  `NomeItem` varchar(100) DEFAULT NULL,
  `SetorFuncionario` varchar(100) DEFAULT NULL,
  `StatusSolicitacao` varchar(50) DEFAULT NULL,
  `DataSolicitacao` date DEFAULT NULL,
  `FK_ITEM_ID_Item` int(11) DEFAULT NULL,
  `FK_CONTA_Matricula` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`CodCargo`);

--
-- Índices de tabela `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`Matricula`),
  ADD KEY `FK_CONTA_2` (`FK_DEPARTAMENTO_CodSetor`),
  ADD KEY `FK_CONTA_3` (`FK_CARGO_CodCargo`);

--
-- Índices de tabela `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`CodSetor`);

--
-- Índices de tabela `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ID_Item`);

--
-- Índices de tabela `requisicao`
--
ALTER TABLE `requisicao`
  ADD PRIMARY KEY (`ID_Solicitacao`),
  ADD KEY `FK_REQUISICAO_2` (`FK_ITEM_ID_Item`),
  ADD KEY `FK_REQUISICAO_3` (`FK_CONTA_Matricula`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cargo`
--
ALTER TABLE `cargo`
  MODIFY `CodCargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `departamento`
--
ALTER TABLE `departamento`
  MODIFY `CodSetor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `item`
--
ALTER TABLE `item`
  MODIFY `ID_Item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `requisicao`
--
ALTER TABLE `requisicao`
  MODIFY `ID_Solicitacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `conta`
--
ALTER TABLE `conta`
  ADD CONSTRAINT `FK_CONTA_2` FOREIGN KEY (`FK_DEPARTAMENTO_CodSetor`) REFERENCES `departamento` (`CodSetor`),
  ADD CONSTRAINT `FK_CONTA_3` FOREIGN KEY (`FK_CARGO_CodCargo`) REFERENCES `cargo` (`CodCargo`);

--
-- Restrições para tabelas `requisicao`
--
ALTER TABLE `requisicao`
  ADD CONSTRAINT `FK_REQUISICAO_2` FOREIGN KEY (`FK_ITEM_ID_Item`) REFERENCES `item` (`ID_Item`),
  ADD CONSTRAINT `FK_REQUISICAO_3` FOREIGN KEY (`FK_CONTA_Matricula`) REFERENCES `conta` (`Matricula`);
COMMIT;

