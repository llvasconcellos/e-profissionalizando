<p class="heading2">{$LANG.clientareanavdomains}</p>

<table cellspacing="1" cellpadding="0" class="frame"><tr><td>

<table width="100%" cellpadding="2">
<tr><td class="fieldarea" width="150">{$LANG.clientareahostingregdate}:</td><td>{$registrationdate}</td></tr>
<tr><td class="fieldarea">{$LANG.clientareahostingdomain}:</td><td><a href="http://{$domain}" target="_blank">{$domain}</a></td></tr>
<tr><td class="fieldarea">{$LANG.orderpaymentmethod}:</td><td>{$paymentmethod}</td></tr>
<tr><td class="fieldarea">{$LANG.firstpaymentamount}:</td><td>{$firstpaymentamount}</td></tr>
<tr><td class="fieldarea">{$LANG.recurringamount}:</td><td>{$recurringamount}</td></tr>
{if $recreatesubscriptionbutton}<tr><td></td><td>{$recreatesubscriptionbutton}</td></tr>{/if}
<tr><td class="fieldarea">{$LANG.clientareahostingnextduedate}:</td><td>{$nextduedate}</td></tr>
<tr><td class="fieldarea">{$LANG.clientarearegistrationperiod}:</td><td>{$registrationperiod} {$LANG.orderyears}</td></tr>
<tr><td class="fieldarea">{$LANG.clientareastatus}:</td><td>{$status}</td></tr>
</table>

</td></tr></table>

<br />

{if $status eq $LANG.clientareaactive}

<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
<input type="hidden" name="id" value="{$domainid}">
<p><strong>&nbsp;&raquo;&nbsp;&nbsp;{$LANG.domainsautorenew}</strong></p>
{if $donotrenew}<div class="errorbox">{$LANG.domainsautorenewdisabledwarning}</div><br>{/if}
<p>{$LANG.domainsautorenewstatus}: {if $donotrenew}{$LANG.domainsautorenewdisabled} &nbsp;&nbsp;&nbsp; <input type="hidden" name="autorenew" value="enable"><input type="submit" value="{$LANG.domainsautorenewenable}" class="buttongo" />{else}{$LANG.domainsautorenewenabled} &nbsp;&nbsp;&nbsp; <input type="hidden" name="autorenew" value="disable"><input type="submit" value="{$LANG.domainsautorenewdisable}" class="buttonwarn" />{/if}</p>
</form>

{if $managens}

<p><strong>&nbsp;&raquo;&nbsp;&nbsp;{$LANG.domainnameservers}</strong></p>

{if $error}<div class="errorbox">{$error}</div><br />{/if}

<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
<input type="hidden" name="sub" value="savens">
<input type="hidden" name="id" value="{$domainid}">
<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td class="fieldarea" width="150">{$LANG.domainnameserver1}:</td><td><input type="text" name="ns1" value="{$ns1}" size="40"></td></tr>
<tr><td class="fieldarea">{$LANG.domainnameserver2}:</td><td><input type="text" name="ns2" value="{$ns2}" size="40"></td></tr>
<tr><td class="fieldarea">{$LANG.domainnameserver3}:</td><td><input type="text" name="ns3" value="{$ns3}" size="40"></td></tr>
<tr><td class="fieldarea">{$LANG.domainnameserver4}:</td><td><input type="text" name="ns4" value="{$ns4}" size="40"></td></tr>
</table>
</td></tr></table>
<p align="center"><input type="submit" value="{$LANG.clientareasavechanges}" class="buttongo" /></p>
</form>

{/if}

{if $lockstatus}
{if $tld neq "co.uk" && $tld neq "org.uk" && $tld neq "ltd.uk" && $tld neq "plc.uk" && $tld neq "me.uk"}
<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
<input type="hidden" name="sub" value="savereglock">
<input type="hidden" name="id" value="{$domainid}">
<p><strong>&nbsp;&raquo;&nbsp;&nbsp;{$LANG.domainregistrarlock}</strong></p>
<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td class="fieldarea" width="150">{$LANG.domainregistrarlock}:</td><td><input type="checkbox" name="reglock"{if $lockstatus=="locked"} checked{/if}> {$LANG.domainregistrarlockdesc}</td></tr>
</table>
</td></tr></table>
<p align="center"><input type="submit" value="{$LANG.clientareasavechanges}" class="buttongo" /></p>
</form>
{/if}
{/if}

{if $releasedomain}
<p><strong>&nbsp;&raquo;&nbsp;&nbsp;{$LANG.domainrelease}</strong></p>
<form method="post" action="{$smarty.server.PHP_SELF}?action=domaindetails">
<input type="hidden" name="sub" value="releasedomain">
<input type="hidden" name="id" value="{$domainid}">
<table cellspacing="1" cellpadding="0" class="frame"><tr><td>
<table width="100%" cellpadding="2">
<tr><td class="fieldarea" width="150">{$LANG.domainreleasetag}:</td><td><input type="text" name="transtag" size="20" /> {$LANG.domainreleasedescription}</td></tr>
</table>
</td></tr></table>
<p align="center"><input type="submit" value="{$LANG.domainrelease}" class="buttonwarn" /></p>
</form>
{/if}

{/if}

<p><strong>&nbsp;&raquo;&nbsp;&nbsp;{$LANG.domainmanagementtools}</strong></p>

<table align="center"><tr>
{if $renew}<td><form method="post" action="{$smarty.server.PHP_SELF}?action=domainrenew">
<input type="hidden" name="domainid" value="{$domainid}">
<p align="center"><input type="submit" value="{$LANG.domainrenew}" class="button" /></p>
</form></td>{/if}
{if $managecontacts}<td><form method="post" action="{$smarty.server.PHP_SELF}?action=domaincontacts">
<input type="hidden" name="domainid" value="{$domainid}">
<p align="center"><input type="submit" value="{$LANG.domaincontactinfo}" class="button" /></p>
</form></td>{/if}
{if $emailforwarding}<td><form method="post" action="{$smarty.server.PHP_SELF}?action=domainemailforwarding">
<input type="hidden" name="domainid" value="{$domainid}">
<p align="center"><input type="submit" value="{$LANG.domainemailforwarding}" class="button" /></p>
</form></td>{/if}
{if $dnsmanagement}<td><form method="post" action="{$smarty.server.PHP_SELF}?action=domaindns">
<input type="hidden" name="domainid" value="{$domainid}">
<p align="center"><input type="submit" value="{$LANG.domaindnsmanagement}" class="button" /></p>
</form></td>{/if}
{if $getepp}<td><form method="post" action="{$smarty.server.PHP_SELF}?action=domaingetepp">
<input type="hidden" name="domainid" value="{$domainid}">
<p align="center"><input type="submit" value="{$LANG.domaingeteppcode}" class="button" /></p>
</form></td>{/if}
{if $registerns}<td><form method="post" action="{$smarty.server.PHP_SELF}?action=domainregisterns">
<input type="hidden" name="domainid" value="{$domainid}">
<p align="center"><input type="submit" value="{$LANG.domainregisterns}" class="button" /></p>
</form></td>{/if}
</tr></table>

<p align="center"><input type="button" value="{$LANG.clientareabacklink}" onclick="window.location='clientarea.php?action=domains'" class="button" /></p>