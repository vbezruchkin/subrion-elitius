{if $payments}
	<table class="table table-bordered table-striped">
	<tr>
		<th>{lang key="payment_id"}</th>
		<th>{lang key="date"}</th>
		<th>{lang key="time"}</th>
		<th>{lang key="total_sales"}</th>
		<th>{lang key="commissions"}</th>
	</tr>
	{foreach $payments as $payment}
		<tr>
			<td>{$payment.id}</td>
			<td>{$payment.date}</td>
			<td>{$payment.time}</td>
			<td>{$payment.sales}</td>
			<td>{$payment.commission}</td>
		</tr>
	{/foreach}
	</table>
{else}
	<div class="alert alert-info">{lang key="history_clear"}</div>
{/if}