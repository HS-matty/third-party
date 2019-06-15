@ECHO OFF

REM
REM This is the BEFORMSG.BAT file for TerMail.
REM
REM If you have several programs to run before you edit your message
REM then you could use this batch file. We will try to gather as many
REM possible settings for all kind of programs here.
REM
REM Programs that currently would use such a batch file would be
REM
REM Spell-checkers
REM Tagline/originline managers
REM Text formatting programs such as TmNice
REM
REM %1 will be the GROUP name in uppercase letters: INTER, GERMAN etc.
REM This could be used to determine different spellers or tagline
REM editors for different languages.
REM

REM
REM TEXT (RE)FORMATTING PROGRAMS
REM
REM
REM  ***  TmNice  ***
REM
REM TmNice 2.3 TM MESSAGE & TAG MASTER TmNice is for Terminate / TerMail
REM users. It (re)formats quoted lines in reply messages properly and can
REM add a random TagLine to the message.
REM
REM TmNice options :
REM
REM    /71     - right margin.     /40 - /79    default: /71
REM    NOTAG   - do not add tag lines
REM    AUTOTAG - automatically add a random Tag Line  (no fun)
REM    NOWAIT  - do not ask for permission to reformat. Just do it!

REM TMNICE\TMNICE TM.MSG /75


REM TAGLINE MANAGERS


REM  ***  TagMan  ***
REM
REM  Usage : tagman [tagline file] [message file]
REM
REM  Note : Tagman uses a compressed tagline database.

REM TAGMAN\TAGMAN TAGMAN\TAGLINES.TDB TM.MSG %1

REM  ***  TagDude ***
REM
REM  If you use TagDude, enable it in AFTERMSG.BAT too!
REM
REM TAGDUDE\TAGDUDE -ADD1 TM.MSG
REM

