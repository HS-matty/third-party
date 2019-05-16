<?php
/* $Id: russian-win1251.inc.php,v 1.98 2002/01/26 19:45:53 loic1 Exp $ */

$charset = 'windows-1251';
$text_dir = 'ltr';
$left_font_family = 'sans-serif';
$right_font_family = 'sans-serif';
$number_thousands_separator = ',';
$number_decimal_separator = '.';
$byteUnits = array('����', '��', '��', '��');

$day_of_week = array('��', '��', '��', '��', '��', '��', '��');
$month = array('���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���');
// See http://www.php.net/manual/en/function.strftime.php to define the
// variable below
$datefmt = '%B %d %Y �., %H:%M';


$strAccessDenied = '� ������� ��������';
$strAction = '��������';
$strAddDeleteColumn = '��������/������� ������� ��������';
$strAddDeleteRow = '��������/������� ��� ��������';
$strAddNewField = '�������� ����� ����';
$strAddPriv = '�������� ����� ����������';
$strAddPrivMessage = '���� ��������� ����� ����������';
$strAddSearchConditions = '�������� ������� ������ (���� ��� ������� "where"):';
$strAddToIndex = '�������� � �������&nbsp;%s&nbsp;��������(�)';
$strAddUser = '�������� ������ ������������';
$strAddUserMessage = '���� �������� ����� ������������.';
$strAffectedRows = '���������� ����:';
$strAfter = '����� %s';
$strAfterInsertBack = '�������';
$strAfterInsertNewInsert = '�������� ����� ������';
$strAll = '���';
$strAlterOrderBy = '�������� ������� �������';
$strAnalyzeTable = '������ �������';
$strAnd = '�';
$strAnIndex = '��� �������� ������ ��� %s';
$strAny = '�����';
$strAnyColumn = '����� �������';
$strAnyDatabase = '����� ���� ������';
$strAnyHost = '����� ����';
$strAnyTable = '����� �������';
$strAnyUser = '����� ������������';
$strAPrimaryKey = '��� �������� ��������� ���� � %s';
$strAscending = '����������';
$strAtBeginningOfTable = '� ������ �������';
$strAtEndOfTable = '� ����� �������';
$strAttr = '��������';

$strBack = '�����';
$strBinary = ' �������� ';
$strBinaryDoNotEdit = ' �������� ������ - �� ������������� ';
$strBookmarkDeleted = '�������� ���� �������.';
$strBookmarkLabel = '�����';
$strBookmarkQuery = '�������� �� SQL-������';
$strBookmarkThis = '�������� �� ������ SQL-������';
$strBookmarkView = '������ ��������';
$strBrowse = '�����';
$strBzip = '�������� � "bzip"';

$strCantLoadMySQL = '���������� MySQL �� ����������,<br />��������� ������������ PHP.';
$strCantRenameIdxToPrimary = '������������� ������������� ������ � PRIMARY!';
$strCarriage = '������� �������: \\r';
$strCardinality = '���������� ���������';
$strChange = '��������';
$strCheckAll = '�������� ���';
$strCheckDbPriv = '��������� ���������� ���� ������';
$strCheckTable = '��������� �������';
$strColumn = '�������';
$strColumnNames = '�������� �������';
$strCompleteInserts = '������ �������';
$strConfirm = '�� ������������� ������ ������� ���?';
$strCookiesRequired = 'Cookies ������ ���� �������� ����� ����� �����.';
$strCopyTable = '����������� ������� � (���� ������<b>.</b>�������):';
$strCopyTableOK = '������� %s ���� ����������� � %s.';
$strCreate = '�������';
$strCreateNewDatabase = '������� ����� ��';
$strCreateNewTable = '������� ����� ������� � �� ';
$strCreateIndex = '������� ������ ��&nbsp;%s&nbsp;��������';
$strCreateIndexTopic = '������� ����� ������';
$strCriteria = '��������';

$strData = '������';
$strDatabase = '�� ';
$strDatabaseHasBeenDropped = '���� ������ %s ���� �������.';
$strDatabases = '���� ������';
$strDatabasesStats = '���������� ��� ������';
$strDataOnly = '������ ������';
$strDefault = '�� ���������';
$strDelete = '�������';
$strDeleted = '��� ��� ������';
$strDeletedRows = '��������� ���� ���� �������:';
$strDeleteFailed = '��������� ��������!';
$strDeleteUserMessage = '��� ������ ������������ %s.';
$strDescending = '����������';
$strDisplay = '��������';
$strDisplayOrder = '������� ���������:';
$strDoAQuery = '��������� "������ �� �������" (������ ������������: "%")';
$strDocu = '������������';
$strDoYouReally = '�� ������������� ������� ';
$strDrop = '����������';
$strDropDB = '���������� �� ';
$strDropTable = '������� �������';
$strDumpingData = '���� ������ �������';
$strDynamic = '������������';

$strEdit = '������';
$strEditPrivileges = '�������������� ����������';
$strEffective = '�������������';
$strEmpty = '��������';
$strEmptyResultSet = 'MySQL ������� ������ ��������� (�.�. ���� �����).';
$strEnd = '�����';
$strEnglishPrivileges = ' ����������: ���������� MySQL �������� �� ��������� ';
$strError = '������';
$strExtendedInserts = '����������� �������';
$strExtra = '�������������';

$strField = '����';
$strFieldHasBeenDropped = '���� %s ���� �������';
$strFields = '����';
$strFieldsEmpty = ' ������ ������� �����! ';
$strFieldsEnclosedBy = '���� ��������� �';
$strFieldsEscapedBy = '���� ������������';
$strFieldsTerminatedBy = '���� ���������';
$strFixed = '�������������';
$strFlushTable = '�������� ��� ������� ("FLUSH")';
$strFormat = '������';
$strFormEmpty = '��������� �������� ��� �����!';
$strFullText = '������ ������';
$strFunction = '�������';

$strGenTime = '����� ��������';
$strGo = '�����';
$strGrants = '�����';
$strGzip = '�������� � "gzip"';

$strHasBeenAltered = '���� ��������.';
$strHasBeenCreated = '���� �������.';
$strHome = '� ������';
$strHomepageOfficial = '����������� �������� phpMyAdmin';
$strHomepageSourceforge = '�������� phpMyAdmin �� Sourceforge';
$strHost = '����';
$strHostEmpty = '������ ��� �����!';

$strIdxFulltext = '���������';
$strIfYouWish = '���� �� ������� ��������� ������ ��������� ������� �������, ������� ����������� �������� ������ �����.';
$strIgnore = '������������';
$strIndex = '������';
$strIndexes = '�������';
$strIndexHasBeenDropped = '������ %s ��� ������';
$strIndexName = '��� �������&nbsp;:';
$strIndexType = '��� �������&nbsp;:';
$strInsert = '��������';
$strInsertAsNewRow = '�������� ����� ���';
$strInsertedRows = '���������� ����:';
$strInsertNewRow = '�������� ����� ���';
$strInsertTextfiles = '�������� ��������� ����� � �������';
$strInstructions = '����������';
$strInUse = '������������';
$strInvalidName = '"%s" - �������� ����������������� ������, �� �� ������ ������������ ��� � �������� ����� ���� ������/�������/����.';

$strKeepPass = '�� ������ ������';
$strKeyname = '��� �����';
$strKill = '�����';

$strLength = '������';
$strLengthSet = '�����/��������*';
$strLimitNumRows = '������� �� ��������';
$strLineFeed = '������ ��������� �����: \\n';
$strLines = '�����';
$strLinesTerminatedBy = '������ ���������';
$strLocationTextfile = '����������������� ���������� �����';
$strLogin = '���� � �������';
$strLogout = '����� �� �������';
$strLogPassword = '������:';
$strLogUsername = '������������:';

$strModifications = '����������� ���� ���������';
$strModify = '��������';
$strModifyIndexTopic = '�������� ������';
$strMoveTable = '����������� ������� � (���� ������<b>.</b>�������):';
$strMoveTableOK = '������� %s ���� ���������� � %s.';
$strMySQLReloaded = 'MySQL �������������.';
$strMySQLSaid = '����� MySQL: ';
$strMySQLServerProcess = 'MySQL %pma_s1% �� %pma_s2% ��� %pma_s3%';
$strMySQLShowProcess = '�������� ��������';
$strMySQLShowStatus = '�������� ��������� MySQL';
$strMySQLShowVars = '�������� ��������� ���������� MySQL';

$strName = '���';
$strNbRecords = '����� �������';
$strNext = '�����';
$strNo = '���';
$strNoDatabases = '�� �����������';
$strNoDropDatabases = '��������� "DROP DATABASE" ���������.';
$strNoFrames = '��� ������ phpMyAdmin ����� ������� � ���������� <b>�������</b>.';
$strNoIndexPartsDefined = '������ ������� �� ����������!';
$strNoIndex = '������ �� ���������!';
$strNoModification = '��� ���������';
$strNone = '���';
$strNoPassword = '��� ������';
$strNoPrivileges = '��� ����������';
$strNoQuery = '��� SQL-�������!';
$strNoRights = '�� �� ������ ���������� ���� ��� �����!';
$strNoTablesFound = '� �� �� ���������� ������.';
$strNotNumber = '��� �� �����!';
$strNotValidNumber = ' ������������ ���������� �����!';
$strNoUsersFound = '�� ������ ������������.';
$strNull = '����';

$strOftenQuotation = '������ �������. �� ������ ��������, ��� ������ ���� char � varchar ����������� � �������.';
$strOptimizeTable = '�������������� �������';
$strOptionalControls = '�� ������. ������������ ��� ������ ��� ������ ����������� �������.';
$strOptionally = '�� ������';
$strOr = '���';
$strOverhead = '��������� �������';

$strPartialText = '��������� ������';
$strPassword = '������';
$strPasswordEmpty = '������ ������!';
$strPasswordNotSame = '������ �� ���������!';
$strPHPVersion = '������ PHP';
$strPmaDocumentation = '������������ �� phpMyAdmin';
$strPos1 = '������';
$strPrevious = '�����';
$strPrimary = '���������';
$strPrimaryKey = '��������� ����';
$strPrimaryKeyName = '��� ���������� ����� ������ ���� PRIMARY!';
$strPrimaryKeyWarning = '("PRIMARY" <b>������</b> ���� ������ <b>������</b> ���������� �����!)';
$strPrimaryKeyHasBeenDropped = '��������� ���� ��� ������';
$strPrintView = '������ ��� ������';
$strPrivileges = '����������';
$strProperties = '��������';

$strQBE = '������ �� �������';
$strQBEDel = '�������';
$strQBEIns = '��������';
$strQueryOnDb = 'SQL-������ �� <b>%s</b>:';

$strRecords = '������';
$strReloadFailed = '�� ������� ������������� MySQL.';
$strReloadMySQL = '������������� MySQL';
$strRememberReload = '�� �������� ������������� ������.';
$strRenameTable = '������������� ������� �';
$strRenameTableOK = '������� %s ���� ������������� � %s';
$strRepairTable = '�������� �������';
$strReplace = '���������';
$strReplaceTable = '��������� ������ ������� ������� �� �����';
$strReset = '��������������';
$strReType = '�������������';
$strRevoke = '��������';
$strRevokeGrant = '�������� �������������� ����';
$strRevokeGrantMessage = '���� �������� �������������� ���� ��� %s';
$strRevokeMessage = '�� �������� ���������� ��� %s';
$strRevokePriv = '�������� ����������';
$strRowLength = '����� ����';
$strRows = '����';
$strRowsFrom = '����� ��';
$strRowSize = ' ������ ���� ';
$strRowsModeHorizontal = '��������������';
$strRowsModeOptions = '� %s ������, ��������� ����� ������ %s �����';
$strRowsModeVertical = '������������';
$strRowsStatistic = '���������� ����';
$strRunning = '�� %s';
$strRunQuery = '��������� ������';
$strRunSQLQuery = '��������� SQL ������(�) �� �� %�';

$strSave = '���������';
$strSelect = '�������';
$strSelectADb = '�������� ��';
$strSelectAll = '�������� ���';
$strSelectFields = '������� ���� (������� ����):';
$strSelectNumRows = '�� �������';
$strSend = '�������';
$strSequence = '����.';
$strServerChoice = '����� �������';
$strServerVersion = '������ �������';
$strSetEnumVal = '��� ����� ���� "enum" � "set", ������� �������� �� ����� �������: \'a\',\'b\',\'c\'...<br />���� ��� ������������ ������ �������� ����� ����� ("\"") ��� ��������� ������� ("\'") ����� ���� ��������, ��������� ����� ���� �������� ����� ����� (��������, \'\\\\xyz\' ��� \'a\\\'b\').';
$strShow = '��������';
$strShowAll = '�������� ���';
$strShowCols = '�������� �������';
$strShowingRecords = '���������� ������ ';
$strShowPHPInfo = '�������� ���������� � PHP';
$strShowTables = '�������� �������';
$strShowThisQuery = ' �������� ������ ������ ����� ';
$strSingly = '(��������)';
$strSize = '������';
$strSort = '�������������';
$strSpaceUsage = '������������ ������������';
$strSQLQuery = 'SQL-������';
$strStartingRecord = '�������� � ������';
$strStatement = '��������'; // ???To translate
$strStrucCSV = 'CSV ������';
$strStrucData = '��������� � ������';
$strStrucDrop = '�������� �������� �������';
$strStrucExcelCSV = 'CSV ��� ������ Ms Excel';
$strStrucOnly = '������ ���������';
$strSubmit = '���������';
$strSuccess = '��� SQL-������ ��� ������� ��������';
$strSum = '�����';

$strTable = '������� ';
$strTableComments = '����������� � �������';
$strTableEmpty = '������ �������� �������!';
$strTableHasBeenDropped = '������� %s ���� �������';
$strTableHasBeenEmptied = '������� %s ���� ����������';
$strTableHasBeenFlushed = '��� ������� ��� ������� %s';
$strTableMaintenance = '������������ �������';
$strTables = '%s ������(�)';
$strTableStructure = '��������� �������';
$strTableType = '��� �������';
$strTextAreaLength = ' ��-�� ������� �����,<br /> ��� ���� �� ����� ���� ���������������� ';
$strTheContent = '���������� ����� ���� �������������.';
$strTheContents = '���������� ����� �������� ���������� ������� ��� ����� � ����������� ���������� ��� ����������� �������.';
$strTheTerminator = '������ ��������� �����.';
$strTotal = '�����';
$strType = '���';

$strUncheckAll = '����� ������� �� ����';
$strUnique = '����������';
$strUnselectAll = '����� ������� �� ����';
$strUpdatePrivMessage = '���� �������� ���������� ���';
$strUpdateProfile = '�������� �������:';
$strUpdateProfileMessage = '������� ��� ��������.';
$strUpdateQuery = '��������� ������';
$strUsage = '�������������';
$strUseBackquotes = '�������� ������� � ��������� ������ � �����';
$strUser = '������������';
$strUserEmpty = '������ ��� ������������!';
$strUserName = '��� ������������';
$strUsers = '������������';
$strUseTables = '������������ �������';

$strValue = '��������';
$strViewDump = '����������� ���� (�����) �������';
$strViewDumpDB = '����������� ���� (�����) ��';

$strWelcome = '����� ���������� � %s';
$strWithChecked = '� �����������:';
$strWrongUser = '��������� �����/������. � ������� ��������.';

$strYes = '��';

$strZip = '��������� � "zip"';

// To translate
?>
