{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{let site_url=ezini('SiteSettings','SiteURL')}
{set-block scope=root variable=subject}{'%1 registration info'|i18n('design/standard/user/register',,array($site_url))}{/set-block}
{'Thank you for registering at %siteurl.'|i18n('design/standard/user/register',,hash('%siteurl',$site_url))}

{'Your account information'|i18n('design/standard/user/register')}
{'Login'|i18n('design/standard/user/register')}: {$user.login}
{'Email'|i18n('design/standard/user/register')}: {$user.email}

{section show=$password}
{'Password'|i18n('design/standard/user/register')}: {$password}
{/section}

{'Link to user information'|i18n('design/standard/user/register')}:
http://{$site_url}{concat('content/view/full/',$object.main_node_id)|ezurl(no)}

{/let}
