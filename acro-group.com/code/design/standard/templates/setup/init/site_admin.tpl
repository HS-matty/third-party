{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{*?template charset=latin1?*}

<form method="post" action="{$script}">

  <div align="center">
      <h1>{"Site administrator"|i18n("design/standard/setup/init")}</h1>
  </div>

  <p>
      {"This page lets you modify the administrator for your site. This ensures that your site is secure and has proper name and E-mail set."|i18n("design/standard/setup/init")}
  </p>

{section show=$has_errors}
    <blockquote class="error">
        <h2>{"Warning"|i18n("design/standard/setup/init")}</h2>
        {section show=eq( $first_name_missing, 1 )}
            <p>
                {"You need to fill in the first name."|i18n("design/standard/setup/init")}
            </p>
        {/section}
        {section show=eq( $last_name_missing, 1 )}
            <p>
                {"You need to fill in the last name."|i18n("design/standard/setup/init")}
            </p>
        {/section}
        {section show=eq( $email_missing, 1 )}
            <p>
                {"You need to fill in an e-mail address."|i18n("design/standard/setup/init")}
            </p>
        {/section}
        {section show=eq( $email_invalid, 1 )}
            <p>
                {"You need to fill in a valid e-mail address."|i18n("design/standard/setup/init")}
            </p>
        {/section}
        {section show=eq( $password_missmatch, 1 )}
            <p>
                {"Your passwords do not match."|i18n("design/standard/setup/init")}
            </p>
        {/section}
        {section show=eq( $password_missing, 1 )}
            <p>
                {"You need to fill in a password."|i18n("design/standard/setup/init")}
            </p>
        {/section}
    </blockquote>
{/section}


<h3>{"Administrator settings"|i18n("design/standard/setup/init")}</h3>
<p>
    <table border="0" cellspacing="2" cellpadding="0">
    <tr>
        <td>{"Login"|i18n("design/standard/setup/init")}:&nbsp;</td>
        <td>admin</td>
    </tr>
    <tr>
        <td{section show=eq( $first_name_missing, 1 )} class="invalid"{/section}>{"First name"|i18n("design/standard/setup/init")}:&nbsp;</td>
        <td><input type="text" size="20" name="eZSetup_site_templates_first_name" value="{$admin.first_name|wash}" /></td>
    </tr>
    <tr>
        <td{section show=eq( $last_name_missing, 1 )} class="invalid"{/section}>{"Last name"|i18n("design/standard/setup/init")}:&nbsp;</td>
        <td><input type="text" size="20" name="eZSetup_site_templates_last_name" value="{$admin.last_name|wash}" /></td>
    </tr>
    <tr>
        <td{section show=or( $email_missing, $email_invalid )} class="invalid"{/section}>{"E-mail address"|i18n("design/standard/setup/init")}:&nbsp;</td>
        <td><input type="text" size="20" name="eZSetup_site_templates_email" value="{$admin.email|wash}" /></td>
    </tr>
    <tr>
        <td{section show=or( $password_missmatch, $password_missing )} class="invalid"{/section}>{"Password"|i18n("design/standard/setup/init")}:&nbsp;</td>
        <td><input type="password" size="20" name="eZSetup_site_templates_password1" value="{$admin.password|wash}" /></td>
    </tr>
    <tr>
        <td{section show=or( $password_missmatch, $password_missing )} class="invalid"{/section}>{"Confirm password"|i18n("design/standard/setup/init")}:&nbsp;</td>
        <td><input type="password" size="20" name="eZSetup_site_templates_password2" value="{$admin.password|wash}" /></td>
    </tr>

    </table>
</p>

{include uri="design:setup/persistence.tpl"}
{include uri='design:setup/init/navigation.tpl'}

</form>