<?php
/* $Id: japanese-sjis.inc.php,v 1.2 2002/02/19 23:20:01 lem9 Exp $ */

$charset = 'SHIFT_JIS';
$text_dir = 'ltr';
$left_font_family = 'sans-serif';
$right_font_family = 'sans-serif';
$number_thousands_separator = ',';
$number_decimal_separator = '.';
$byteUnits = array('�o�C�g', 'KB', 'MB', 'GB');

$day_of_week = array('��', '��', '��', '��', '��', '��', '�y');
$month = array('1��','2��','3��','4��','5��','6��','7��','8��','9��','10��','11��','12��');
// See http://www.php.net/manual/en/function.strftime.php to define the
// variable below
$datefmt = '%Y�N%B%e�� %H:%M';


$strAccessDenied = '�A�N�Z�X�͋��ۂ���܂����B';
$strAction = '���s';
$strAddDeleteColumn = '�t�B�[���h��́u�ǉ��^�폜�v';
$strAddDeleteRow = '�����s�́u�ǉ��^�폜�v';
$strAddNewField = '�t�B�[���h�̒ǉ�';
$strAddPriv = '�V���������̒ǉ�';
$strAddPrivMessage = '�V����������ǉ����܂����B';
$strAddSearchConditions = '������������ǉ����Ă��������B("where"�̐ߕ�):';
$strAddToIndex = ' &nbsp;%s&nbsp;�̗���C���f�b�N�X�ɒǉ����܂���';
$strAddUser = '���[�U�[�̒ǉ�';
$strAddUserMessage = '���[�U�[��ǉ����܂����B';
$strAffectedRows = '�e�����ꂽ�s��:';
$strAfter = '��� %s';
$strAfterInsertBack = '�߂�';
$strAfterInsertNewInsert = '�V���R�[�h�̒ǉ�';
$strAll = '�S��';
$strAlterOrderBy = '�e�[�u�����Ԃ̏���';
$strAnalyzeTable = '�e�[�u���𕪐͂��܂��B';
$strAnd = '�y��';
$strAnIndex = '�C���f�b�N�X��%s�ɒǉ�����܂����B';
$strAny = '�S��';
$strAnyColumn = '�S�R����';
$strAnyDatabase = '�S�f�[�^�x�[�X';
$strAnyHost = '�S�Ẵz�X�g';
$strAnyTable = '�S�Ẵe�[�u��';
$strAnyUser = '�S�Ẵ��[�U�[';
$strAPrimaryKey = '��v�L�[��%s�ɒǉ�����܂����B';
$strAscending = '����';
$strAtBeginningOfTable = '�e�[�u���̍ŏ�';
$strAtEndOfTable = '�e�[�u���̍Ō�';
$strAttr = '�\��';

$strBack = '�߂�';
$strBinary = ' �o�C�i�� ';
$strBinaryDoNotEdit = ' �o�C�i�� -  �C���o���܂���';
$strBookmarkDeleted = '�u�b�N�}�[�N�𐳏�ɍ폜���܂����B';
$strBookmarkLabel = '���x��';
$strBookmarkQuery = '�u�b�N�}�[�N����Ă���SQL�N�G���[';
$strBookmarkThis = 'SQL�N�G���[���u�b�N�}�[�N����';
$strBookmarkView = '���\����';
$strBrowse = '�\��';
$strBzip = '"bzip�����"';

$strCantLoadMySQL = 'MySQL�����s�ł��܂���B<br />PHP�̐ݒ���m�F���ĉ������B';
$strCantRenameIdxToPrimary = '�C���f�b�N�X�̖��O��PRIMARY�ɕύX�ł��܂���B';
$strCardinality = '�J�[�f�B�i���e�B';
$strCarriage = '�L�����b�W���^�[��: \\r';
$strChange = '�ύX';
$strCheckAll = '�S�Ă��}�[�N';
$strCheckDbPriv = '�f�[�^�x�[�X�̓����̊m�F';
$strCheckTable = '�e�[�u�����`�F�b�N���܂��B';
$strColumn = '��';
$strColumnNames = '��(�R����)��';
$strCompleteInserts = '���S��INSERT���̍쐬';
$strConfirm = '���s���Ă��ǂ��ł����H';
$strCookiesRequired = '���������̓N�b�L�[��������Ă���K�v������܂��B';
$strCopyTable = '�e�[�u����(database<b>.</b>table)�ɃR�s�[����:';
$strCopyTableOK = '%s�e�[�u����%s�ɃR�s�[���܂����B';
$strCreate = '�쐬';
$strCreateIndex = '&nbsp;%s&nbsp;�̗�̃C���f�b�N�X�̍쐬';
$strCreateIndexTopic = '�V�����C���f�b�N�X�̍쐬';
$strCreateNewDatabase = '�V����DB���쐬���܂��B';
$strCreateNewTable = '���݂�DB�ɐV�����e�[�u�����쐬���܂��B --> ';
$strCriteria = '�';

$strData = '�f�[�^';
$strDatabase = '�f�[�^�x�[�X';
$strDatabaseHasBeenDropped = '�f�[�^�x�[�X%s�𐳏�ɍ폜���܂����B';
$strDatabases = '�f�[�^�x�[�X';
$strDatabasesStats = '�f�[�^�x�[�X�̓��v';
$strDataOnly = '�f�[�^�̂�';
$strDefault = '��{�l';
$strDelete = '�폜';
$strDeleted = '�I����������폜���܂����B';
$strDeleteFailed = '�폜�Ɏ��s���܂���';
$strDeleteUserMessage = '���[�U�[%s���폜���܂����B';
$strDeletedRows = '�폜���ꂽ�s��:';
$strDescending = '�~��';
$strDisplay = '�\��';
$strDisplayOrder = '���\����:';
$strDoAQuery = '"���QUERY"�����s (wildcard: "%")';
$strDocu = '�w���v';
$strDoYouReally = '�{���Ɏ��s���Ă��ǂ��ł����H --> ';
$strDrop = '�폜';
$strDropDB = 'DB�̍폜 -->';
$strDropTable = '�e�[�u���̍폜';
$strDumpingData = '�e�[�u���̃_���v�f�[�^';
$strDynamic = '�_�C�i�~�b�N';

$strEdit = '�C��';
$strEditPrivileges = '�������C��';
$strEffective = '������';
$strEmpty = '��ɂ���';
$strEmptyResultSet = 'MySQL����̒l��Ԃ��܂����B(i.e. zero rows).';
$strEnd = '�Ō�';
$strEnglishPrivileges = ' ����: MySQL�̓����̖��O�͉p��Ŕ��\���Ă���B';
$strError = '�G���[';
$strExtendedInserts = '����INSERT���̍쐬';
$strExtra = '�ǉ�';

$strField = '�t�B�[���h';
$strFieldHasBeenDropped = '�t�B�[���h%s������ɍ폜����܂���';
$strFields = '�t�B�[���h';
$strFieldsEmpty = ' �t�B�[���h���͋�ł��B ';
$strFieldsEnclosedBy = '�t�B�[���h�͂݋L��';
$strFieldsEscapedBy = '�t�B�[���h�̃G�X�P�[�v�L��';
$strFieldsTerminatedBy = '�t�B�[���h��؂�L��';
$strFixed = '�Œ�';
$strFlushTable = '�e�[�u���̃L���b�V������ɂ���("FLUSH")';
$strFormat = '�t�H�[�}�b�g';
$strFormEmpty = '�t�H�[���ł͒l������܂���ł����B';
$strFullText = '�S��';
$strFunction = '�֐�';

$strGenTime = '�쐬�̎���';
$strGo = '���s';
$strGrants = '�t�^';
$strGzip = '"gzip�����"';

$strHasBeenAltered = '��ύX���܂����B';
$strHasBeenCreated = '���쐬���܂����B';
$strHome = '���[���y�[�W��';
$strHomepageOfficial = 'phpMyAdmin�z�[��';
$strHomepageSourceforge = 'Sourceforge��phpMyAdmin�_�E�����[�h�y�[�W';
$strHost = '�z�X�g';
$strHostEmpty = '�z�X�g���͋�ł�!';

$strIdxFulltext = '�S��';
$strIfYouWish = '�e�[�u���̃R����(��)�Ƀf�[�^��ǉ�����ꍇ�́A�t�B�[���h���X�g���J���}�ŋ敪���Ă��������B';
$strIgnore = '����';
$strIndex = '�C���f�b�N�X';
$strIndexes = '�C���f�b�N�X��';
$strIndexHasBeenDropped = '�C���f�b�N�X%s���폜����܂���';
$strIndexName = '�C���f�b�N�X��&nbsp;:';
$strIndexType = '�C���f�b�N�X�̃^�C�v&nbsp;:';
$strInsert = '�ǉ�';
$strInsertAsNewRow = '�V�����s�Ƃ��Ă̒ǉ�';
$strInsertedRows = '�ǉ����ꂽ�s��:';
$strInsertNewRow = '�V�����s�̒ǉ�';
$strInsertTextfiles = '�e�[�u���Ƀe�L�X�g�t�@�C���̒ǉ�';
$strInstructions = '����';
$strInUse = '�g�p��';
$strInvalidName = '"%s"�͗\�񂳂ꂽ���O�ł�����u�f�[�^�x�[�X�^�e�[�u���^�t�B�[���h�v���ɂ͎g���܂���B';

$strKeepPass = '�p�X���[�h��ύX���Ȃ�';
$strKeyname = '�L�[��';
$strKill = '��~';

$strLength = '����';
$strLengthSet = '����/�Z�b�g*';
$strLimitNumRows = '�y�[�W�̃��R�[�h��';
$strLineFeed = '���s����: \\n';
$strLines = '�s';
$strLinesTerminatedBy = '�s�̏I�[�L��';
$strLocationTextfile = '�e�L�X�g�t�@�C���̏ꏊ';
$strLogin = '���O�C��';
$strLogout = '���O�A�E�g';
$strLogPassword = '�p�X���[�h:';
$strLogUsername = '���[�U�[��:';

$strModifications = '�𐳂����C�����܂����B';
$strModify = '�C��';
$strModifyIndexTopic = '�C���f�b�N�X�̕ύX';
$strMoveTable = '�e�[�u����(database<b>.</b>table)�Ɉړ�:';
$strMoveTableOK = '�e�[�u��%s��%s�ړ�����܂����B';
$strMySQLReloaded = 'MySQL��V�����ǂݍ��݂܂����B';
$strMySQLSaid = 'MySQL�̃��b�Z�[�W --> ';
$strMySQLServerProcess = 'MySQL %pma_s1%��%pma_s2%��%pma_s3%�Ƃ��Ď��s���Ă��܂��B';
$strMySQLShowProcess = 'MySQL�v���Z�X�̕\��';
$strMySQLShowStatus = 'MySQL�̃����^�C�����';
$strMySQLShowVars = 'MySQL�̃V�X�e���ϐ�';

$strName = '���O';
$strNbRecords = '���R�[�h��';
$strNext = '����';
$strNo = '������';
$strNoDatabases = '�f�[�^�x�[�X��';
$strNoDropDatabases = '"DROP DATABASE"�X�e�[�g�����g�͋֎~�����B';
$strNoFrames = '<b>�t���[��</b>�\�ȃu���E�U�[����phpMyAdmin�̕��͎g���₷���ł��B';
$strNoIndex = '�C���f�b�N�X�͐ݒ肳��Ă��܂���B';
$strNoIndexPartsDefined = '�C���f�b�N�X�̕����͐ݒ肳��Ă��܂���B';
$strNoModification = '�ύX��';
$strNone = '��';
$strNoPassword = '�p�X���[�h����';
$strNoPrivileges = '��������';
$strNoQuery = 'SQL�N�G���[����';
$strNoRights = '���ݓ����������ĂȂ��̂ł����ɓ���܂���B';
$strNoTablesFound = '���݂�DB�Ƀe�[�u���͂���܂���B';
$strNotNumber = '����͔ԍ��ł͂���܂���B';
$strNotValidNumber = ' �͍s�̐������ԍ��ł͂���܂��� ';
$strNoUsersFound = '���[�U�[�͌�����܂���ł����B';
$strNull = '��̒l(Null)';

$strOftenQuotation = '���p�����ł��B�I�v�V�����́Achar�܂���varchar�t�B�[���h�̂�" "�ň͂܂�Ă��邱�Ƃ��Ӗ����܂��B';
$strOptimizeTable = '�e�[�u�����œK�����܂��B';
$strOptionalControls = '���ꕶ���̓ǂݍ���/�������݃I�v�V����';
$strOptionally = '�I�v�V�����ł��B';
$strOr = '����';
$strOverhead = '�I�[�o�[�w�b�h';

$strPartialText = '�����I�ȕ���';
$strPassword = '�p�X���[�h';
$strPasswordEmpty = '�p�X���[�h�͋�ł��B';
$strPasswordNotSame = '�p�X���[�h�͋�ł��B';
$strPHPVersion = 'PHP �o�[�W����';
$strPmaDocumentation = 'phpMyAdmin�̃h�L�������g';
$strPos1 = '�ŏ�';
$strPrevious = '�ȑO';
$strPrimary = '��v';
$strPrimaryKey = '��v�L�[';
$strPrimaryKeyHasBeenDropped = '��v�L�[���폜���܂����B';
$strPrimaryKeyName = '��v�L�[�̖��O��... PRIMARY�ł͂Ȃ���΂����܂���B';
$strPrimaryKeyWarning = '("PRIMARY"�͂��傤�ǎ�v�L�[�̖��O�ł͂Ȃ���΂����܂���B';
$strPrintView = '����p�\��';
$strPrivileges = '����';
$strProperties = '�v���p�e�B';

$strQBE = '�Ⴉ��N�G���[���s';
$strQBEDel = '�폜';
$strQBEIns = '��';
$strQueryOnDb = '�f�[�^�x�[�X��SQL�N�G���[ <b>%s</b>:';

$strRecords = '���R�[�h��';
$strReloadFailed = 'MySQL�̃����[�h�Ɏ��s���܂����B';
$strReloadMySQL = 'MySQL�̃����[�h';
$strRememberReload = '�T�[�o�[�̃����[�h��Y��Ȃ��ŉ������B';
$strRenameTable = '�e�[�u�����̕ύX';
$strRenameTableOK = '%s��%s�ɖ��O��ύX���܂����B';
$strRepairTable = '�e�[�u���𕜋����܂��B';
$strReplace = '�u��������';
$strReplaceTable = '�t�@�C���Ńe�[�u����u��������';
$strReset = '���Z�b�g';
$strReType = '�ċL��';
$strRevoke = '�p�~';
$strRevokeGrant = ' �t�^�̎��';
$strRevokeGrantMessage = '%s�̕t�^������������܂����B';
$strRevokeMessage = '%s�̓�����������܂���';
$strRevokePriv = '�����̎��';
$strRowLength = '�s�̒���';
$strRows = '�s';
$strRowsFrom = '�J�n�s';
$strRowSize = ' �s�̃T�C�Y ';
$strRowsModeHorizontal = '����';
$strRowsModeOptions = '����: %s : %s �񂸂w�b�_�[���J��Ԃ����\����';
$strRowsModeVertical = '�d��';
$strRowsStatistic = '�s�̓��v';
$strRunning = '�����s���ł��B %s';
$strRunQuery = '�N�G���[�̎��s';
$strRunSQLQuery = '�f�[�^�x�[�X%s��SQL�N�G���[���s';

$strSave = '�ۑ�';
$strSelect = '�I��';
$strSelectADb = '�f�[�^�x�[�X��I�����Ă�������';
$strSelectAll = '�S�I��';
$strSelectFields = '�t�B�[���h�̑I��(��ȏ�):';
$strSelectNumRows = '�N�G���[';
$strSend = '�t�@�C���ɗ��Ƃ�';
$strSequence = '��.';
$strServerChoice = '�T�[�o�[�̑I��';
$strServerVersion = '�T�[�o�[�̃o�[�W����';
$strSetEnumVal = '�t�B�[���h�^�C�v��"enum"����"set"�̏ꍇ�͒l�����̃t�H�[�}�b�g���g���ē��͂��ĉ�����: \'a\',\'b\',\'c\'...<br />�o�b�N�X���b�V���u"\"�v���̓N�I�[�g�u"\'"�v����͂������ƁA���Ƀo�b�N�X���b�V����t���ĉ������u��: \'\\\\xyz\' or \'a\\\'b\'�v�B';
$strShow = '�\��';
$strShowAll = '�S�̔�' . "\x5c";
$strShowCols = '��̔�' . "\x5c";
$strShowingRecords = '���R�[�h�\��';
$strShowPHPInfo = 'PHP���';
$strShowTables = '�e�[�u���̔�' . "\x5c";
$strShowThisQuery = ' ���s�����N�G���[�������ɕ\������ ';
$strSingly = '(���)';
$strSize = '�T�C�Y';
$strSort = '�\�[�g';
$strSpaceUsage = '�f�B�X�N�g�p��';
$strSQLQuery = '���s���ꂽSQL�N�G���[';
$strStartingRecord = '�ŏ��̃��R�[�h';
$strStatement = '�X�e�[�g�����g';
$strStrucCSV = 'CSV�f�[�^';
$strStrucData = '�\���ƃf�[�^';
$strStrucDrop = '\'drop table\'��ǉ�';
$strStrucExcelCSV = 'Ms Excel�ւ�CSV�f�[�^';
$strStrucOnly = '�\���̂�';
$strSubmit = '���s';
$strSuccess = 'SQL�N�G���[������Ɏ��s����܂����B';
$strSum = '���v';

$strTable = '�e�[�u�� ';
$strTableComments = '�e�[�u���̐���';
$strTableEmpty = '�e�[�u�����͋�ł��B';
$strTableHasBeenDropped = '�e�[�u��%s���폜���܂����B';
$strTableHasBeenEmptied = '�e�[�u��%s����ɂ��܂����B';
$strTableHasBeenFlushed = '�e�[�u��%s�̃L���b�V������ɂ��܂����B';
$strTableMaintenance = '�e�[�u���Ǘ�';
$strTables = '%s�e�[�u��';
$strTableStructure = '�e�[�u���̍\��';
$strTableType = '�e�[�u���̃^�C�v';
$strTextAreaLength = ' �����̏��ׂł��̃t�B�[���h��<br /> �C���o���Ȃ��\��������܂� ';
$strTheContent = '�t�@�C���̃f�[�^��}�����܂����B';
$strTheContents = '�t�@�C���̃f�[�^�ŁA�I�������e�[�u���̎�v�L�[�܂��͗B��ȃL�[�Ɉ�v������u�������܂��B';
$strTheTerminator = '�t�B�[���h�̏I�[�L���ł��B';
$strTotal = '���v';
$strType = '�t�B�[���h�^�C�v';

$strUncheckAll = '�S�Ẵ}�[�N���폜';
$strUnique = '�B��';
$strUnselectAll = '�S���';
$strUpdatePrivMessage = '%s�̓������A�b�v�f�[�g���܂����B';
$strUpdateProfile = '�v���t�@�C���̃A�b�v�f�[�g:';
$strUpdateProfileMessage = '�v���t�@�C�����A�b�v�f�[�g���܂����B';
$strUpdateQuery = '�N�G���[�̃A�b�v�f�[�g';
$strUsage = '�g�p��';
$strUseBackquotes = '�t�N�I�[�g�Ńe�[�u������t�B�[���h�����͂�';
$strUser = '���[�U�[';
$strUserEmpty = '���[�U�[���͋�ł��B';
$strUserName = '���[�U�[��';
$strUsers = '���[�U�[';
$strUseTables = '�g���e�[�u��';

$strValue = '�l';
$strViewDump = '�e�[�u���̃_���v(�X�L�[�})�\��';
$strViewDumpDB = 'DB�̃_���v(�X�L�[�})�\��';

$strWelcome = '%s�ւ悤����';
$strWithChecked = '�`�F�b�N�������̂�:';
$strWrongUser = '���[�U���܂��̓p�X���[�h������������܂���B<br />�A�N�Z�X�͋��ۂ���܂����B';

$strYes = '�͂�';

$strZip = '"zip�����"';

// To translate
?>
