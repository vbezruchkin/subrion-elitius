<h2>{lang key="general_statistics"}</h2>

<table cellpadding="0" cellspacing="0" class="common">
	<tr><th class="header" colspan="2"><b>{lang key="commissions"}</b></th></tr>
	<tr>
		<td class="title">{lang key="transactions"}:</td>
		<td>{$stat.transactions}</td>
	</tr>
	<tr>
		<td class="title">{lang key="earnings"}:</td>
		<td class="main">${$stat.earnings}</td>
	</tr>
</table>
<br />
<table cellpadding="0" cellspacing="0" class="common">
	<tr><th class="header" colspan="2"><b>{lang key="traffic_stat"}</b></th></tr>
	<tr>
		<td class="title">{lang key="visits"}:</td>
		<td class="main">{$traffic.visits}</td>
	</tr>
	<tr>
		<td class="title">{lang key="unique_visitors"}:</td>
		<td class="main">{$traffic.visitors}</td>
	</tr>
	<tr>
		<td class="title">{lang key="sales"}:</td>
		<td class="main">{$traffic.sales}</td>
	</tr>
	<tr>
		<td class="title">{lang key="sales_ratio"}:</td>
		<td class="main">{$traffic.ratio}%</td>
	</tr>
</table>
