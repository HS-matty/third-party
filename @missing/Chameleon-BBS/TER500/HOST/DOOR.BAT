@ECHO OFF

REM 旼컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴커
REM �        This file belongs to Terminate, The Final Terminal          �
REM 읕컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴켸
REM         旼컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴�
REM         �  Hostmode command:  HOST\DOOR.BAT !P !B !H !I !M  �
REM         쳐컴컴컴컴컴쩡컴컴컴컴컴컴컴컴컫컴컴컴컴컴컴컴컴컴컴�
REM         � Parameter � Description      � Examples           �
REM         쳐컴컴컴컴컴탠컴컴컴컴컴컴컴컴컵컴컴컴컴컴컴컴컴컴컴�
REM         �    %1     � Port number      � 1,2,3,4            �
REM         �    %2     � Port speed       � 300..115200        �
REM         �    %3     � Port address     � 02F8,03F8          �
REM         �    %4     � Port IRQ         � 3,4,5,6,7          �
REM         쳐컴컴컴컴컴좔컴컴컴컴컴컴컴컴컨컴컴컴컴컴컴컴컴컴컴�
REM         �    Look in HOST\DOORMENU for more information     �
REM         �  REMEMBER: NO BLANK LINES AT THE END OF DOORMENU  �
REM         읕컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴컴�

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

