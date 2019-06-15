/*
@Goto NoRexx
*/

/* REXX-Script to create Terminate-Folder, made by Martin Lorensen */
/* Modified by Bo Bendtsen */

/* Init */
Cls
Say "Creating folder on WPS for Terminate. Please wait..."

Call RxFuncAdd 'SysLoadFuncs', 'RexxUtil', 'SysLoadFuncs'
Call SysLoadFuncs

TerDir=Directory()
TerDir=SubStr(TerDir,1,LastPos('\',TerDir))
Say "Terminate should be installed in "TerDir"."
Say "If it isn't, this script would not work."
ObjMode="Replace"
rc=0

/* The Folder */
Class = "WPFolder"
Location = "<WP_DESKTOP>"
Title = "Terminate"
SetupString = "OBJECTID=<TER>;ICONFILE="TerDir"OS2\T-OS2.ICO;BACKGROUND="TerDir"OS2\T-OS2.BMP;"
rc = rc + (SysCreateObject(Class,Title,Location,SetupString,ObjMode)<>1)

/* The Programs in the folder */
ObjMode="UpDate"
Class = "WPProgram"
Location = "<TER>"

Title = "Why register?"
SetupString = "OBJECTID=<TERREGDOC>;ICONFILE="TerDir"OS2\T-OS2-2.ICO;EXENAME=E.EXE;PARAMETERS="TerDir"YOUGET.DOC;"
rc = rc + (SysCreateObject(Class,Title,Location,SetupString,ObjMode)<>1)

Title = "Terminate & OS/2"
SetupString = "OBJECTID=<TEROS2DOC>;ICONFILE="TerDir"OS2\T-OS2-2.ICO;EXENAME=E.EXE;PARAMETERS="TerDir"OS2\OS2.DOC;"
rc = rc + (SysCreateObject(Class,Title,Location,SetupString,ObjMode)<>1)

Title = "File Manager"
SetupString ="OBJECTID=<TERFM>;ICONFILE="TerDir"OS2\T-FM.ICO;PROGTYPE=VDM;EXENAME="TerDir"TERMINAT.EXE;PARAMETERS=/F;STARTUPDIR="TerDir";"
rc = rc + (SysCreateObject(Class,Title,Location,SetupString,ObjMode)<>1)

Title = "TerMail"
SetupString = "OBJECTID=<TerMail>;ICONFILE="TerDir"OS2\TM-OS2.ICO;PROGTYPE=VDM;EXENAME="TerDir"TerMail\TM.EXE;STARTUPDIR="TerDir"TerMail;"
rc = rc + (SysCreateObject(Class,Title,Location,SetupString,ObjMode)<>1)

Title = "Terminate"
SetupString ="OBJECTID=<TEREXE>;ICONFILE="TerDir"OS2\T-OS2.ICO;PROGTYPE=VDM;EXENAME="TerDir"TERMINAT.EXE;STARTUPDIR="TerDir";"
rc = rc + (SysCreateObject(Class,Title,Location,SetupString,ObjMode)<>1)

/* Open folder */
Class = "WPFolder"
Location = "<WP_DESKTOP>"
Title = "Terminate"
SetupString = "OBJECTID=<TER>;OPEN=Default;"
rc = rc + (SysCreateObject(Class,Title,Location,SetupString,ObjMode)<>1)

Say
Say "Terminate folder created. "RC" problem(s) detected."
Exit;

/* Users without REXX-support! */

:NoRexx
@Echo Off
Echo FATAL ERROR: No REXX-suport is installed.
Echo Please install REXX and then try again.

