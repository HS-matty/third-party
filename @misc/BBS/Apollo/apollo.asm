;Apollo BBS Demo by Sergey Volchek / Minsk / Belarus
.model tiny
.code
.386
org 100h

start: 

;mov al,13h
;int 10h
; some other graph code here
;
mov ax,3h
int 10h


mov ah,9
lea dx, msg
int 21h

ret

msg db 'Apollo BBS, Minsk, BY, ph:0172-240808, 23:00-7:00, Doom2, SysOp:Sergey Volchek.$'

end start
