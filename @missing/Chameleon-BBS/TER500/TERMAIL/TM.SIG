%
% TerMail Signatures
% ==================
%
% Insert signatures in the internal editor with F5
% You can also use this file to insert various other texts in your letters
% that are not signatures. Like conference rules or standard texts just like
% the forms function.
%
% Syntax:
%             |--------------------------------------|
%  @SIGNATURE Text to show in menu up to 40 characters
%  Unlimited text lines
%  @END
%
% Other keywords:
%
%  @NAME    Name of current user
%  @F       First name of current user
%  @L       Last name(s) of current user
%  @ADDR    Fidonet address of current user
%  @EMAIL   Internet address of current user
%  @CTIME   Current time
%  @CDATE   Current date
%
% Limits:
%
%  You can have up to 20 different signatures each with an unlimited number
%  of lines. However remember NEVER to use long signatures each and every
%  time you write a message. In some conferences it is against the rules
%  to use long signatures, which means you must check the rules before you
%  post a message.
%
%

@SIGNATURE  My standard signature

Yours sincerely

@NAME
Fidonet         : @ADDR
Internet        : @EMAIL

@END

%
%
%

@SIGNATURE  Long signature only for crash netmail
=============================================================================

     Yours sincerely : Bo Bendtsen
     Internet        : bo@terminate.com
      Worldwide Web  : http://www.terminate.com
      Files          : http://www.terminate.com/download.htm
      FTP            : ftp.terminate.com terminat/
     Fidonet         : 2:254/261

=============================================================================
@END

%
% If you are using PGP to encrypt your messages.
%

@SIGNATURE My public PGP key

Insert you public key here

@END

%
% If you are a moderator in a conference you sometimes want to use a
% different signature, where you mention that you are writing this
% message with the moderator-hat on.
%

@SIGNATURE  Moderator

Bo Bendtsen, moderator
Request RULES at 2:254/261

@END

@SIGNATURE  Keep my message secret
 +-----------------------------------------------------------------------+
 | Pursuant to FidoNet Policy 4 (Section 2.1.6.2),  I request that this  |
 | message be kept confidential, and that it not be circulated, cross-   |
 | posted or otherwise divulged to any third party, now or in the future.|
 |     Failure to comply will be considered to be annoying behaviour.    |
 +-----------------------------------------------------------------------+
@END

