<html>
<head>
<title>{TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
  <p>e-base main page</p>
  <p>RATES.</p>
  <p>&nbsp;</p>
  <table width="600" border="0">
    <!-- BEGIN IN_BODY -->
    <tr> 
      <td width="125"> 
        <div align="center">{IN_BODY.in_cur_sname} (left: {IN_BODY.in_left}) </div>
      </td>
      <td width="120"> 
        <div align="center"><a href="/change/index.php?in_cur={IN_BODY.in_cur_id}&out_cur={IN_BODY.out_cur_id}{IN_BODY.sid}">------------&gt;</a></div>
      </td>
      <td width="125"> 
        <div align="center">{IN_BODY.out_cur_sname} (left: {IN_BODY.out_left}) 
        </div>
      </td>
      <td width="111"> 
        <div align="center">rate: {IN_BODY.rate}</div>
      </td>
    </tr>
    <!-- END IN_BODY -->
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>
