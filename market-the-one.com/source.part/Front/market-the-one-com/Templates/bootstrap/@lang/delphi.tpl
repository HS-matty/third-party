unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;

type
  TForm1 = class(TForm)
    Button1: TButton;
    Button2: TButton;
    procedure Button1Click(Sender: TObject);
  private
    {literal}{ Private declarations }{/literal}
  public
    {literal}{ Public declarations }{/literal}
  end;

var
  Form1: TForm1;

implementation

{literal}{$R *.dfm}{/literal}

procedure TForm1.Button1Click(Sender: TObject);
begin

MessageBox(handle, PChar('Are you want exit?'), PChar('Think please :)'), MB_YESNO+MB_ICONQUESTION);
end;

end.
