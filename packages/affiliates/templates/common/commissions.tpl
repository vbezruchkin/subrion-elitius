<h2>{lang key="commission_details"}</h2>
{if $commission.id eq '' && $smarty.get.id eq ''}
	<div class="info">
		<span>{lang key="commissions"}: </span>
		{if $ctype neq "approval"}<a href="{$smarty.const.IA_SELF}?type=approval" style="font-size: 13px;">{lang key="pending_approval"}</a>{else}<b>{lang key="pending_approval"}</b>{/if}
		{if $ctype neq "active"}<a href="{$smarty.const.IA_SELF}?type=active" style="font-size: 13px;">{lang key="approved"}</a>{else}<b>{lang key="approved"}</b>{/if}
	</div>
	
	<div style="clear: both;"></div>
	
	<table cellpadding="0" cellspacing="0" class="common">
		<tr style="font-weight: bold;">
			<th>{lang key="sell_date"}</th>
			<th>{lang key="status"}</th>
			<th>{lang key="sale_amount"}</th>
			<th>{lang key="action"}</th>
		</tr>
	{foreach from=$commissions item=commission}
		<tr>
			<td>{$commission.date}</td>
			<td>{if $commission.status eq 'approval'}{lang key="approved"}{else}{lang key="pending"}{/if}</td>
			<td>{$commission.payment}</td>
			<td><a href="{$smarty.const.IA_SELF}?{if $smarty.get.type}type={$smarty.get.type}&{/if}{if $smarty.get.page}page={$smarty.get.page}&{/if}{if $smarty.get.items}items={$smarty.get.items}&{/if}id={$commission.id}" >{lang key="small_view_details"}</a></td>
		</tr>
	{/foreach}
	</table>
	<br />
	{navigation aTotal=$total_payment aTemplate=$atemplate aItemsPerPage=100 aNumPageItems=5 aTruncateParam=1}
{elseif $commission.id > 0}
	<a href="{$smarty.const.IA_SELF}?{if $smarty.get.type}type={$smarty.get.type}&{/if}{if $smarty.get.page}page={$smarty.get.page}&{/if}{if $smarty.get.items}items={$smarty.get.items}{/if}">{lang key="return_go_back"}</a><br />
	<br />
	<table border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC" width="100%">
		<tr>
			<td width="150" bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong>{lang key="sell_date"}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;">{$commission.date} {$commission.time}</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong>{lang key="sale_amount"}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;">{$commission.payment}</td>
		</tr>		
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong>{lang key="commissions"}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;">{$commission.payment*$percent}</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;" align="right"><strong>{lang key="order_number"}</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;">{$commission.order_number}</td>
		</tr>
	</table>
{elseif $smarty.get.id > 0}
	<strong style="color: #FF0000">{lang key="msh_incorrect_param"}</strong>
{/if}
