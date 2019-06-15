@ECHO OFF

REM здддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддд©
REM Ё        This file belongs to Terminate, The Final Terminal          Ё
REM юдддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддддды
REM         зддддддддддддддддддддддддддддддддддддддддддддддддддд©
REM         Ё  Hostmode command:  HOST\DOOR.BAT !P !B !H !I !M  Ё
REM         цдддддддддддбддддддддддддддддддбдддддддддддддддддддд╢
REM         Ё Parameter Ё Description      Ё Examples           Ё
REM         цдддддддддддеддддддддддддддддддедддддддддддддддддддд╢
REM         Ё    %1     Ё Port number      Ё 1,2,3,4            Ё
REM         Ё    %2     Ё Port speed       Ё 300..115200        Ё
REM         Ё    %3     Ё Port address     Ё 02F8,03F8          Ё
REM         Ё    %4     Ё Port IRQ         Ё 3,4,5,6,7          Ё
REM         цдддддддддддаддддддддддддддддддадддддддддддддддддддд╢
REM         Ё    Look in HOST\DOORMENU for more information     Ё
REM         Ё  REMEMBER: NO BLANK LINES AT THE END OF DOORMENU  Ё
REM         юддддддддддддддддддддддддддддддддддддддддддддддддддды

REM Starts Doorway using port-address and IRQ in case of special settings.
HOST\DOORWAY PORT:%3:%4 /S:* /G:ON /M:1000 /O:T /L /I:HOST\DOORMENU

REM Example for use with Fossil driver or ISDN fossil drivers like cFos.
REM *IMPORTANT* Use AT&D0 when using cFos to disable status line!
REM You cannot use DOORWAY.EXE with the internal CAPI 1.1 support, Doorway
REM must have a fossil driver like cFos to be able of running at all.
REM HOST\DOORWAY COM%1F /S:* /G:ON /M:1000 /O:T /L /I:HOST\DOORMENU

REM Use standard comport
REM HOST\DOORWAY COM%1 /S:* /G:ON /M:1000 /O:T /L /I:HOST\DOORMENU

REM Example to call COM2 with IRQ5
REM HOST\DOORWAY PORT:02F8:5 /S:* /G:ON /M:1000 /O:T /L /I:HOST\DOORMENU

REM Example for local use only
REM HOST\DOORWAY LOCAL /S:* /G:ON /M:1000 /O:T /L /I:HOST\DOORMENU

