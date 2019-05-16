<div id="list">
<table  bgcolor="#Ffffff" border=0 width="80%" >
<tr bgcolor="#666666" style="color:#ffffff" >
<td width="200px">User</td>
<td width="200px">Email</td>
<td width="200px">Login</td>
<td width="200px">Actions</td>

</tr>
{foreach from=$list item=l}
<tr bgcolor="{cycle values="#eeeeee,#E8E8E8"}" height="20px">
<td>{$l.name}</td>
<td>{$l.email}</td>
<td>{$l.login}</td>
<td>details</td>

{/foreach}
</table>