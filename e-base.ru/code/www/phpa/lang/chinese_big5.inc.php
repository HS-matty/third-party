<?php
/* $Id: chinese_big5.inc.php,v 1.99 2002/02/10 09:28:06 loic1 Exp $ */
// Last translation by: siusun <siusun@best-view.net>
// Follow by the original translation of Taiyen Hung �x����<yen789@pchome.com.tw>

$charset = 'big5';
$text_dir = 'ltr';
$left_font_family = 'verdana, helvetica, arial, geneva, sans-serif';
$right_font_family = 'helvetica, sans-serif';
$number_thousands_separator = ',';
$number_decimal_separator = '.';
$byteUnits = array('Bytes', 'KB', 'MB', 'GB');

$day_of_week = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
$month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
// See http://www.php.net/manual/en/function.strftime.php to define the
// variable below
$datefmt = '%B %d, %Y at %I:%M %p';


$strAccessDenied = '�ڵ��s��';
$strAction = '����';
$strAddDeleteColumn = '�s�W/��� �����';
$strAddDeleteRow = '�s�W/��� �z��C';
$strAddNewField = '�W�[�s���';
$strAddPriv = '�W�[�s�v��';
$strAddPrivMessage = '�z�w�g���U���o��ϥΪ̼W�[�F�s�v��.';
$strAddSearchConditions = '�W�[�˯����� ("where" �l�y���D��)';
$strAddToIndex = '�s�W &nbsp;%s&nbsp; �կ�����';
$strAddUser = '�s�W�ϥΪ�';
$strAddUserMessage = '�z�w�s�W�F�@�ӷs�ϥΪ�.';
$strAffectedRows = '�v�T�C��: ';
$strAfter = '�b %s ����';
$strAfterInsertBack = '��^';
$strAfterInsertNewInsert = '�s�W�@���O��';
$strAll = '����';
$strAlterOrderBy = '�ھ���줺�e�ƧǰO���G';
$strAnalyzeTable = '���R��ƪ�';
$strAnd = '�P';
$strAnIndex = '���ޤw�g�s�W�� %s';
$strAny = '����';
$strAnyColumn = '�������';
$strAnyDatabase = '�����Ʈw';
$strAnyHost = '����D��';
$strAnyTable = '�����ƪ�';
$strAnyUser = '����ϥΪ�';
$strAPrimaryKey = '�D��w�g�s�W�� %s';
$strAscending = '���W';
$strAtBeginningOfTable = '���ƪ�}�Y';
$strAtEndOfTable = '���ƪ����';
$strAttr = '�ݩ�';

$strBack = '�^�W�@��';
$strBinary = 'Binary'; //should expressed in English
$strBinaryDoNotEdit = 'Binary - ����s��';
$strBookmarkDeleted = '��ñ�w�g�R��.';
$strBookmarkLabel = '���ҦW��';
$strBookmarkQuery = 'SQL �y�k����';
$strBookmarkThis = '�N�� SQL �y�k�[�J����';
$strBookmarkView = '�d��';
$strBrowse = '�s��';
$strBzip = '"bzipped"';

$strCantLoadMySQL = '������J MySQL �Ҳ�,<br />���ˬd PHP ���պA�]�w';
$strCantRenameIdxToPrimary = '�L�k�N���ާ�W�� PRIMARY!';
$strCardinality = '�էO';
$strCarriage = '�k��: \\r';
$strChange = '�ק�';
$strCheckAll = '����';
$strCheckDbPriv = '�ˬd��Ʈw�v��';
$strCheckTable = '�ˬd��ƪ�';
$strColumn = '���';
$strColumnNames = '���W��';
$strCompleteInserts = '�ϥΧ���s�W���O';
$strConfirm = '�z�T�w�n�o�˰��H';
$strCookiesRequired = 'Cookies �����Ұʤ~��n�J.';
$strCopyTable = '�ƻs��ƪ��G (�榡�� ��Ʈw�W��<b>.</b>��ƪ�W��):';
$strCopyTableOK = '�w�g�N��ƪ� %s �ƻs�� %s.';
$strCreate = '�إ�';
$strCreateIndex = '�s�W &nbsp;%s&nbsp; �կ�����';
$strCreateIndexTopic = '�s�W�@�կ���';
$strCreateNewDatabase = '�إ߷s��Ʈw';
$strCreateNewTable = '�إ߷s��ƪ���Ʈw ';
$strCriteria = '�z��';

$strData = '���';
$strDatabase = '��Ʈw';
$strDatabaseHasBeenDropped = '��Ʈw %s �w�Q�R��';
$strDatabases = '��Ʈw';
$strDatabasesStats = '��Ʈw�έp';
$strDataOnly = '�u�����';
$strDefault = '�w�]��';
$strDelete = '�R��';
$strDeleted = '�O���w�Q�R��';
$strDeletedRows = '�w�R�����:';
$strDeleteFailed = '�R������!';
$strDeleteUserMessage = '�z�w�g�N�Τ� %s �R��.';
$strDescending = '���W';
$strDisplay = '���';
$strDisplayOrder = '��ܦ���:';
$strDoAQuery = '�H�d�Ҭd�� (�U�Φr�� : "%")';
$strDocu = '�������';
$strDoYouReally = '�z�T�w�n ';
$strDrop = '�R��';
$strDropDB = '�R����Ʈw';
$strDropTable = '�R����ƪ�';
$strDumpingData = '�C�X�H�U��Ʈw���ƾڡG';
$strDynamic = '�ʺA';

$strEdit = '�s��';
$strEditPrivileges = '�s���v��';
$strEffective = '���';
$strEmpty = '�M��';
$strEmptyResultSet = 'MySQL �Ǧ^���d�ߵ��G���� (��]�i�ର�G�S�����ŦX���󪺰O��)';
$strEnd = '�̫�@��';
$strEnglishPrivileges = '�`�N: MySQL �v���W�ٷ|�Q�������^��';
$strError = '���~';
$strExtendedInserts = '�����s�W�Ҧ�';
$strExtra = '���[';

$strField = '���';
$strFieldHasBeenDropped = '��ƪ� %s �w�Q�R��';
$strFields = '���';
$strFieldsEmpty = ' ���O�Ū�! ';
$strFieldsEnclosedBy = '�u���v�ϥΦr���G';
$strFieldsEscapedBy = '�uESCAPE�v�ϥΦr���G';
$strFieldsTerminatedBy = '�u�����j�v�ϥΦr���G';
$strFixed = '�T�w';
$strFlushTable = '�j��������ƪ� ("FLUSH")';
$strFormat = '�榡';
$strFormEmpty = '��椺�|��@�Ǹ�� !';
$strFullText = '��ܧ����r';
$strFunction = '���';

$strGenTime = '�إߤ��';
$strGo = '����';
$strGrants = 'Grants'; //should expressed in English
$strGzip = '"gzipped"';

$strHasBeenAltered = '�w�g�ק�';
$strHasBeenCreated = '�w�g�إ�';
$strHome = '�D�ؿ�';
$strHomepageOfficial = 'phpMyAdmin �x�����';
$strHomepageSourceforge = 'phpMyAdmin �U������';
$strHost = '�D��';
$strHostEmpty = '�п�J�D���W��!';

$strIdxFulltext = '�����˯�';
$strIfYouWish = '�p�G�z�n���w��ƶפJ�����A�п�J�γr���j�}�����W��';
$strIgnore = '����';
$strIndex = '����';
$strIndexes = '����';
$strIndexHasBeenDropped = '���� %s �w�Q�R��';
$strIndexName = '���ަW��&nbsp;:';
$strIndexType = '��������&nbsp;:';
$strInsert = '�s�W';
$strInsertAsNewRow = '�x�s���s�O��';
$strInsertedRows = '�s�W�C��:';
$strInsertNewRow = '�s�W�@���O��';
$strInsertTextfiles = '�N��r�ɸ�ƶפJ��ƪ�';
$strInstructions = '���O';
$strInUse = '�ϥΤ�';
$strInvalidName = '"%s" �O�@�ӫO�d�r,�z����N�O�d�r�ϥά� ��Ʈw/��ƪ�/��� �W��.';

$strKeepPass = '�Ф��n���K�X';
$strKeyname = '��W';
$strKill = 'Kill'; //should expressed in English

$strLength = '����';
$strLengthSet = '����/���X*';
$strLimitNumRows = '���O��/�C��';
$strLineFeed = '����: \\n';
$strLines = '���';
$strLinesTerminatedBy = '�u�U�@��v�ϥΦr���G';
$strLocationTextfile = '��r�ɮת���m';
$strLogin = '�n�J';
$strLogout = '�n�X�t��';
$strLogPassword = '�K�X:';
$strLogUsername = '�n�J�W��:';

$strModifications = '�ק�w�x�s';
$strModify = '���';
$strModifyIndexTopic = '������';
$strMoveTable = '���ʸ�ƪ��G(�榡�� ��Ʈw�W��<b>.</b>��ƪ�W��)';
$strMoveTableOK = '��ƪ� %s �w�g���ʨ� %s.';
$strMySQLReloaded = 'MySQL ���s���J����';
$strMySQLSaid = 'MySQL �Ǧ^�G ';
$strMySQLServerProcess = 'MySQL ���� %pma_s1% �b %pma_s2% ����A�n�J�̬� %pma_s3%';
$strMySQLShowProcess = '��ܵ{�� (Process)';
$strMySQLShowStatus = '��� MySQL ���檬�A';
$strMySQLShowVars = '��� MySQL �t���ܼ�';

$strName = '�W��';
$strNbRecords = '���}�l�F�C�X�O������';
$strNext = '�U�@��';
$strNo = ' �_ ';
$strNoDatabases = '�S����Ʈw';
$strNoDropDatabases = '"DROP DATABASE" ���O�w�g����.';
$strNoFrames = 'phpMyAdmin �����A�X�ϥΦb�䴩<b>����</b>���s����.';
$strNoIndexPartsDefined = '�������޸���٥��w�q!';
$strNoIndex = '�S���w�w�q������!';
$strNoModification = '�S�����';
$strNone = '���A��';
$strNoPassword = '���αK�X';
$strNoPrivileges = '�S���v��';
$strNoQuery = '�S�� SQL �y�k!';
$strNoRights = '�z�{�b�S���������v���b�o��!';
$strNoTablesFound = '��Ʈw���S����ƪ�';
$strNotNumber = '�п�J�Ʀr!';
$strNotValidNumber = '���O���Ī��C��!';
$strNoUsersFound = '�S�����ϥΪ�';
$strNull = 'Null'; //should expressed in English

$strOftenQuotation = '�̱`�Ϊ��O�޸��A�u�D�����v��ܥu�� char �M varchar ���|�Q�]�A�_��';
$strOptimizeTable = '�̨ΤƸ�ƪ�';
$strOptionalControls = '�D���n�ﶵ�A�Ψ�Ū�g�S��r��';
$strOptionally = '�D����';
$strOr = '��';
$strOverhead = '�h�l';

$strPartialText = '��ܳ�����r';
$strPassword = '�K�X';
$strPasswordEmpty = '�п�J�K�X!';
$strPasswordNotSame = '�G����J���K�X���P!';
$strPHPVersion = 'PHP����';
$strPmaDocumentation = 'phpMyAdmin �������';
$strPos1 = '�Ĥ@��';
$strPrevious = '�e�@��';
$strPrimary = '�D��';
$strPrimaryKey = '�D��';
$strPrimaryKeyHasBeenDropped = '�D��w�Q�R��';
$strPrimaryKeyName = '�D�䪺�W�٥����٬� PRIMARY!';
$strPrimaryKeyWarning = '("PRIMARY" <b>����</b>�O�D�䪺�W�٥H�άO<b>�ߤ@</b>�@�եD��!)';
$strPrintView = '�C�L�˵�';
$strPrivileges = '�v��';
$strProperties = '�ݩ�';

$strQBE = '�̽d�Ҭd�� (QBE)';
$strQBEDel = '����';
$strQBEIns = '�s�W';
$strQueryOnDb = '�b��Ʈw <b>%s</b> ���� SQL �y�k:';

$strRecords = '�O��';
$strReloadFailed = '���s���JMySQL����';
$strReloadMySQL = '���s���J MySQL';
$strRememberReload = '�аO�ۭ��s�Ұʦ��A��.';
$strRenameTable = '�N��ƪ��W��';
$strRenameTableOK = '�w�g�N��ƪ� %s ��W�� %s';
$strRepairTable = '�״_��ƪ�';
$strReplace = '���N';
$strReplaceTable = '�H�ɮר��N��ƪ���';
$strReset = '���m';
$strReType = '�T�{�K�X';
$strRevoke = '����';
$strRevokeGrant = '���� Grant �v��';
$strRevokeGrantMessage = '�z�w�����U���o��ϥΪ̪� Grant �v��: %s';
$strRevokeMessage = '�z�w�����U���o��ϥΪ̪��v��: %s';
$strRevokePriv = '�����v��';
$strRowLength = '��ƦC����';
$strRows = '��ƦC�C��';
$strRowsFrom = '���O���A�}�l�C��:';
$strRowSize = '��ƦC�j�p';
$strRowsModeHorizontal = '����';
$strRowsModeOptions = '��ܬ� %s �覡 �� �C�j %s �������W';
$strRowsModeVertical = '����';
$strRowsStatistic = '��ƦC�έp�ƭ�';
$strRunning = '�b %s ����';
$strRunQuery = '����y�k';
$strRunSQLQuery = '�b��Ʈw %s ����H�U���O';

$strSave = '�x�s';
$strSelect = '���';
$strSelectADb = '�п�ܸ�Ʈw';
$strSelectAll = '����';
$strSelectFields = '������ (�ܤ֤@��)';
$strSelectNumRows = '�d�ߤ�';
$strSend = '�U���x�s';
$strSequence = '�ǦC';
$strServerChoice = '��ܦ��A��';
$strServerVersion = '��Ʈw����';
$strSetEnumVal = '�p���榡�O "enum" �� "set", �ШϥΥH�U���榡��J: \'a\',\'b\',\'c\'...<br />�p�b�ƭȤW�ݭn��J�ϱ׽u (\) �γ�޸� (\') , �ЦA�[�W�ϱ׽u (�Ҧp \'\\\\xyz\' or \'a\\\'b\').';
$strShow = '���';
$strShowAll = '��ܥ���';
$strShowCols = '�����';
$strShowingRecords = '��ܰO��';
$strShowPHPInfo = '��� PHP ��T';
$strShowTables = '��ܸ�ƪ�';
$strShowThisQuery = '�b�o�̭��s��ܻy�k ';
$strSingly = '(�u�|�Ƨǲ{�ɪ��O��)';
$strSize = '�j�p';
$strSort = '�Ƨ�';
$strSpaceUsage = '�w�ϥΪŶ�';
$strSQLQuery = 'SQL �y�k';
$strStartingRecord = '�ѰO��';
$strStatement = '�ԭz';
$strStrucCSV = 'CSV ���';
$strStrucData = '���c�P���';
$strStrucDrop = '�W�[ \'drop table\'';
$strStrucExcelCSV = 'Ms Excel �� CSV �榡';
$strStrucOnly = '�u�����c';
$strSubmit = '�e�X';
$strSuccess = '�z��SQL�y�k�w���Q����';
$strSum = '�`�p';

$strTable = '��ƪ�';
$strTableComments = '��ƪ���Ѥ�r';
$strTableEmpty = '�п�J��ƪ�W��!';
$strTableHasBeenDropped = '��ƪ� %s �w�Q�R��';
$strTableHasBeenEmptied = '��ƪ� %s �w�Q�M��';
$strTableHasBeenFlushed = '��ƪ� %s �w�Q�j������';
$strTableMaintenance = '��ƪ���@';
$strTables = '%s ��ƪ�';
$strTableStructure = '��ƪ�榡�G';
$strTableType = '��ƪ�����';
$strTextAreaLength = ' �ѩ���׭���<br /> ����줣��s��';
$strTheContent = '�ɮפ��e�w�g�פJ��ƪ�';
$strTheContents = '�ɮפ��e�N�|���N��w����ƪ��㦳�ۦP�D��ΰߤ@�䪺�O��';
$strTheTerminator = '���j��쪺�r��';
$strTotal = '�`�p';
$strType = '���A';

$strUncheckAll = '��������';
$strUnique = '�ߤ@';
$strUnselectAll = '��������';
$strUpdatePrivMessage = '�A�w�g��s�F %s ���v��.';
$strUpdateProfile = '��s���:';
$strUpdateProfileMessage = '��Ƥv�g��s.';
$strUpdateQuery = '��s�y�k';
$strUsage = '�ϥ�';
$strUseBackquotes = ' �N��ƪ�����[�J�޸�';
$strUser = '�ϥΪ�';
$strUserEmpty = '�п�J�ϥΪ̦W��!';
$strUserName = '�ϥΪ̦W��';
$strUsers = '�ϥΪ�';
$strUseTables = '�ϥθ�ƪ�';

$strValue = '��';
$strViewDump = '�˵���ƪ��ƥ����n (dump schema)';
$strViewDumpDB = '�˵���Ʈw���ƥ����n (dump schema)';

$strWelcome = '�w��ϥ� %s';
$strWithChecked = '��ܪ���ƪ�G';
$strWrongUser = '���~���ϥΪ̦W�٩αK�X   �ڵ��s��';

$strYes = ' �O ';

$strZip = '"zipped"';

// To translate
?>
