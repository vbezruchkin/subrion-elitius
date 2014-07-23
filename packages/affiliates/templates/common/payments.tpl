<h2>{lang key="payment_history"}</h2>
{if $smarty.const.IA_URL}
	{if isset($payments) && $payments}
	<table class="common" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th>{lang key="payment_id"}</th>
		<th>{lang key="date"}</th>
		<th>{lang key="time"}</th>
		<th>{lang key="total_sales"}</th>
		<th>{lang key="commissions"}</th>
	</tr>
	{foreach from=$payments item=payment}
	<tr>
		<td>{$payment.id}</td>
		<td>{$payment.date}</td>
		<td>{$payment.time}</td>
		<td>{$payment.sales}</td>
		<td>{$payment.commission}</td>
	</tr>
	{/foreach}
	</table>
	
	{navigation aTotal=$total_payment aTemplate=$atemplate aItemsPerPage=10 aNumPageItems=5 aTruncateParam=1}
	{else}
	<p style="font-weight: bold;">{lang key="history_clear"}</p>
	{/if}
{else}
	<strong>{lang key="msg_account_pending_approval"}</strong>
{/if}