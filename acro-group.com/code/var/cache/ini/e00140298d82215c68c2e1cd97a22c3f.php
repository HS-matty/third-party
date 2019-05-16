<?php
$eZIniCacheCodeDate = 1043407542;
$charset = "iso-8859-1";
$groupArray["AvailableSiteDesignList"] = array();
$groupArray["AvailableSiteDesignList"][0] = "plain";
$groupArray["AvailableSiteDesignList"][1] = "admin";
$groupArray["DefaultPreviewDesign"] = "admin";
$groupArray["AllowChangeButtons"] = "enabled";
$groupArray["AllowVersionsButton"] = "enabled";
$blockValues["VersionView"] =& $groupArray;
unset( $groupArray );
$groupArray["DefaultVersionHistoryLimit"] = "10";
$groupArray["VersionHistoryClass"] = array();
$groupArray["VersionHistoryClass"][1] = "5";
$blockValues["VersionManagement"] =& $groupArray;
unset( $groupArray );
$groupArray["VersionHandling"] = "user-defined";
$blockValues["CopySettings"] =& $groupArray;
unset( $groupArray );
$groupArray["RepositoryDirectories"] = array();
$groupArray["RepositoryDirectories"][0] = "kernel/classes/datatypes";
$groupArray["ExtensionDirectories"] = array();
$groupArray["AvailableDataTypes"] = array();
$groupArray["AvailableDataTypes"][0] = "ezstring";
$groupArray["AvailableDataTypes"][1] = "eztext";
$groupArray["AvailableDataTypes"][2] = "ezxmltext";
$groupArray["AvailableDataTypes"][3] = "ezdate";
$groupArray["AvailableDataTypes"][4] = "ezdatetime";
$groupArray["AvailableDataTypes"][5] = "eztime";
$groupArray["AvailableDataTypes"][6] = "ezboolean";
$groupArray["AvailableDataTypes"][7] = "ezinteger";
$groupArray["AvailableDataTypes"][8] = "ezfloat";
$groupArray["AvailableDataTypes"][9] = "ezenum";
$groupArray["AvailableDataTypes"][10] = "ezobjectrelation";
$groupArray["AvailableDataTypes"][11] = "ezobjectrelationlist";
$groupArray["AvailableDataTypes"][12] = "ezimage";
$groupArray["AvailableDataTypes"][13] = "ezbinaryfile";
$groupArray["AvailableDataTypes"][14] = "ezmedia";
$groupArray["AvailableDataTypes"][15] = "ezauthor";
$groupArray["AvailableDataTypes"][16] = "ezurl";
$groupArray["AvailableDataTypes"][17] = "ezemail";
$groupArray["AvailableDataTypes"][18] = "ezoption";
$groupArray["AvailableDataTypes"][19] = "ezrangeoption";
$groupArray["AvailableDataTypes"][20] = "ezprice";
$groupArray["AvailableDataTypes"][21] = "ezuser";
$groupArray["AvailableDataTypes"][22] = "ezisbn";
$groupArray["AvailableDataTypes"][23] = "ezkeyword";
$groupArray["AvailableDataTypes"][24] = "ezsubtreesubscription";
$groupArray["AvailableDataTypes"][25] = "ezmatrix";
$groupArray["AvailableDataTypes"][26] = "ezselection";
$groupArray["AvailableDataTypes"][27] = "ezidentifier";
$groupArray["AvailableDataTypes"][28] = "ezinisetting";
$groupArray["AvailableDataTypes"][29] = "ezpackage";
$blockValues["DataTypeSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["ExtensionDirectories"] = array();
$blockValues["ActionSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["AvailableCustomTags"] = array();
$groupArray["AvailableCustomTags"][0] = "factbox";
$groupArray["AvailableCustomTags"][1] = "quote";
$groupArray["AvailableCustomTags"][2] = "strike";
$groupArray["AvailableCustomTags"][3] = "sub";
$groupArray["AvailableCustomTags"][4] = "sup";
$groupArray["IsInline"] = array();
$groupArray["IsInline"]["strike"] = "true";
$groupArray["IsInline"]["sub"] = "true";
$groupArray["IsInline"]["sup"] = "true";
$blockValues["CustomTagSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["AvailableClasses"] = array();
$groupArray["AvailableClasses"][0] = "html";
$blockValues["literal"] =& $groupArray;
unset( $groupArray );
$groupArray["RootNode"] = "2";
$groupArray["UserRootNode"] = "5";
$groupArray["MediaRootNode"] = "43";
$groupArray["SetupRootNode"] = "48";
$blockValues["NodeSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["DraftTimeout"] = "7200";
$blockValues["ClassSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["DefaultAssignment"] = "2";
$groupArray["ClassSpecificAssignment"] = array();
$groupArray["ClassSpecificAssignment"][0] = "user,user_group;users";
$blockValues["RelationAssignmentSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["ClassAttributeStartNode"] = array();
$groupArray["ClassAttributeStartNode"][0] = "240;AddRelatedImageToDataType";
$blockValues["ObjectRelationDataTypeSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["RootNodeList"] = array();
$groupArray["ClassList"] = array();
$blockValues["UnpublishSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["DefaultEditAlias"] = "medium";
$groupArray["DefaultEmbedAlias"] = "medium";
$blockValues["ImageSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["CompanyAddress"] = array();
$groupArray["CompanyAddress"][0] = "Postal Address";
$groupArray["CompanyAddress"][1] = "Visitor Address";
$groupArray["PersonContactInfo"] = array();
$groupArray["PersonContactInfo"][0] = "Phone";
$groupArray["PersonContactInfo"][1] = "Fax";
$groupArray["PersonContactInfo"][2] = "Email";
$groupArray["PersonContactInfo"][3] = "Homepage";
$groupArray["PersonContactInfo"][4] = "IM address";
$groupArray["CompanyContactInfo"] = array();
$groupArray["CompanyContactInfo"][0] = "Phone";
$groupArray["CompanyContactInfo"][1] = "Fax";
$groupArray["CompanyContactInfo"][2] = "Email";
$groupArray["CompanyContactInfo"][3] = "Homepage";
$blockValues["MatrixComponentSettings"] =& $groupArray;
unset( $groupArray );
$groupPlacementArray["AvailableSiteDesignList"] = array();
$groupPlacementArray["AvailableSiteDesignList"][0] = "settings/siteaccess/admin_acro/content.ini.append.php";
$groupPlacementArray["AvailableSiteDesignList"][1] = "settings/siteaccess/admin_acro/content.ini.append.php";
$groupPlacementArray["DefaultPreviewDesign"] = "settings/content.ini";
$groupPlacementArray["AllowChangeButtons"] = "settings/content.ini";
$groupPlacementArray["AllowVersionsButton"] = "settings/content.ini";
$blockValuesPlacement["VersionView"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["DefaultVersionHistoryLimit"] = "settings/content.ini";
$groupPlacementArray["VersionHistoryClass"] = array();
$groupPlacementArray["VersionHistoryClass"][1] = "settings/content.ini";
$blockValuesPlacement["VersionManagement"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["VersionHandling"] = "settings/content.ini";
$blockValuesPlacement["CopySettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["RepositoryDirectories"] = array();
$groupPlacementArray["RepositoryDirectories"][0] = "settings/content.ini";
$groupPlacementArray["ExtensionDirectories"] = array();
$groupPlacementArray["ExtensionDirectories"][0] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"] = array();
$groupPlacementArray["AvailableDataTypes"][0] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][1] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][2] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][3] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][4] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][5] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][6] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][7] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][8] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][9] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][10] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][11] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][12] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][13] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][14] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][15] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][16] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][17] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][18] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][19] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][20] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][21] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][22] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][23] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][24] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][25] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][26] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][27] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][28] = "settings/content.ini";
$groupPlacementArray["AvailableDataTypes"][29] = "settings/content.ini";
$blockValuesPlacement["DataTypeSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["ExtensionDirectories"] = array();
$groupPlacementArray["ExtensionDirectories"][0] = "settings/content.ini";
$blockValuesPlacement["ActionSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["AvailableCustomTags"] = array();
$groupPlacementArray["AvailableCustomTags"][0] = "settings/content.ini";
$groupPlacementArray["AvailableCustomTags"][1] = "settings/content.ini";
$groupPlacementArray["AvailableCustomTags"][2] = "settings/content.ini";
$groupPlacementArray["AvailableCustomTags"][3] = "settings/content.ini";
$groupPlacementArray["AvailableCustomTags"][4] = "settings/content.ini";
$groupPlacementArray["IsInline"] = array();
$groupPlacementArray["IsInline"]["strike"] = "settings/content.ini";
$groupPlacementArray["IsInline"]["sub"] = "settings/content.ini";
$groupPlacementArray["IsInline"]["sup"] = "settings/content.ini";
$blockValuesPlacement["CustomTagSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["AvailableClasses"] = array();
$groupPlacementArray["AvailableClasses"][0] = "settings/content.ini";
$blockValuesPlacement["literal"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["RootNode"] = "settings/content.ini";
$groupPlacementArray["UserRootNode"] = "settings/content.ini";
$groupPlacementArray["MediaRootNode"] = "settings/content.ini";
$groupPlacementArray["SetupRootNode"] = "settings/content.ini";
$blockValuesPlacement["NodeSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["DraftTimeout"] = "settings/content.ini";
$blockValuesPlacement["ClassSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["DefaultAssignment"] = "settings/content.ini";
$groupPlacementArray["ClassSpecificAssignment"] = array();
$groupPlacementArray["ClassSpecificAssignment"][0] = "settings/content.ini";
$blockValuesPlacement["RelationAssignmentSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["ClassAttributeStartNode"] = array();
$groupPlacementArray["ClassAttributeStartNode"][0] = "settings/content.ini";
$blockValuesPlacement["ObjectRelationDataTypeSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["RootNodeList"] = array();
$groupPlacementArray["RootNodeList"][0] = "settings/content.ini";
$groupPlacementArray["ClassList"] = array();
$groupPlacementArray["ClassList"][0] = "settings/content.ini";
$blockValuesPlacement["UnpublishSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["DefaultEditAlias"] = "settings/content.ini";
$groupPlacementArray["DefaultEmbedAlias"] = "settings/content.ini";
$blockValuesPlacement["ImageSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["CompanyAddress"] = array();
$groupPlacementArray["CompanyAddress"][0] = "settings/content.ini";
$groupPlacementArray["CompanyAddress"][1] = "settings/content.ini";
$groupPlacementArray["PersonContactInfo"] = array();
$groupPlacementArray["PersonContactInfo"][0] = "settings/content.ini";
$groupPlacementArray["PersonContactInfo"][1] = "settings/content.ini";
$groupPlacementArray["PersonContactInfo"][2] = "settings/content.ini";
$groupPlacementArray["PersonContactInfo"][3] = "settings/content.ini";
$groupPlacementArray["PersonContactInfo"][4] = "settings/content.ini";
$groupPlacementArray["CompanyContactInfo"] = array();
$groupPlacementArray["CompanyContactInfo"][0] = "settings/content.ini";
$groupPlacementArray["CompanyContactInfo"][1] = "settings/content.ini";
$groupPlacementArray["CompanyContactInfo"][2] = "settings/content.ini";
$groupPlacementArray["CompanyContactInfo"][3] = "settings/content.ini";
$blockValuesPlacement["MatrixComponentSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );

?>