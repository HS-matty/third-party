%
%  TerMail Carbon Copy Groups
%  ==========================
%
%  Syntax: &Group-name
%
%          Hidden-flag,Address,Name,Crash
%          .
%          .... as many cc-lines as you want!
%
%          Hidden-flag:  B = Blind, do not show address in message
%                        C = Carbon, show address in message
%          Address:      Fidonet style address
%          Name:         Username, max 35 characters
%          Crash:        C = Force crash.
%                        Nothing means crash only if letter is crash
%
%  Examples:
%
%  cc: &Customers
%  cc: 2:2/0, &Customers, &Announcements, 2:254/0
%
%  There is no limits on number of groups to be used and there is no limit
%  on users in each group. Message will only be send to the same address
%  once, even if mentioned several times in different groups.
%
%  Blank lines or lines starting with % are comments and are ignored.
%

% Mailing list. To use: cc: &Customers in your message.

% -------------------------------------------------------------------------
&Customers
% -------------------------------------------------------------------------

% Send message to these users or customers, crash only if message is crash.

C,2:236/111.101,Hans-Christian Andersen
C,2:236/111.117,Bue Vester-Andersen

% Force crash to these advisors

C,2:443/888,Steve Stacher,C
C,1:109/921,Andy Roberts,C

% Send Blind copies to the managers crash, do not show the others.

B,2:254/261,Bo Bendtsen,C
B,2:236/111,Bo Bendtsen,C

% Group ends when end-of-file or a new group is defined


% -------------------------------------------------------------------------
&Announcements
% -------------------------------------------------------------------------

% Only send to these when announcing a new product

C,2:443/888,Steve Stacher,C
C,1:109/921,Andy Roberts,C

% -END OF FILE-

