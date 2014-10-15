<div style="float:left;width:48%;padding:5px;">
	{include file="box-header.tpl" title=$gTitle}
	<form action="{$smarty.const.IA_SELF}" method="post" name="adminForm">
		{preventCsrf}
		<table cellspacing="0" width="100%" class="common">
			<tr class="caption">
				<th class="first">{lang key="pay_level"}</th>
				<th>{lang key="payout_amount"}</th>
				<th>{lang key="add_payout_level"}</th>
			</tr>
			{foreach from=$paylevels item="pay"}
			<tr>
				<td><b>{lang key="level"} {$pay.level}</b></td>
				<td><input name="amt_{$pay.level}" class="common" type="text" size="8" value="{$pay.amt}"/><b>%</b></td>
				<td><a href="{$smarty.const.IA_SELF}?delete={$pay.id}" >{lang key="delete"}</a></td>
			</tr>
			{/foreach}
		</table>
		<input name="id" value="{$payid}" type="hidden" />
		<input name="sales" value="{$commission.total}" type="hidden" />
		<input name="commission" value="{$commission.total*$config.payout_percent/100}" type="hidden" />
		<input name="task" value="save" type="hidden" />
		<input type="submit" class="common" value="{lang key='save'}"/>
	</form>
	{include file="box-footer.tpl"}
</div>
<div style="float:left;width:48%;padding:5px;">
	{include file="box-header.tpl" title=$lang.add_payout_level}
		<form action="{$smarty.const.IA_SELF}" method="post">
			{preventCsrf}
			<table cellpadding="0" cellspacing="0" width="100%" class="common">
				<tr>
					<td>{lang key="payout_level"}</td>
					<td>
						<select name="level">
							{section loop=15 start=$paylevel name="payout"}
							<option value="{$smarty.section.payout.index}">{$smarty.section.payout.index}</option>
							{/section}
						</select>
					</td>
				</tr>
				<tr>
					<td>{lang key="payout_percentage"}</td>
					<td>
						<select name="percent">
							{section loop=101 start=1 name="perc"}
							<option value="{$smarty.section.perc.index}">{$smarty.section.perc.index} %</option>
							{/section}
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="hidden" name="task" value="add" />
						<input type="submit" class="common" value="{lang key='add'}"/>
					</td>
				</tr>
			</table>
		</form>
	{include file="box-footer.tpl"}
</div>