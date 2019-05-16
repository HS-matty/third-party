<?php
/* $Id: portuguese.inc.php,v 1.97 2002/02/15 13:06:55 loic1 Exp $ */

$charset = 'iso-8859-1';
$text_dir = 'ltr';
$left_font_family = 'sans-serif';
$right_font_family = 'sans-serif';
$number_thousands_separator = ',';
$number_decimal_separator = '.';
$byteUnits = array('Bytes', 'KB', 'MB', 'GB');

$day_of_week = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
$month = array('Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
// See http://www.php.net/manual/en/function.strftime.php to define the
// variable below
$datefmt = '%d-%B-%Y �s %H:%M';

$strAPrimaryKey = 'Uma chave prim�ria foi adicionada a %s';
$strAccessDenied = 'Acesso Negado';
$strAction = 'Ac��es';
$strAddDeleteColumn = 'Add/Delete Field Columns'; //to translate (tbl_qbe.php)
$strAddDeleteRow = 'Add/Delete Criteria Row'; //to translate (tbl_qbe.php)
$strAddNewField = 'Adiciona novo campo';
$strAddPriv = 'Acrescenta um novo Privil�gio';
$strAddPrivMessage = 'Acrescentou um novo privil�gio.';
$strAddSearchConditions = 'Condi��o de Pesquisa (Complemento da clausula "where"):';
$strAddToIndex = 'Add to index &nbsp;%s&nbsp;column(s)';
$strAddUser = 'Acrescenta um utilizador';
$strAddUserMessage = 'Acrescentou um novo utilizador.';
$strAffectedRows = 'Affected rows:';
$strAfter = 'Depois %s';
$strAfterInsertBack = 'Return';
$strAfterInsertNewInsert = 'Insert a new record';
$strAll = 'Todas';
$strAlterOrderBy = 'Alterar a ordem da tabela por';
$strAnIndex = 'Um ind�ce foi adicionado a %s';
$strAnalyzeTable = 'Analizar tabela';
$strAnd = 'E'; // (tbl_qbe.php)
$strAny = 'Todos';
$strAnyColumn = 'Qualquer coluna';
$strAnyDatabase = 'Qualquer base de dados';
$strAnyHost = 'Qualquer m�quina';
$strAnyTable = 'Qualquer tabela';
$strAnyUser = 'Qualquer utilizador';
$strAscending = 'Ascendente'; // (tbl_qbe.php)
$strAtBeginningOfTable = 'No In�cio da Tabela';
$strAtEndOfTable = 'No Fim da Tabela';
$strAttr = 'Atributos';

$strBack = 'Voltar';
$strBinary = ' Bin�rio ';
$strBinaryDoNotEdit = ' Bin�rio - n�o editar ';
$strBookmarkDeleted = 'The bookmark has been deleted.';
$strBookmarkLabel = 'Label'; //to translate
$strBookmarkQuery = 'Bookmarked SQL-query'; //to translate
$strBookmarkThis = 'Bookmark this SQL-query'; //to translate
$strBookmarkView = 'View only'; //to translate
$strBrowse = 'Visualiza';
$strBzip = '"bzipped"';  //to translate

$strCantLoadMySQL = 'n�o foi poss�vel carregar a extens�o MySQL,<br />por favor verifique a configura��o do PHP.';
$strCantRenameIdxToPrimary = 'Can\'t rename index to PRIMARY!';
$strCardinality = 'Cardinality';
$strCarriage = 'Fim de linha: \\r';
$strChange = 'Muda';
$strCheckAll = 'Todos';
$strCheckDbPriv = 'Visualiza os Privil�gios da Base de Dados';
$strCheckTable = 'Verificar tabela';
$strColumn = 'Campo';
$strColumnNames = 'Nome dos Campos';
$strCompleteInserts = 'Instruc��es de inser��o completas';
$strConfirm = 'Do you really want to do it?'; //to translate
$strCookiesRequired = 'O mecanoismo de "Cookies" tem de estar ligado a partir deste ponto.';
$strCopyTable = 'Copia tabela para (base-de-dados<b>.</b>tabela):';
$strCopyTableOK = 'Tabela %s copiada para %s.';
$strCreate = 'Criar';
$strCreateIndex = 'Criar um �ndice com&nbsp;%s&nbsp;coluna(s)';
$strCreateIndexTopic = 'Criar um novo �ndice';
$strCreateNewDatabase = 'Criar nova base de dados';
$strCreateNewTable = 'Criar nova tabela na base de dados ';
$strCriteria = 'Criteria'; // to translate (tbl_qbe.php)

$strData = 'Dados';
$strDataOnly = 'Apenas dados';
$strDatabase = 'Base de Dados ';
$strDatabaseHasBeenDropped = 'A base de dados %s foi eliminada.';
$strDatabases = 'Base de Dados';
$strDatabasesStats = 'Estat�sticas das bases de dados';
$strDefault = 'Defeito';
$strDelete = 'Remove';
$strDeleteFailed = 'Deleted Failed!'; //to translate
$strDeleteUserMessage = 'Apagou o utilizador %s.';
$strDeleted = 'Registo eliminado';
$strDeletedRows = 'Deleted rows:';
$strDescending = 'Descendente'; // (tbl_qbe.php)
$strDisplay = 'Mostra';
$strDisplayOrder = 'Ordem de visualiza��o:';
$strDoAQuery = 'Fa�a uma "query by example" (wildcard: "%")';
$strDoYouReally = 'Confirma : ';
$strDocu = 'Documenta��o';
$strDrop = 'Elimina';
$strDropDB = 'Elimina a base de dados: ';
$strDropTable = 'Elimina tabela';
$strDumpingData = 'Extraindo dados da tabela';
$strDynamic = 'din�mico';

$strEdit = 'Edita';
$strEditPrivileges = 'Alterar Privilegios';
$strEffective = 'Em uso';
$strEmpty = 'Limpa';
$strEmptyResultSet = 'MySQL retornou um set vazio (ex. zero regs).';
$strEnd = 'Fim';
$strEnglishPrivileges = ' Nota: os nomes dos privil�gios do MySQL s�o em Ingl�s ';
$strError = 'Erro';
$strExtendedInserts = 'Instruc��es de inser��o m�ltiplas';
$strExtra = 'Extra'; // written the same in portuguese

$strField = 'Campo';
$strFieldHasBeenDropped = 'O campo %s foi eliminado';
$strFields = 'Qtd Campos';
$strFieldsEmpty = ' The field count is empty! ';  //to translate
$strFieldsEnclosedBy = 'Campos delimitados por';
$strFieldsEscapedBy = 'Campos marcados por'; // to refine translation
$strFieldsTerminatedBy = 'Campos terminados por';
$strFixed = 'fixo';
$strFlushTable = 'Fecha a tabela ("FLUSH")';
$strFormEmpty = 'Missing value in the form !';
$strFormat = 'Formato';
$strFullText = 'Full Texts'; //to translate
$strFunction = 'Fun��es';

$strGenTime = 'Data de Cria��o';
$strGo = 'Executa';
$strGrants = 'Autoriza��es';
$strGzip = '"gzipped"';  //to translate

$strHasBeenAltered = 'foi alterado.';
$strHasBeenCreated = 'foi criado.';
$strHome = 'In�cio';
$strHomepageOfficial = 'P�gina Oficial do phpMyAdmin';
$strHomepageSourceforge = 'Sourceforge phpMyAdmin Download Page'; //to translate
$strHost = 'M�quina';
$strHostEmpty = 'O nome da m�quina est� vazio!';

$strIdxFulltext = 'Fulltext';  //to translate
$strIfYouWish = 'Para carregar apenas algumas colunas da tabela, fa�a uma lista separada por virgula.';
$strIgnore = 'Ignora';
$strInUse = 'in use'; //to translate
$strIndex = '�ndice';
$strIndexHasBeenDropped = 'O �ndice %s foi eliminado';
$strIndexName = 'Nome do �ndice&nbsp;:';
$strIndexType = 'Tipo de �ndice&nbsp;:';
$strIndexes = '�ndices';
$strInsert = 'Insere';
$strInsertAsNewRow = 'Insere como novo registo';
$strInsertedRows = 'Registos inseridos :';
$strInsertNewRow = 'Insere novo registo';
$strInsertTextfiles = 'Insere arquivo texto na tabela';
$strInstructions = 'Instructions'; //to translate
$strInvalidName = '"%s" � uma palavra reservada, n�o pode usar como nome de base de dados/tabela/campo.';

$strKeepPass = 'Sem alterar senha';
$strKeyname = 'Keyname';
$strKill = 'Termina';

$strLength = 'Comprimento';
$strLengthSet = 'Tamanho/Set*';
$strLimitNumRows = 'registos por p�gina';
$strLineFeed = 'Mudan�a de linha: \\n';
$strLines = 'Linhas';
$strLinesTerminatedBy = 'Linhas terminadas por';
$strLocationTextfile = 'Localiza��o do arquivo de texto';
$strLogPassword = 'Senha&nbsp;:';
$strLogUsername = 'Utilizador&nbsp;:';
$strLogin = 'Entrada';
$strLogout = 'Log out';

$strModifications = 'Modifica��es foram salvas';
$strModify = 'Modifica'; // (tbl_qbe.php)
$strModifyIndexTopic = 'Modificar um �ndice';
$strMoveTable = 'Move tabela para (base de dados<b>.</b>tabela):';
$strMoveTableOK = 'A tabela %s foi movida para %s.';
$strMySQLReloaded = 'MySQL reiniciado.';
$strMySQLSaid = 'Mensagens do MySQL : ';
$strMySQLServerProcess = 'MySQL %pma_s1% correndo em %pma_s2% como %pma_s3%';
$strMySQLShowProcess = 'Mostra os Processos';
$strMySQLShowStatus = 'Mostra informa��o do estado do MySql';
$strMySQLShowVars = 'Mostra as vari�veis de sistema do MySQL';

$strName = 'Nome';
$strNbRecords = 'n. de registos';
$strNext = 'Pr�ximo';
$strNo = 'N�o';
$strNoDatabases = 'No databases';
$strNoDropDatabases = 'Os comandos "DROP DATABASE" est�o inibidos.';
$strNoFrames = 'phpMyAdmin is more friendly with a <b>frames-capable</b> browser.';
$strNoIndex = 'Nenhum ind�ce definido!';
$strNoIndexPartsDefined = 'No index parts defined!';
$strNoModification = 'No change'; // To translate
$strNoPassword = 'Sem Senha';
$strNoPrivileges = 'Sem Privil�gios';
$strNoQuery = 'No SQL query!';  //to translate
$strNoRights = 'You don\'t have enough rights to be here right now!'; //to translate
$strNoTablesFound = 'Nenhuma tabela encontrada na base de dados';
$strNoUsersFound = 'No user(s) found.'; //to translate
$strNone = 'Nenhum';
$strNotNumber = 'Isto n�o � um n�mero!';
$strNotValidNumber = ' n�o � um n�mero de registo v�lido!';
$strNull = 'Nulo';

$strOftenQuotation = 'Normalmente aspas. OPTIONALLY significa que apenas os campos "char" e "varchar" s�o delimitados pelo caractere delimitador.';
$strOptimizeTable = 'Optimizar tabela';
$strOptionalControls = 'Opcional. Comanda o modo de escrita e leitura dos caracteres especiais.';
$strOptionally = 'OPTIONALLY';
$strOr = 'Ou';
$strOverhead = 'Extra';

$strPHPVersion = 'vers�o do PHP';
$strPartialText = 'Partial Texts';//to translate
$strPassword = 'Senha';
$strPasswordEmpty = 'The password is empty!'; //to translate
$strPasswordNotSame = 'The passwords aren\'t the same!'; //to translate
$strPmaDocumentation = 'Documenta��o do phpMyAdmin';
$strPos1 = 'Inicio';
$strPrevious = 'Anterior';
$strPrimary = 'Prim�ria';
$strPrimaryKey = 'Chave Prim�ria';
$strPrimaryKeyHasBeenDropped = 'A chave prim�ria foi eliminada';
$strPrimaryKeyName = 'O nome da chave prim�ria tem de ser... PRIMARY!';
$strPrimaryKeyName = 'O nome da chave prim�ria tem de ser... PRIMARY!';
$strPrimaryKeyWarning = '("PRIMARY" <b>tem</b> de ser o nome de e <b>apenas de</b> uma chave prim�ria!)';
$strPrintView = 'Vista de impress�o';
$strPrivileges = 'Privil�gios';
$strProperties = 'Propriedades';

$strQBE = 'Pesquisa por formul�rio';
$strQBEDel = 'Elim.'; // Elimina (used in tbl_qbe.php)
$strQBEIns = 'Ins.';  // Insere (used in tbl_qbe.php)
$strQueryOnDb = 'Comando SQL na base de dados <b>%s</b>:';

$strReType = 'Confirma';
$strRecords = 'Registos';
$strReloadFailed = 'Reinicializa��o do MySQL falhou.';
$strReloadMySQL = 'Reinicializa o MySQL';
$strRememberReload = 'Lembre-se de reinicializar o servidor.';
$strRenameTable = 'Renomeia a tabela para ';
$strRenameTableOK = 'Tabela %s renomeada para %s';
$strRepairTable = 'Reparar tabela';
$strReplace = 'Substituir';
$strReplaceTable = 'Substituir os dados da tabela pelos do arquivo';
$strReset = 'Limpa';
$strRevoke = 'Anula';
$strRevokeGrant = 'Anula Autoriza��o';
$strRevokeGrantMessage = 'Anulou a autoriza��o para %s';
$strRevokeMessage = 'Anulou os privil�gios para %s';
$strRevokePriv = 'Anula Privil�gios';
$strRowLength = 'Comprim. dos reg.';
$strRowSize = ' Tamanho dos reg.';
$strRows = 'Registos';
$strRowsFrom = 'registos come�ando em';
$strRowsModeHorizontal = 'horizontal';  // written the same in portuguese!
$strRowsModeOptions = 'in %s mode and repeat headers after %s cells';  //to translate
$strRowsModeVertical = 'vertical';  // written the same in portuguese!
$strRowsStatistic = 'Estat�sticas dos registos';
$strRunQuery = 'Executa Comando SQL'; // (tbl_qbe.php)
$strRunSQLQuery = 'Executa comando(s) SQL na base de dados %s';
$strRunning = 'a correr em %s';

$strSQLQuery = 'Comando SQL';
$strSave = 'Guarda';
$strSelect = 'Selecciona';
$strSelectADb = 'Por favor seleccione uma base de dados';
$strSelectAll = 'Selecciona Todas';
$strSelectFields = 'Seleccione os campos (no m�nimo 1)';
$strSelectNumRows = 'in query'; //to translate
$strSend = 'envia';
$strSequence = 'Seq.'; // Sequence => Sequencia, same abreviation
$strServerChoice = 'Server Choice';//to translate
$strServerVersion = 'Vers�o do servidor';
$strSetEnumVal = 'Se o tipo de campo � "enum" ou "set", por favor introduza os valores no seguinte formato: \'a\',\'b\',\'c\'...<br />Se precisar de colocar uma barra invertida ("\") ou um ap�strofe ("\'") entre esses valores, coloque uma barra invertida antes (por exemplo \'\\\\xyz\' ou \'a\\\'b\').';
$strShow = 'Mostra';
$strShowAll = 'Show all'; // to translate
$strShowCols = 'Mostra Colunas';
$strShowPHPInfo = 'Mostra informa��o do PHP';
$strShowTables = 'Mostra tabelas';
$strShowThisQuery = ' Mostrar de novo aqui este comando ';
$strShowingRecords = 'Mostrando registos ';
$strSingly = '(singly)'; //to translate
$strSize = 'Tamanho';
$strSort = 'Ordena��o'; // (tbl_qbe.php)
$strSpaceUsage = 'Espa�o ocupado';
$strStartingRecord = 'Registo inicial';
$strStatement = 'Itens';
$strStrucCSV = 'Dados CSV';
$strStrucData = 'Estrutura e dados';
$strStrucDrop = 'Adiciona \'drop table\'';
$strStrucExcelCSV = 'dados CSV para Ms Excel';
$strStrucOnly = 'S�mente estrutura';
$strSubmit = 'Submete';
$strSuccess = 'O seu comando SQL foi executado com sucesso';
$strSum = 'Soma';

$strTable = 'tabela ';
$strTableComments = 'Coment�rios da tabela';
$strTableEmpty = 'O nome da tabela est� vazio!';
$strTableHasBeenDropped = 'A tabela %s foi eliminada';
$strTableHasBeenEmptied = 'A tabela %s foi limpa';
$strTableHasBeenFlushed = 'A tabela %s foi fechada';
$strTableMaintenance = 'Manuten��o da tabela';
$strTableStructure = 'Estrutura da tabela';
$strTableType = 'Tipo de tabela';
$strTables = '%s tabela(s)';
$strTextAreaLength = ' Devido ao seu tamanho,<br /> este campo pode n�o ser edit�vel ';
$strTheContent = 'O conte�do do seu arquivo foi inserido';
$strTheContents = 'O conte�do do arquivo substituiu o conte�do da tabela que tinha a mesma chave prim�ria ou �nica';
$strTheTerminator = 'Terminador de campos.';
$strTotal = 'total';
$strType = 'Tipo';

$strUncheckAll = 'Nenhum';
$strUnique = '�nico';
$strUnselectAll = 'Limpa Todas as Selec��es';
$strUpdatePrivMessage = 'Actualizou os privil�gios de %s.';
$strUpdateProfile = 'Actualiza o prefil:';
$strUpdateProfileMessage = 'O prefil foi actualizado.';
$strUpdateQuery = 'Actualiza Comando SQL'; // (tbl_qbe.php)
$strUsage = 'Utiliza��o';
$strUseBackquotes = 'Usar apostrofes com os nomes das tabelas e campos';
$strUseTables = 'Usar Tabelas'; // (tbl_qbe.php)
$strUser = 'Utilizador';
$strUserEmpty = 'O nome do utilizador est� vazio!';
$strUserName = 'Nome do Utilizador';
$strUsers = 'Utilizadores';

$strValue = 'Valor';
$strViewDump = 'Ver o esquema da tabela';
$strViewDumpDB = 'Ver o esquema da base de dados';

$strWelcome = 'Bemvindo ao %s';
$strWithChecked = 'Com os selec�ionados:';
$strWrongUser = 'Utilizador ou Senha errada. Acesso Negado.';

$strYes = 'Sim';

$strZip = '"zipped"';  //to translate

// To translate
?>
