
@Echo off

Rem
Rem  To use TerMail with an external mail processor (for nodes):
Rem
Rem  1. Enable NeverToss in TM.CFG
Rem  2. Enable NeverPack in TM.CFG
Rem  3. Enable the EchoMailJam statement if supported by your mail processor.
Rem  4. Insert areas from mail processor in TM.BBS (only MSG and JAM-areas).
Rem  5. Edit this batchfile and insert the correct paths for mail processor.
Rem     Note: Gecho cannot pack crash or hold mail, but TerMail can.
Rem     If you run a your mailer on a network computer or in another task
Rem     under Win/OS2 you can also create a semaphore file to force the
Rem     mailer to rescan the outbound.
Rem
Rem  THATS IT!
Rem
Rem  If TMRESCAN.NOW is found in the TerMail directory all areas will be
Rem  flagged unscanned and the next time you enter an area it will be
Rem  rescanned. That means that if you are tossing mail on your BBS, you
Rem  simply insert the command:
Rem
Rem     Rescan>C:\TERxxx\TERMAIL\TMRESCAN.NOW
Rem
Rem  In main area selection use:
Rem
Rem    Alt-X   Exit TerMail                      Detect what action to start
Rem    Alt-0   Exit directly with errorlevel 0   Exit without packing mail
Rem    Alt-1   Exit directly with errorlevel 1   Pack netmail
Rem    Alt-2   Exit directly with errorlevel 2   Pack echomail
Rem    Alt-3   Exit directly with errorlevel 3   Pack netmail and echomail
Rem    Alt-4   Exit directly with errorlevel 4   Run Job1
Rem    Alt-5   Exit directly with errorlevel 5   Run Job2
Rem

TM %1 %2 %3

If Errorlevel 5 Goto Job2
If Errorlevel 4 Goto Job1
If Errorlevel 3 Goto NetAndEcho
If Errorlevel 2 Goto EchoOnly
If Errorlevel 1 Goto NetOnly

Goto End

:Job1
 Goto End

:Job2
 Goto End

:NetAndEcho
 Rem = McMail Gecho ======
 Rem
 Rem ===== Gecho ======
 Rem Gecho Pack
 Rem Tm /Scan Netmail
 Rem ==== FastEcho ====
 Rem FastEcho Pack

 Goto EchoOnly

:EchoOnly
 Rem ===== Gecho ======
 Rem Gecho Scan
 Rem ==== FastEcho ====
 Rem FastEcho Scan
 Goto RescanOutbound

:NetOnly
 Rem ===== Gecho ======
 Rem Gecho Pack
 Rem Tm /Scan Netmail
 Rem ==== FastEcho ====
 Rem FastEcho Pack
 Goto RescanOutbound

:RescanOutbound
 Rem = McMail ==
 Rem Echo McMail>C:\MCMAIL\MCMSCAN.ALL
 Rem Echo Exit 100>C:\MCMAIL\MCMEXT1.100
 Rem = Frontdoor ==
 Rem Echo Frontdoor>C:\FD\FDRESCAN.NOW
 Rem Echo Exit 100>C:\FD\FDXIT.100
 Goto End

:End

