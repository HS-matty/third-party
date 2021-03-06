{* DO NOT EDIT THIS FILE! Use an override template instead. *}
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
{literal}
<!--
function checkAll()
{

    if ( document.trashaction.selectall.value == "Select all" )

    {

        document.trashaction.selectall.value = "Deselect all";

        with (document.trashaction)
	{
            for (var i=0; i < elements.length; i++)
	    {
                if (elements[i].type == 'checkbox' && elements[i].name == 'SessionKeyArray[]')
                     elements[i].checked = true;
	    }
        }
     }
     else
     {

         document.trashaction.selectall.value = "Select all";

         with (document.trashaction)
	 {
            for (var i=0; i < elements.length; i++)
	    {
                if (elements[i].type == 'checkbox' && elements[i].name == 'SessionKeyArray[]')
                     elements[i].checked = false;
	    }
         }
     }
}

//-->
{/literal}
</SCRIPT>
<form name="trashaction" method="post" action={concat( '/setup/session/(offset)/', $view_parameters.offset )|ezurl}>
<h1>{"Session admin"|i18n( "design/standard/setup/session" )}</h1>

{section show=$sessions_removed}
<div class="feedback">
{"The sessions were successfully removed."|i18n( "design/standard/setup/session" )}
</div>
{/section}

<div class="objectheader">
    <h2>{"Sessions"|i18n( "design/standard/setup/session" )}</h2>
</div>
<div class="object">
    <p>{"Number of active sessions"|i18n( "design/standard/setup/session" )}: {$sessions_active}<br/>
        {let logged_in_count=fetch( user, logged_in_count )
             anonymous_count=fetch( user, anonymous_count )}
        {'There are %logged_in_count registered and %anonymous_count anonymous users online.'|i18n( 'design/standard/toolbar',,
          hash( '%logged_in_count', $logged_in_count, '%anonymous_count', $anonymous_count ) )}
        {/let}
    </p>
    <p>{"Use the buttons below to delete the session entries that are present in the database."|i18n( "design/standard/setup/session" )}<br/>
       {"WARNING! When removing sessions, users that are logged in will be thrown out from the system."|i18n( "design/standard/setup/session" )}</p>

    <div class="buttonblock">
            <input type="submit" name="RemoveAllSessionsButton" value="{"Remove all sessions"|i18n( "design/standard/setup/session" )}" />&nbsp;
            <input type="submit" name="RemoveTimedOutSessionsButton" value="{"Remove timed out / old sessions"|i18n( "design/standard/setup/session" )}" />
    </div>
</div>

<table class="list" width="100%" cellspacing="0" cellpadding="0" border="0">
<th>
&nbsp;
</th>
<th>
    <a class="topline" href={concat( '/setup/session/(offset)/', $view_parameters.offset, '/(sortby)/login' )|ezurl}>{"Login"|i18n( "design/standard/setup/session" )}</a>
</th>
<th>
    <a class="topline" href={concat( '/setup/session/(offset)/', $view_parameters.offset, '/(sortby)/email' )|ezurl}>{"E-mail"|i18n( "design/standard/setup/session" )}</a>
</th>
<th>
    <a class="topline" href={concat( '/setup/session/(offset)/', $view_parameters.offset, '/(sortby)/name' )|ezurl}>{"Full name"|i18n( "design/standard/setup/session" )}</a>
</th>
<th>
    <a class="topline" href={concat( '/setup/session/(offset)/', $view_parameters.offset, '/(sortby)/idle' )|ezurl}>{"Idle time"|i18n( "design/standard/setup/session" )}</a>
</th>
<th>
    <a class="topline" href={concat( '/setup/session/(offset)/', $view_parameters.offset, '/(sortby)/idle' )|ezurl}>{"Idle since"|i18n( "design/standard/setup/session" )}</a>
</th>

{section var=session loop=$sessions_list sequence=array('bgdark', 'bglight')}
<tr valign="top" class="{$session.sequence}">
    {let session_user=fetch( content,object, hash( 'object_id', $session.user_id ) )}
    <td width="1%">
        <input type="checkbox" name="SessionKeyArray[]" value="{$session.session_key|wash}" />
    </td>
    <td width="20%">
        <a href={$session_user.main_node.url_alias|ezurl}>{$session.login}</a>
    </td>
    <td width="20%">
        <a href="mailto:{$session.email|wash}">{$session.email|wash}</a>
    </td>
    <td width="30%">
        {$session_user.name|wash}
    </td>

    <td width="10%"> 
        {$session.idle.hour}:{$session.idle.minute}:{$session.idle.second}
    </td> 
    <td width="19%">
      {section show=or( $session.idle.minute|lt( 0 ), $session.idle.hour|lt( 0 ) )}
          {"Time skew detected"|i18n( "design/standard/setup/session" )}
      {section-else}
          {$session.idle_time|l10n( shortdatetime )}
      {/section}
    </td>

    {/let}
</tr>
{/section}
</table>
<table>
<tr>
    <td>
        <input type="submit" name="RemoveSelectedSessionsButton" value="{"Remove"|i18n( "design/standard/setup/session ")}" />
    </td>
    <td colspan="5">
        <input name="selectall" onclick=checkAll() type="button" value="Select all">
    </td>
</tr>
</table>

    {include name=navigator
             uri='design:navigator/google.tpl'
             page_uri='/setup/session'
             item_count=$sessions_active
             view_parameters=$view_parameters
             item_limit=$page_limit}

</form>
