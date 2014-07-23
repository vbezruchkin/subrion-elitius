<div style="float:left;width:48%;padding:5px;">
	{include file="box-header.tpl" title=$gTitle}
	<form action="{$smarty.const.IA_SELF}" method="post" name="adminForm">
		{preventCsrf}
		<table cellspacing="0" width="100%" class="common">
			<tr class="caption">
				<th class="first">{lang key="tier_level"}</th>
				<th>{lang key="payout_amount"}</th>
				<th>{lang key="action"}</th>
			</tr>
			{foreach from=$paylevels item="pay"}
			<tr>
				<td class="first center"><b>{lang key="level"} {$pay.level}</b></td>
				<td><input name="amt_{$pay.level}" type="text" size="10" class="common" value="{$pay.amt}"/><b>&nbsp;%</b></td>
				<td><a href="{$smarty.const.IA_SELF}?delete={$pay.id}" >{lang key="delete"}</a></td>
			</tr>
			{/foreach}
		</table>
		<input class="common" value="Save" type="submit" />
		<input name="id" value="{$smarty.get.id}" type="hidden" />
		<input name="sales" value="{$commission.total}" type="hidden" />
		<input name="commission" value="{$commission.total*$config.payout_percent/100}" type="hidden" />
		<input name="task" value="save" type="hidden" />
	</form>
	{include file="box-footer.tpl"}
</div>
<div style="float:left;width:48%;padding:5px;">
	{include file="box-header.tpl" title=$lang.add_tiers}
		<form action="{$smarty.const.IA_SELF}" method="post">
			{preventCsrf}
			<table cellpadding="0" cellspacing="0" width="100%" class="common">
				<tr>
					<td>{lang key="payout_level"}</td>
					<td>
						<select name="level" style="width: 70px;">
						{section name="level" loop=15-$max start=$max+1 max="16"}
							<option value="{$smarty.section.level.index}">{$smarty.section.level.index}</option>
						{/section}
						</select>
					</td>
				</tr>
				<tr>
					<td>{lang key="payout_percentage"}</td>
					<td>
						<select name="percent">
						{section name="percent" loop="100" start="1"}
							<option value="{$smarty.section.percent.index}" {if $max_percent eq $smarty.section.percent.index}selected="selected"{/if}>{$smarty.section.percent.index}%</option>
						{/section}
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="hidden" name="task" value="add" />
						<input class="common" type="submit" value="{lang key='add'}"/>
					</td>
				</tr>
			</table>
		</form>
	{include file="box-footer.tpl"}
</div>