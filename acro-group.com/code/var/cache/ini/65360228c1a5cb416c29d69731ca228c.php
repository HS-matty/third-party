<?php
$eZIniCacheCodeDate = 1043407542;
$charset = "iso-8859-1";
$groupArray["DatabasePluginPath"] = "";
$groupArray["DatabaseImplementation"] = "ezmysql";
$groupArray["Server"] = "localhost";
$groupArray["User"] = "root";
$groupArray["Password"] = "";
$groupArray["Database"] = "nextgen";
$groupArray["UseSlaveServer"] = "disabled";
$groupArray["ConnectRetries"] = "0";
$groupArray["Charset"] = "";
$groupArray["UseBuiltinEncoding"] = "true";
$groupArray["Socket"] = "disabled";
$groupArray["SQLOutput"] = "disabled";
$groupArray["UsePersistentConnection"] = "disabled";
$blockValues["DatabaseSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["ExtensionDirectory"] = "extension";
$groupArray["ActiveExtensions"] = array();
$groupArray["ActiveAccessExtensions"] = array();
$blockValues["ExtensionSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["EmailReceiver"] = "";
$blockValues["InformationCollectionSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["SessionTimeout"] = "259200";
$groupArray["ActivityTimeout"] = "3600";
$groupArray["CookieTimeout"] = "";
$groupArray["SessionNameHandler"] = "custom";
$groupArray["SessionNamePrefix"] = "eZSESSID";
$groupArray["SessionNamePerSiteAccess"] = "enabled";
$blockValues["Session"] =& $groupArray;
unset( $groupArray );
$groupArray["DebugOutput"] = "disabled";
$groupArray["ScriptDebugOutput"] = "disabled";
$groupArray["DebugByIP"] = "disabled";
$groupArray["DebugIPList"] = array();
$groupArray["Debug"] = "inline";
$groupArray["DebugRedirection"] = "disabled";
$blockValues["DebugSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["Translation"] = "enabled";
$groupArray["WildcardTranslation"] = "enabled";
$groupArray["MaximumWildcardIterations"] = "20";
$groupArray["NodeTranslation"] = "enabled";
$blockValues["URLTranslator"] =& $groupArray;
unset( $groupArray );
$groupArray["SiteName"] = "eZ publish";
$groupArray["SiteURL"] = "example.com";
$groupArray["MetaDataArray"] = array();
$groupArray["MetaDataArray"]["author"] = "eZ systems";
$groupArray["MetaDataArray"]["copyright"] = "eZ systems";
$groupArray["MetaDataArray"]["description"] = "Content Management System";
$groupArray["MetaDataArray"]["keywords"] = "cms, publish, e-commerce, content management, development framework";
$groupArray["Dir"] = "";
$groupArray["IndexPage"] = "/content/view/full/72/";
$groupArray["ErrorHandler"] = "displayerror";
$groupArray["DefaultPage"] = "/content/view/full/2/";
$groupArray["DefaultAccess"] = "user_acro";
$groupArray["LoginPage"] = "custom";
$groupArray["SSLPort"] = "443";
$groupArray["SiteList"] = array();
$groupArray["SiteList"][0] = "acro";
$groupArray["SiteList"][1] = "acro_admin";
$groupArray["SiteList"][2] = "user_acro";
$blockValues["SiteSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["SearchEngine"] = "eZSearchEngine";
$groupArray["SearchViewHandling"] = "default";
$groupArray["LogSearchStats"] = "enabled";
$groupArray["MaximumSearchLimit"] = "30";
$groupArray["AllowEmptySearch"] = "disabled";
$groupArray["EnableWildcard"] = "false";
$groupArray["MinCharacterWildcard"] = "3";
$groupArray["StopWordThresholdValue"] = "100";
$groupArray["StopWordThresholdPercent"] = "60";
$groupArray["DelayedIndexing"] = "disabled";
$blockValues["SearchSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["GeneratePasswordIfEmpty"] = "true";
$groupArray["GeneratePasswordLength"] = "6";
$groupArray["AnonymousUserID"] = "10";
$groupArray["DefaultUserPlacement"] = "12";
$groupArray["DefaultSectionID"] = "1";
$groupArray["RegistrationFeedback"] = "email";
$groupArray["VerifyUserEmail"] = "enabled";
$groupArray["RegistrationEmail"] = "";
$groupArray["UserClassID"] = "4";
$groupArray["UserGroupClassID"] = "3";
$groupArray["UserClassGroupID"] = "2";
$groupArray["UserCreatorID"] = "14";
$groupArray["SiteName"] = "ez.no";
$groupArray["HashType"] = "md5_user";
$groupArray["UpdateHash"] = "true";
$groupArray["AuthenticateMatch"] = "login;email";
$groupArray["RequireUniqueEmail"] = "true";
$groupArray["UseSpecialCharacters"] = "false";
$groupArray["LogoutRedirect"] = "/user/login";
$groupArray["LoginHandler"] = array();
$groupArray["LoginHandler"][0] = "standard";
$blockValues["UserSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["ForceVirtualHost"] = "true";
$groupArray["CheckValidity"] = "false";
$groupArray["RequireUserLogin"] = "yes";
$groupArray["AvailableSiteAccessList"] = array();
$groupArray["AvailableSiteAccessList"][0] = "admin";
$groupArray["AvailableSiteAccessList"][1] = "acro";
$groupArray["AvailableSiteAccessList"][2] = "acro_admin";
$groupArray["DebugAccess"] = "disabled";
$groupArray["DebugExtraAccess"] = "disabled";
$groupArray["AnonymousAccessList"] = array();
$groupArray["AnonymousAccessList"][0] = "user/register";
$groupArray["AnonymousAccessList"][1] = "user/success";
$groupArray["AnonymousAccessList"][2] = "user/activate";
$groupArray["MatchOrder"] = "host,port";
$groupArray["URIMatchType"] = "element";
$groupArray["URIMatchElement"] = "1";
$groupArray["URIMatchRegexp"] = "^/([^/]+)/";
$groupArray["URIMatchRegexpItem"] = "1";
$groupArray["HostMatchType"] = "map";
$groupArray["HostMatchElement"] = "0";
$groupArray["HostMatchRegexp"] = "^(.+)\\.example\\.com\$";
$groupArray["HostMatchRegexpItem"] = "1";
$groupArray["HostMatchSubtextPre"] = "";
$groupArray["HostMatchSubtextPost"] = ".example.com";
$groupArray["IndexMatchType"] = "regexp";
$groupArray["IndexMatchElement"] = "1";
$groupArray["IndexMatchRegexp"] = "^/index_(.+)\\.php\$";
$groupArray["IndexMatchRegexpItem"] = "1";
$groupArray["IndexMatchSubtextPre"] = "index_";
$groupArray["IndexMatchSubtextPost"] = ".php";
$groupArray["PathPrefix"] = "";
$groupArray["HostMatchMapItems"] = array();
$groupArray["HostMatchMapItems"][0] = "127.0.0.14;acro";
$groupArray["HostMatchMapItems"][1] = "127.0.0.14:80;acro_admin";
$blockValues["SiteAccessSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["1337"] = "user";
$groupArray["1338"] = "admin";
$groupArray["80"] = "acro_user";
$groupArray["81"] = "acro_admin";
$blockValues["PortAccessSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["EnableCaching"] = "true";
$groupArray["PolicyOmitList"] = array();
$groupArray["PolicyOmitList"][0] = "user/login";
$groupArray["PolicyOmitList"][1] = "user/logout";
$groupArray["PolicyOmitList"][2] = "user/register";
$groupArray["PolicyOmitList"][3] = "user/activate";
$groupArray["PolicyOmitList"][4] = "user/success";
$groupArray["PolicyOmitList"][5] = "user/forgotpassword";
$groupArray["PolicyOmitList"][6] = "layout";
$groupArray["PolicyOmitList"][7] = "manual";
$groupArray["PolicyOmitList"][8] = "ezinfo";
$groupArray["ShowAccessDeniedReason"] = "enabled";
$blockValues["RoleSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["StandardDesign"] = "standard";
$groupArray["SiteDesign"] = "admin";
$groupArray["AdditionalSiteDesignList"] = array();
$blockValues["DesignSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["PageLayout"] = "setup_pagelayout.tpl";
$groupArray["CriticalTests"] = "directory_permissions;phpversion;database_extensions;image_conversion;open_basedir;safe_mode;memory_limit;execution_time;php_magicquotes_runtime;accept_path_info";
$groupArray["OptionalTests"] = "php_magicquotes;zlib_extension;mbstring_extension;imagegd_extension;imagemagick_program;database_all_extensions;file_upload;php_register_globals;texttoimage_functions";
$groupArray["OverrideSiteDesign"] = "standard";
$blockValues["SetupSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["Locale"] = "eng-GB";
$groupArray["HTTPLocale"] = "";
$groupArray["SystemLocale"] = "";
$groupArray["ContentObjectLocale"] = "eng-GB";
$groupArray["ContentXMLCharset"] = "enabled";
$groupArray["TextTranslation"] = "enabled";
$groupArray["TranslationCache"] = "enabled";
$groupArray["Debug"] = "disabled";
$groupArray["DevelopmentMode"] = "disabled";
$groupArray["TranslationRepository"] = "share/translations/";
$groupArray["TranslationExtensions"] = array();
$blockValues["RegionalSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["BinaryUnits"] = "byte;bit";
$groupArray["UseSIUnits"] = "false";
$blockValues["UnitSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["TemporaryDir"] = "/tmp/";
$groupArray["TemporaryPermissions"] = "0777";
$groupArray["StorageDir"] = "storage";
$groupArray["StorageDirPermissions"] = "0777";
$groupArray["StorageFilePermissions"] = "0666";
$groupArray["DirDepth"] = "3";
$groupArray["VarDir"] = "var";
$groupArray["CacheDir"] = "cache";
$groupArray["LogDir"] = "log";
$blockValues["FileSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["AutoloadPath"] = "";
$groupArray["AutoloadPathList"] = array();
$groupArray["AutoloadPathList"][0] = "lib/eztemplate/classes/";
$groupArray["AutoloadPathList"][1] = "kernel/common/";
$groupArray["AutoloadPathList"][2] = "lib/ezpdf/classes/";
$groupArray["ExtensionAutoloadPath"] = array();
$groupArray["Debug"] = "disabled";
$groupArray["ShowXHTMLCode"] = "enabled";
$groupArray["NodeTreeCaching"] = "disabled";
$groupArray["TemplateCompile"] = "enabled";
$groupArray["TemplateCache"] = "enabled";
$groupArray["CompileComments"] = "disabled";
$groupArray["CompileAccumulators"] = "disabled";
$groupArray["CompileTimingPoints"] = "disabled";
$groupArray["CompileResourceFallback"] = "disabled";
$groupArray["CompileNodePlacements"] = "enabled";
$groupArray["CompileExecution"] = "enabled";
$groupArray["CompileAlwaysGenerate"] = "disabled";
$groupArray["CompileIncludeNodeTree"] = array();
$blockValues["TemplateSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["TranslationList"] = "eng-GB;nor-NO;nno-NO;eng-US";
$groupArray["SurplusNode"] = "3";
$groupArray["CacheDir"] = "content";
$groupArray["ViewCaching"] = "enabled";
$groupArray["CachedViewModes"] = "full;sitemap";
$groupArray["ComplexDisplayViewModes"] = "sitemap";
$groupArray["CacheThreshold"] = "120";
$groupArray["EditDirtyObjectAction"] = "showversions";
$groupArray["PreViewCache"] = "disabled";
$groupArray["PreCacheSiteaccessArray"] = array();
$groupArray["PreCacheSiteaccessArray"][0] = "admin";
$groupArray["PreCacheSiteaccessArray"][1] = "base";
$blockValues["ContentSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["Transport"] = "SMTP";
$groupArray["TransportServer"] = "";
$groupArray["TransportPort"] = "25";
$groupArray["TransportUser"] = "";
$groupArray["TransportPassword"] = "";
$groupArray["AdminEmail"] = "";
$groupArray["EmailSender"] = "";
$groupArray["AllowedCharsets"] = array();
$groupArray["AllowedCharsets"][0] = "us-ascii";
$groupArray["AllowedCharsets"][1] = "utf-8";
$groupArray["AllowedCharsets"][2] = "iso-8859-1";
$groupArray["AllowedCharsets"][3] = "iso-8859-15";
$groupArray["AllowedCharsets"][4] = "cp1252";
$groupArray["OutputCharset"] = "utf-8";
$groupArray["ContentType"] = "text/plain";
$groupArray["HeaderLineEnding"] = "%0D%0A";
$blockValues["MailSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["ShippingCost"] = "12";
$blockValues["SimpleShippingWorkflow"] =& $groupArray;
unset( $groupArray );
$groupArray["ClearBasketOnCheckout"] = "disabled";
$blockValues["ShopSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["Cache"] = "enabled";
$blockValues["OverrideSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["Module"] = "disabled";
$blockValues["FormProcessSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["DefaultVersion"] = "1.0";
$groupArray["AvailableVersionList"] = array();
$groupArray["AvailableVersionList"][0] = "1.0";
$groupArray["AvailableVersionList"][1] = "2.0";
$blockValues["RSSSettings"] =& $groupArray;
unset( $groupArray );
$groupPlacementArray["DatabasePluginPath"] = "settings/site.ini";
$groupPlacementArray["DatabaseImplementation"] = "settings/site.ini";
$groupPlacementArray["Server"] = "settings/site.ini";
$groupPlacementArray["User"] = "settings/site.ini";
$groupPlacementArray["Password"] = "settings/site.ini";
$groupPlacementArray["Database"] = "settings/site.ini";
$groupPlacementArray["UseSlaveServer"] = "settings/site.ini";
$groupPlacementArray["ConnectRetries"] = "settings/site.ini";
$groupPlacementArray["Charset"] = "settings/site.ini";
$groupPlacementArray["UseBuiltinEncoding"] = "settings/site.ini";
$groupPlacementArray["Socket"] = "settings/site.ini";
$groupPlacementArray["SQLOutput"] = "settings/site.ini";
$groupPlacementArray["UsePersistentConnection"] = "settings/site.ini";
$blockValuesPlacement["DatabaseSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["ExtensionDirectory"] = "settings/site.ini";
$groupPlacementArray["ActiveExtensions"] = array();
$groupPlacementArray["ActiveExtensions"][0] = "settings/site.ini";
$groupPlacementArray["ActiveExtensions"][1] = "settings/override/site.ini.append.php";
$groupPlacementArray["ActiveAccessExtensions"] = array();
$groupPlacementArray["ActiveAccessExtensions"][0] = "settings/site.ini";
$blockValuesPlacement["ExtensionSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["EmailReceiver"] = "settings/site.ini";
$blockValuesPlacement["InformationCollectionSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["SessionTimeout"] = "settings/site.ini";
$groupPlacementArray["ActivityTimeout"] = "settings/site.ini";
$groupPlacementArray["CookieTimeout"] = "settings/site.ini";
$groupPlacementArray["SessionNameHandler"] = "settings/override/site.ini.append.php";
$groupPlacementArray["SessionNamePrefix"] = "settings/site.ini";
$groupPlacementArray["SessionNamePerSiteAccess"] = "settings/site.ini";
$blockValuesPlacement["Session"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["DebugOutput"] = "settings/site.ini";
$groupPlacementArray["ScriptDebugOutput"] = "settings/site.ini";
$groupPlacementArray["DebugByIP"] = "settings/site.ini";
$groupPlacementArray["DebugIPList"] = array();
$groupPlacementArray["DebugIPList"][0] = "settings/site.ini";
$groupPlacementArray["Debug"] = "settings/site.ini";
$groupPlacementArray["DebugRedirection"] = "settings/site.ini";
$blockValuesPlacement["DebugSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["Translation"] = "settings/override/site.ini.append.php";
$groupPlacementArray["WildcardTranslation"] = "settings/site.ini";
$groupPlacementArray["MaximumWildcardIterations"] = "settings/site.ini";
$groupPlacementArray["NodeTranslation"] = "settings/override/site.ini.append.php";
$blockValuesPlacement["URLTranslator"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["SiteName"] = "settings/site.ini";
$groupPlacementArray["SiteURL"] = "settings/site.ini";
$groupPlacementArray["MetaDataArray"] = array();
$groupPlacementArray["MetaDataArray"]["author"] = "settings/site.ini";
$groupPlacementArray["MetaDataArray"]["copyright"] = "settings/site.ini";
$groupPlacementArray["MetaDataArray"]["description"] = "settings/site.ini";
$groupPlacementArray["MetaDataArray"]["keywords"] = "settings/site.ini";
$groupPlacementArray["Dir"] = "settings/site.ini";
$groupPlacementArray["IndexPage"] = "settings/site.ini";
$groupPlacementArray["ErrorHandler"] = "settings/site.ini";
$groupPlacementArray["DefaultPage"] = "settings/site.ini";
$groupPlacementArray["DefaultAccess"] = "settings/override/site.ini.append.php";
$groupPlacementArray["LoginPage"] = "settings/site.ini";
$groupPlacementArray["SSLPort"] = "settings/site.ini";
$groupPlacementArray["SiteList"] = array();
$groupPlacementArray["SiteList"][0] = "settings/override/site.ini.append.php";
$groupPlacementArray["SiteList"][1] = "settings/override/site.ini.append.php";
$groupPlacementArray["SiteList"][2] = "settings/override/site.ini.append.php";
$blockValuesPlacement["SiteSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["SearchEngine"] = "settings/site.ini";
$groupPlacementArray["SearchViewHandling"] = "settings/site.ini";
$groupPlacementArray["LogSearchStats"] = "settings/site.ini";
$groupPlacementArray["MaximumSearchLimit"] = "settings/site.ini";
$groupPlacementArray["AllowEmptySearch"] = "settings/site.ini";
$groupPlacementArray["EnableWildcard"] = "settings/site.ini";
$groupPlacementArray["MinCharacterWildcard"] = "settings/site.ini";
$groupPlacementArray["StopWordThresholdValue"] = "settings/site.ini";
$groupPlacementArray["StopWordThresholdPercent"] = "settings/site.ini";
$groupPlacementArray["DelayedIndexing"] = "settings/site.ini";
$blockValuesPlacement["SearchSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["GeneratePasswordIfEmpty"] = "settings/site.ini";
$groupPlacementArray["GeneratePasswordLength"] = "settings/site.ini";
$groupPlacementArray["AnonymousUserID"] = "settings/site.ini";
$groupPlacementArray["DefaultUserPlacement"] = "settings/site.ini";
$groupPlacementArray["DefaultSectionID"] = "settings/site.ini";
$groupPlacementArray["RegistrationFeedback"] = "settings/site.ini";
$groupPlacementArray["VerifyUserEmail"] = "settings/site.ini";
$groupPlacementArray["RegistrationEmail"] = "settings/site.ini";
$groupPlacementArray["UserClassID"] = "settings/site.ini";
$groupPlacementArray["UserGroupClassID"] = "settings/site.ini";
$groupPlacementArray["UserClassGroupID"] = "settings/site.ini";
$groupPlacementArray["UserCreatorID"] = "settings/site.ini";
$groupPlacementArray["SiteName"] = "settings/site.ini";
$groupPlacementArray["HashType"] = "settings/site.ini";
$groupPlacementArray["UpdateHash"] = "settings/site.ini";
$groupPlacementArray["AuthenticateMatch"] = "settings/site.ini";
$groupPlacementArray["RequireUniqueEmail"] = "settings/site.ini";
$groupPlacementArray["UseSpecialCharacters"] = "settings/site.ini";
$groupPlacementArray["LogoutRedirect"] = "settings/site.ini";
$groupPlacementArray["LoginHandler"] = array();
$groupPlacementArray["LoginHandler"][0] = "settings/site.ini";
$blockValuesPlacement["UserSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["ForceVirtualHost"] = "settings/override/site.ini.append.php";
$groupPlacementArray["CheckValidity"] = "settings/override/site.ini.append.php";
$groupPlacementArray["RequireUserLogin"] = "settings/site.ini";
$groupPlacementArray["AvailableSiteAccessList"] = array();
$groupPlacementArray["AvailableSiteAccessList"][0] = "settings/site.ini";
$groupPlacementArray["AvailableSiteAccessList"][1] = "settings/override/site.ini.append.php";
$groupPlacementArray["AvailableSiteAccessList"][2] = "settings/override/site.ini.append.php";
$groupPlacementArray["DebugAccess"] = "settings/site.ini";
$groupPlacementArray["DebugExtraAccess"] = "settings/site.ini";
$groupPlacementArray["AnonymousAccessList"] = array();
$groupPlacementArray["AnonymousAccessList"][0] = "settings/site.ini";
$groupPlacementArray["AnonymousAccessList"][1] = "settings/site.ini";
$groupPlacementArray["AnonymousAccessList"][2] = "settings/site.ini";
$groupPlacementArray["MatchOrder"] = "settings/override/site.ini.append.php";
$groupPlacementArray["URIMatchType"] = "settings/site.ini";
$groupPlacementArray["URIMatchElement"] = "settings/site.ini";
$groupPlacementArray["URIMatchRegexp"] = "settings/site.ini";
$groupPlacementArray["URIMatchRegexpItem"] = "settings/site.ini";
$groupPlacementArray["HostMatchType"] = "settings/override/site.ini.append.php";
$groupPlacementArray["HostMatchElement"] = "settings/site.ini";
$groupPlacementArray["HostMatchRegexp"] = "settings/site.ini";
$groupPlacementArray["HostMatchRegexpItem"] = "settings/site.ini";
$groupPlacementArray["HostMatchSubtextPre"] = "settings/site.ini";
$groupPlacementArray["HostMatchSubtextPost"] = "settings/site.ini";
$groupPlacementArray["IndexMatchType"] = "settings/site.ini";
$groupPlacementArray["IndexMatchElement"] = "settings/site.ini";
$groupPlacementArray["IndexMatchRegexp"] = "settings/site.ini";
$groupPlacementArray["IndexMatchRegexpItem"] = "settings/site.ini";
$groupPlacementArray["IndexMatchSubtextPre"] = "settings/site.ini";
$groupPlacementArray["IndexMatchSubtextPost"] = "settings/site.ini";
$groupPlacementArray["PathPrefix"] = "settings/site.ini";
$groupPlacementArray["HostMatchMapItems"] = array();
$groupPlacementArray["HostMatchMapItems"][0] = "settings/override/site.ini.append.php";
$groupPlacementArray["HostMatchMapItems"][1] = "settings/override/site.ini.append.php";
$blockValuesPlacement["SiteAccessSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["1337"] = "settings/site.ini";
$groupPlacementArray["1338"] = "settings/site.ini";
$groupPlacementArray["80"] = "settings/override/site.ini.append.php";
$groupPlacementArray["81"] = "settings/override/site.ini.append.php";
$blockValuesPlacement["PortAccessSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["EnableCaching"] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"] = array();
$groupPlacementArray["PolicyOmitList"][0] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"][1] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"][2] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"][3] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"][4] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"][5] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"][6] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"][7] = "settings/site.ini";
$groupPlacementArray["PolicyOmitList"][8] = "settings/site.ini";
$groupPlacementArray["ShowAccessDeniedReason"] = "settings/site.ini";
$blockValuesPlacement["RoleSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["StandardDesign"] = "settings/site.ini";
$groupPlacementArray["SiteDesign"] = "settings/site.ini";
$groupPlacementArray["AdditionalSiteDesignList"] = array();
$groupPlacementArray["AdditionalSiteDesignList"][0] = "settings/site.ini";
$blockValuesPlacement["DesignSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["PageLayout"] = "settings/site.ini";
$groupPlacementArray["CriticalTests"] = "settings/site.ini";
$groupPlacementArray["OptionalTests"] = "settings/site.ini";
$groupPlacementArray["OverrideSiteDesign"] = "settings/site.ini";
$blockValuesPlacement["SetupSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["Locale"] = "settings/site.ini";
$groupPlacementArray["HTTPLocale"] = "settings/site.ini";
$groupPlacementArray["SystemLocale"] = "settings/site.ini";
$groupPlacementArray["ContentObjectLocale"] = "settings/site.ini";
$groupPlacementArray["ContentXMLCharset"] = "settings/site.ini";
$groupPlacementArray["TextTranslation"] = "settings/site.ini";
$groupPlacementArray["TranslationCache"] = "settings/site.ini";
$groupPlacementArray["Debug"] = "settings/site.ini";
$groupPlacementArray["DevelopmentMode"] = "settings/site.ini";
$groupPlacementArray["TranslationRepository"] = "settings/site.ini";
$groupPlacementArray["TranslationExtensions"] = array();
$groupPlacementArray["TranslationExtensions"][0] = "settings/site.ini";
$blockValuesPlacement["RegionalSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["BinaryUnits"] = "settings/site.ini";
$groupPlacementArray["UseSIUnits"] = "settings/site.ini";
$blockValuesPlacement["UnitSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["TemporaryDir"] = "settings/site.ini";
$groupPlacementArray["TemporaryPermissions"] = "settings/site.ini";
$groupPlacementArray["StorageDir"] = "settings/site.ini";
$groupPlacementArray["StorageDirPermissions"] = "settings/site.ini";
$groupPlacementArray["StorageFilePermissions"] = "settings/site.ini";
$groupPlacementArray["DirDepth"] = "settings/site.ini";
$groupPlacementArray["VarDir"] = "settings/site.ini";
$groupPlacementArray["CacheDir"] = "settings/site.ini";
$groupPlacementArray["LogDir"] = "settings/site.ini";
$blockValuesPlacement["FileSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["AutoloadPath"] = "settings/site.ini";
$groupPlacementArray["AutoloadPathList"] = array();
$groupPlacementArray["AutoloadPathList"][0] = "settings/site.ini";
$groupPlacementArray["AutoloadPathList"][1] = "settings/site.ini";
$groupPlacementArray["AutoloadPathList"][2] = "settings/site.ini";
$groupPlacementArray["ExtensionAutoloadPath"] = array();
$groupPlacementArray["ExtensionAutoloadPath"][0] = "settings/site.ini";
$groupPlacementArray["Debug"] = "settings/site.ini";
$groupPlacementArray["ShowXHTMLCode"] = "settings/site.ini";
$groupPlacementArray["NodeTreeCaching"] = "settings/site.ini";
$groupPlacementArray["TemplateCompile"] = "settings/site.ini";
$groupPlacementArray["TemplateCache"] = "settings/site.ini";
$groupPlacementArray["CompileComments"] = "settings/site.ini";
$groupPlacementArray["CompileAccumulators"] = "settings/site.ini";
$groupPlacementArray["CompileTimingPoints"] = "settings/site.ini";
$groupPlacementArray["CompileResourceFallback"] = "settings/site.ini";
$groupPlacementArray["CompileNodePlacements"] = "settings/site.ini";
$groupPlacementArray["CompileExecution"] = "settings/site.ini";
$groupPlacementArray["CompileAlwaysGenerate"] = "settings/site.ini";
$groupPlacementArray["CompileIncludeNodeTree"] = array();
$groupPlacementArray["CompileIncludeNodeTree"][0] = "settings/site.ini";
$blockValuesPlacement["TemplateSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["TranslationList"] = "settings/site.ini";
$groupPlacementArray["SurplusNode"] = "settings/site.ini";
$groupPlacementArray["CacheDir"] = "settings/site.ini";
$groupPlacementArray["ViewCaching"] = "settings/site.ini";
$groupPlacementArray["CachedViewModes"] = "settings/site.ini";
$groupPlacementArray["ComplexDisplayViewModes"] = "settings/site.ini";
$groupPlacementArray["CacheThreshold"] = "settings/site.ini";
$groupPlacementArray["EditDirtyObjectAction"] = "settings/site.ini";
$groupPlacementArray["PreViewCache"] = "settings/site.ini";
$groupPlacementArray["PreCacheSiteaccessArray"] = array();
$groupPlacementArray["PreCacheSiteaccessArray"][0] = "settings/site.ini";
$groupPlacementArray["PreCacheSiteaccessArray"][1] = "settings/site.ini";
$blockValuesPlacement["ContentSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["Transport"] = "settings/override/site.ini.append.php";
$groupPlacementArray["TransportServer"] = "settings/override/site.ini.append.php";
$groupPlacementArray["TransportPort"] = "settings/site.ini";
$groupPlacementArray["TransportUser"] = "settings/override/site.ini.append.php";
$groupPlacementArray["TransportPassword"] = "settings/override/site.ini.append.php";
$groupPlacementArray["AdminEmail"] = "settings/override/site.ini.append.php";
$groupPlacementArray["EmailSender"] = "settings/override/site.ini.append.php";
$groupPlacementArray["AllowedCharsets"] = array();
$groupPlacementArray["AllowedCharsets"][0] = "settings/site.ini";
$groupPlacementArray["AllowedCharsets"][1] = "settings/site.ini";
$groupPlacementArray["AllowedCharsets"][2] = "settings/site.ini";
$groupPlacementArray["AllowedCharsets"][3] = "settings/site.ini";
$groupPlacementArray["AllowedCharsets"][4] = "settings/site.ini";
$groupPlacementArray["OutputCharset"] = "settings/site.ini";
$groupPlacementArray["ContentType"] = "settings/site.ini";
$groupPlacementArray["HeaderLineEnding"] = "settings/site.ini";
$blockValuesPlacement["MailSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["ShippingCost"] = "settings/site.ini";
$blockValuesPlacement["SimpleShippingWorkflow"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["ClearBasketOnCheckout"] = "settings/site.ini";
$blockValuesPlacement["ShopSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["Cache"] = "settings/site.ini";
$blockValuesPlacement["OverrideSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["Module"] = "settings/site.ini";
$blockValuesPlacement["FormProcessSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["DefaultVersion"] = "settings/site.ini";
$groupPlacementArray["AvailableVersionList"] = array();
$groupPlacementArray["AvailableVersionList"][0] = "settings/site.ini";
$groupPlacementArray["AvailableVersionList"][1] = "settings/site.ini";
$blockValuesPlacement["RSSSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );

?>