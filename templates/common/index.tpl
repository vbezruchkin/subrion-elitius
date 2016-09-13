<strong>Affiliate link</strong>
<div class="well">
	{$core.packages.affiliates.url}track/{$member.id}/
</div>

<table class="table table-striped">
	<tr><th colspan="2"><b>{lang key="traffic_stat"}</b></th></tr>
	<tr>
		<td>{lang key="visits"}:</td>
		<td>{$traffic.visits}</td>
	</tr>
	<tr>
		<td>{lang key="unique_visitors"}:</td>
		<td>{$traffic.visitors}</td>
	</tr>
	<tr>
		<td>{lang key="sales"}:</td>
		<td>{$traffic.sales}</td>
	</tr>
</table>

<table class="table table-bordered">
	<tbody><tr>
		<td width="55%" colspan="2"><strong>Current Commissions - From Last Payout To Date</strong></td>
	</tr>
	<tr>
		<td width="30%">{lang key='transactions'}</td>
		<td width="25%">0</td>
	</tr>
	<tr>
		<td width="30%">{lang key='earnings'}</td>
		<td width="25%">${$stat.earnings} USD</td>
	</tr>
	<tr>
		<td width="55%" colspan="2"><strong>Traffic Statistics</strong></td>
	</tr>
	<tr>
		<td width="30%">Visitors</td>
		<td width="25%">417</td>
	</tr>
	<tr>
		<td width="30%">Unique Visitors</td>
		<td width="25%">36</td>
	</tr>
	<tr>
		<td width="30%">Total Sales</td>
		<td width="25%">4</td>
	</tr>
	<tr>
		<td width="30%">{lang key='sales_ratio'}</td>
		<td width="25%">{$traffic.ratio}%</td>
	</tr>
	</tbody>
</table>

<h3>Visitors: {$traffic.visitors_num}</h3>
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

<h3>Sales</h3>
{if $traffic.sales}
	<table class="table table-striped">
		<tr><th colspan="2"><b>{lang key="traffic_stat"}</b></th></tr>
		<tr>
			<td>{lang key="visits"}:</td>
			<td>{$traffic.visits}</td>
		</tr>
	</table>
{else}
	<div class="alert alert-info">No sales.</div>
{/if}