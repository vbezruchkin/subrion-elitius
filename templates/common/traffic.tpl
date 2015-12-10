{if $traffic.visitors}
	<table class="table table-bordered table-striped">
		<thead>
		<th>{lang key='product'}</th>
		<th>{lang key='ip_address'}</th>
		<th>{lang key='refererring_url'}</th>
		<th>{lang key='date'}</th>
		<th>{lang key='status'}</th>
		</thead>
		{foreach $traffic.visitors as $visitor}
			<tr>
				<td>{$visitor.product_id}</td>
				<td>{$visitor.ip|long2ip}</td>
				<td>{$visitor.referrer}</td>
				<td>{$visitor.datetime}</td>
				<td>{$visitor.status}</td>
			</tr>
		{/foreach}
	</table>
{else}
	<div class="alert alert-info">No visitors.</div>
{/if}