{if $commissions}
	<table class="table table-bordered table-striped">
		<thead>
			<th>{lang key="sell_date"}</th>
			<th>{lang key="status"}</th>
			<th>{lang key="sale_amount"}</th>
			<th>{lang key="action"}</th>
		</thead>
		{foreach $commissions as $commission}
			<tr>
				<td>{$commission.date}</td>
				<td>{if $commission.status eq 'approval'}{lang key="approved"}{else}{lang key="pending"}{/if}</td>
				<td>{$commission.payment}</td>
				<td><a href="{$smarty.const.IA_SELF}?{if $smarty.get.type}type={$smarty.get.type}&{/if}{if $smarty.get.page}page={$smarty.get.page}&{/if}{if $smarty.get.items}items={$smarty.get.items}&{/if}id={$commission.id}" >{lang key="small_view_details"}</a></td>
			</tr>
		{/foreach}
	</table>

{elseif $smarty.get.id > 0}
	<strong style="color: #FF0000">{lang key="msh_incorrect_param"}</strong>
{/if}

<table class="table table-bordered table-striped">
	<tr>
		<td width="150"><strong>{lang key="sell_date"}</strong></td>
		<td>{$commission.date} {$commission.time}</td>
	</tr>
	<tr>
		<td><strong>{lang key="sale_amount"}</strong></td>
		<td>{$commission.payment}</td>
	</tr>
	<tr>
		<td><strong>{lang key="commissions"}</strong></td>
		<td>{$commission.payment*$percent}</td>
	</tr>
	<tr>
		<td><strong>{lang key="order_number"}</strong></td>
		<td>{$commission.order_number}</td>
	</tr>
</table>