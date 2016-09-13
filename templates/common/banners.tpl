<h2>{lang key='products'}</h2>
{if $products}
	<table class="table table-bordered table-striped">
		<thead>
		<tr>
			<th></th>
			<th>{lang key='title'}</th>
			<th>{lang key='commission_type'}</th>
		</tr>
		</thead>
	{foreach $products as $product}
		<tr>
			<td> </td>
			<td>{$product.title}</td>
			<td>{$product.amount} {$product.commission_type}</td>
		</tr>
	{/foreach}
	</table>
{/if}

{foreach $banners as $banner}
	{switch $banner.type}
		{case 'banner'}
			{break}
		{case 'text'}
			{break}
	{/switch}
{foreachelse}

{/foreach}

{if $etype eq 'banners' || $etype eq 'ads'}
	{if $mod eq 'list'}
		<h2>{lang key=$etype}</h2>
		{if IN_USER}
			{lang key="products"} - 
				<select onchange="getBanners($(this).val())">
				<option value="">{lang key="_select_"}</option>
				{foreach from=$products key="pid" item="product"}
				<option value="{$pid}" {if isset($smarty.get.pid) && $smarty.get.pid eq $pid}selected{/if}>{$product}</option>
				{/foreach}
			</select><br />&nbsp;
			<table cellpadding="2" cellspacing="1" class="banners" width="100%">
				<tr style="background-color: #E5E5E5; font-weight: bold;">
					<td width="25%">{if $etype eq 'banners'}{lang key="banner_name"}{else}{lang key="ad_title"}{/if}</td>
					<td>{if $etype eq 'banners'}{lang key="banner_desc"}{else}{lang key="ad_desc"}{/if}</td>
				</tr>
				{foreach from=$banners item="banner"}
				<tr>
					<td><a href="{$smarty.const.IA_URL}{if $etype eq 'banners'}elitius/banners/{else}elitius/ads/text/{/if}view/?id={$banner.id}{if $smarty.get.pid>0}&pid={$smarty.get.pid}{/if}">
						{if $etype eq 'banners'}{$banner.banner_name}{else}{$banner.title}{/if}
					</a></td>
					<td>{if $etype eq 'banners'}{$banner.desc}{else}{$banner.content}{/if}</td>
				</tr>
				{/foreach}
			</table>
			<script type="text/javascript">
			{literal}
			function getBanners(val)
			{
				var loc = document.location.href;
				
				if(loc.indexOf('pid=')>-1 && parseInt(val)>0)
				{
					loc = loc.replace(/pid\=(\d+)/,'pid='+val);
					document.location.href = loc;
				}
				else if(parseInt(val)>0)
				{
					document.location.href = loc+"?pid="+val;
				}
				else
				{
					loc = loc.replace(/\?pid\=(\d+)?$/,'');
					document.location.href = loc;
				}
			}
			{/literal}
			</script>
		{else}
			<strong>{lang key="msg_account_pending_approval"}</strong>
		{/if}
	{elseif $mod eq 'view'}
		<h2>{lang key="banner_details"}</h2>
		
		<table class="banners common" style="padding-top: 10px;" cellpadding="0" cellspacing="0">
			<tr>
				<td width="200"><b>{if $etype eq 'banners'}{lang key="banner_name"}{else}{lang key="ad_name"}{/if}:</b></td>
				<td>{if $etype eq 'banners'}{$banner.banner_name}{else}{$banner.title}{/if}</td>
			</tr>
			<tr>
				<td><b>{if $etype eq 'banners'}{lang key="banner_desc"}{else}{lang key="ad_desc"}{/if}:</b></td>
				<td>{if $etype eq 'banners'}{$banner.desc}{else}{$banner.content}{/if}</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;"><img src="{$smarty.const.IA_URL}uploads/{$banner.image}" alt="banner" title="banner" border="0"/></td>
			</tr>
			<tr>
				<td colspan="2" style="color: #5F5F5F;"><b>{lang key="banner_code"}</b></td>
			</tr>
			<tr>
				<td colspan="2"><textarea name="c1" style="width: 594px; height: 100px; color: #CF6600;" onfocus="this.select();">{$banner.code}</textarea></td>
			</tr>
		</table>
	
	{/if}
{elseif $etype eq 'links'}
	<h2>{lang key="text_links"}</h2>
	<h3>{lang key="product_link"}</h3>
	<p>{lang key="source_code"}</p>
	
	<form name="code1">
	<textarea name="c1" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();"><a href="{$smarty.const.IA_URL}exp/?id={$smarty.session.user.id}">{lang key="site_title"}</a></textarea><br>
	</form>

	<h3>{lang key="affiliate_link"}</h3>

	<p>{lang key="source_code"}</p>
	
	<textarea name="c2" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();"><a href="{$smarty.const.IA_URL}txp/?tid={$smarty.session.user.id}">{lang key="join_aff"}</a></textarea><br>
{elseif $etype eq 'emails'}
	<h2>{lang key="email_links"}</h2>
	<p>{lang key="source_code"}</p>
	
	<textarea name="c1" rows="2" style="width: 590px; color: #CF6600;" onfocus="this.select();">{$smarty.const.IA_URL}elitius/exp/?id={$smarty.session.user.id}</textarea><br>	
{/if}