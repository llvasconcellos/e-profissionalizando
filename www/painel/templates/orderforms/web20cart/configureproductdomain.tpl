<link rel="stylesheet" type="text/css" href="templates/orderforms/web20cart/style.css" />
<h2>{$LANG.cartproductconfig}</h2>
<p>{$LANG.cartproductdomaindesc}</p>
<form method="post" action="{$smarty.server.PHP_SELF}?a=add&pid={$pid}">
{foreach from=$passedvariables key=name item=value}
<input type="hidden" name="{$name}" value="{$value}" />
{/foreach}
  {if $errormessage}
  <div class="errorbox">{$errormessage}</div>
  <br />
  {/if}
  
  {if $incartdomains}
  <p><input type="radio" name="domainoption" value="incart" id="selincart" onclick="document.getElementById('register').style.display='none';document.getElementById('transfer').style.display='none';document.getElementById('owndomain').style.display='none';document.getElementById('subdomain').style.display='none';document.getElementById('incart').style.display=''" />
  <label for="selincart">{$LANG.cartproductdomainuseincart}</label></p>
  {/if}
  
  {if $registerdomainenabled}
  <p><input type="radio" name="domainoption" value="register" id="selregister" onclick="document.getElementById('register').style.display='';document.getElementById('transfer').style.display='none';document.getElementById('owndomain').style.display='none';document.getElementById('subdomain').style.display='none';document.getElementById('incart').style.display='none'" />
  <label for="selregister">{$LANG.orderdomainoption1part1} {$companyname} {$LANG.orderdomainoption1part2}</label></p>
  {/if}
  
  {if $transferdomainenabled}
  <p><input type="radio" name="domainoption" value="transfer" id="seltransfer" onclick="document.getElementById('register').style.display='none';document.getElementById('transfer').style.display='';document.getElementById('owndomain').style.display='none';document.getElementById('subdomain').style.display='none';document.getElementById('incart').style.display='none'" />
  <label for="seltransfer">{$LANG.orderdomainoption3} {$companyname}</label></p>
  {/if}
  
  {if $owndomainenabled}
  <p><input type="radio" name="domainoption" value="owndomain" id="selowndomain" onclick="document.getElementById('register').style.display='none';document.getElementById('transfer').style.display='none';document.getElementById('owndomain').style.display='';document.getElementById('subdomain').style.display='none';document.getElementById('incart').style.display='none'" />
  <label for="selowndomain">{$LANG.orderdomainoption2}</label></p>
  {/if}
  
  {if $subdomains}
  <p><input type="radio" name="domainoption" value="subdomain" id="selsubdomain" onclick="document.getElementById('register').style.display='none';document.getElementById('transfer').style.display='none';document.getElementById('owndomain').style.display='none';document.getElementById('subdomain').style.display='';document.getElementById('incart').style.display='none'" />
  <label for="selsubdomain">{$LANG.orderdomainoption4}</label></p>
  {/if} <br />
  <div class="cartbox">
    <div id="incart" align="center">{$LANG.cartproductdomainchoose}:
      <select name="incartdomain">
        
{foreach key=num item=incartdomain from=$incartdomains}

        <option value="{$incartdomain}">{$incartdomain}</option>
        
{/foreach}

      </select>
    </div>
    <div id="register" align="center">www.
      <input type="text" name="sld[0]" size="40" value="{$sld}" />
      <select name="tld[0]">
        
{foreach key=num item=listtld from=$registertlds}

        <option value="{$listtld}"{if $listtld eq $tld} selected="selected"{/if}>{$listtld}</option>
        
{/foreach}

      </select>
    </div>
    <div id="transfer" align="center">www.
      <input type="text" name="sld[1]" size="40" value="{$sld}" />
      <select name="tld[1]">
        
{foreach key=num item=listtld from=$transfertlds}

        <option value="{$listtld}"{if $listtld eq $tld} selected="selected"{/if}>{$listtld}</option>
        
{/foreach}

      </select>
    </div>
    <div id="owndomain" align="center">www.
      <input type="text" name="sld[2]" size="40" value="{$sld}" />
      .
      <input type="text" name="tld[2]" size="7" value="{$tld}" />
    </div>
    <div id="subdomain" align="center">http://
      <input type="text" name="sld[3]" size="40" value="{$sld}" />
      <select name="tld[3]">
      {foreach from=$subdomains key=subid item=subdomain}
        <option value="{$subid}">{$subdomain}</option>
      {/foreach}
      </select></div>
  </div>
  <p align="center">
    <input type="submit" value="{$LANG.ordercontinuebutton}" class="buttongo" />
  </p>
  <script language="javascript" type="text/javascript">
document.getElementById('incart').style.display='none';
document.getElementById('register').style.display='none';
document.getElementById('transfer').style.display='none';
document.getElementById('owndomain').style.display='none';
document.getElementById('subdomain').style.display='none';
document.getElementById('sel{$domainoption}').checked='true';
document.getElementById('{$domainoption}').style.display='';
</script>
  {if $availabilityresults}
  <h3 class="cartsubheading">{$LANG.choosedomains}</h3>
  <table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="data">
    <tr>
      <th>{$LANG.domainname}</th>
      <th>{$LANG.domainstatus}</th>
      <th>{$LANG.domainmoreinfo}</th>
    </tr>
    {foreach key=num item=result from=$availabilityresults}
    <tr>
      <td>{$result.domain}</td>
      <td class="{if $result.status eq $searchvar}domaincheckeravailable{else}domaincheckerunavailable{/if}">{if $result.status eq $searchvar}
        <input type="checkbox" name="domains[]" value="{$result.domain}"{if $num eq 0} checked{/if} />
        {$LANG.domainavailable}{else}{$LANG.domainunavailable}{/if}</td>
      <td>{if $result.regoptions}
        <select name="domainsregperiod[{$result.domain}]">
          {foreach key=period item=regoption from=$result.regoptions}
          {if $regoption.$domainoption}<option value="{$period}">
            {$period} {$LANG.orderyears} @ {$regoption.$domainoption}
          </option>{/if}
          {/foreach}
        </select>
      {/if}</td>
    </tr>
    {/foreach}
  </table>
  <p align="center">
    <input type="submit" value="{$LANG.ordercontinuebutton}" class="buttongo" />
  </p>
  {/if}

  {if $freedomaintlds}* <em>{$LANG.orderfreedomainregistration} {$LANG.orderfreedomainappliesto}: {$freedomaintlds}</em>{/if}
</form><br />