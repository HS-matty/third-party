@ECHO OFF

REM
REM This is the AFTERMSG.BAT file for TerMail.
REM
REM If you have several programs to run after you have edited your
REM message, you could use this batch file. We will try to gather as
REM many possible settings for all kind of programs here.
REM
REM Programs that currently could use such a batch file would be
REM
REM Spell-checkers
REM Tagline/originline managers
REM PGP-encryption/decryption/signatures
REM
REM %1 will be the GROUP name in uppercased letters:  INTER, GERMAN etc.
REM That can be used to determine different spellers or tagline editors
REM for different languages.
REM

REM To view the group name, remove the REM statements below

REM CLS
REM ECHO %1
REM PAUSE


REM SPELLING CHECKERS

REM  *** ShareSpell ***
REM
REM  Unpack ShareSpell into TERMAIL\SPELL and disable the REM statements
REM  below.
REM

REM CD SPELL
REM SS ..\TM.MSG

REM
REM  The example below will show you how to abort if the spell-checker
REM  only handles English.
REM

REM IF %1==MATRIX GOTO ENGLISH
REM IF %1==INTER GOTO ENGLISH
REM ECHO Sorry we could not check this language for spelling mistakes.
REM PAUSE
REM GOTO END

REM :ENGLISH
REM CD SPELL
REM SS ..\TM.MSG
REM GOTO END


REM ***  JSpell  ***

REM SPELL\JSPELL TM.MSG


REM TAGLINE MANAGERS


REM ***  CookieMan  ***
REM
REM  Cookman is a program to append cookie lines. Please be aware that
REM  sending out too many cookies could upset the people who are paying
REM  for your fun with their phonebill. Please keep it to a low level.
REM

REM CD COOKMAN
REM COOKMAN ..\TM.MSG


REM ***  TagDude  ***
REM
REM If you use TagDude, enable it in BEFORMSG.BAT too!
REM

REM TAGDUDE\TAGDUDE -ADD2 TM.MSG


REM ***  MrTag v0.01  ***
REM
REM This programs searches for TM.MSG. As of 1.51+, TerMail uses TM.MSG
REM instead, so a little work-around is needed
REM

REM if exist TMAIL.MSG del TMAIL.MSG
REM ren TM.MSG TMAIL.MSG
REM MrTag
REM ren TMAIL.MSG TM.MSG



REM PGP INTERFACES


REM ***  TerPGP 4.0 ***
REM
REM Usage : terpgp [message file] [PGP options]

REM TERPGP\TERPGP.EXE TM.MSG


REM ***  TmailPGP 1.50 ***

REM Check the documentation of TmailPGP about how to set the program up.

REM TMPGP\TmailPGP

:END

