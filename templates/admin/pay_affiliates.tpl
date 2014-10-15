{include file="box-header.tpl" title=$gTitle}
<form action="{$smarty.const.IA_SELF}" method="post" name="adminForm">
	{preventCsrf}
	<table width="100%"><tbody><tr>
		<td valign="top" width="60%">
			<table class="common">
			<tbody>
			<tr>
				<th colspan="2" class="caption">{lang key="affiliate_info"}</th>
			</tr>
			<tr>
				<td width="100">{lang key="affiliate"} ID:</td>
				<td width="85%">{$acc.id}</td>
			</tr>
			<tr>
				<td>{lang key="field_username"}:</td>
				<td>{$acc.username}</td>
			</tr>
			<tr>
				<td>{lang key="field_fullname"}:</td>
				<td>{$acc.fullname}</td>
			</tr>
			<tr>
				<td>{lang key="field_phone"}:</td>
				<td>{$acc.phone}</td>
			</tr>
			<tr>
				<td>{lang key="field_fax"}:</td>
				<td>{$acc.fax}</td>
			</tr>{*
			<tr>
				<td>{lang key="federal_tax"}:</td>
				<td>{$acc.taxid}</td>
			</tr>*}

			<tr><th colspan="2">{lang key="billing_address"}</th></tr>
			<tr><td colspan="2">{$acc.fullname}</td></tr>
			<tr><td colspan="2">{$acc.address}</td></tr>
			<tr><td colspan="2">{if not empty($acc.city)}{$acc.city},{/if} {$acc.state} - {if not empty($acc.zip)}{$acc.zip},{/if} {$acc.country}</td></tr>
			</tbody></table>
		</td>
		<td valign="top" width="40%">
			<table class="common"><tbody>
				<tr>
					<th colspan="2" class="caption">{lang key="commissions"}</th>
				</tr>
				<tr>
					<td width="100">{lang key="commission"}:</td>
					<td width="85%">{$format_commissions}</td>
				</tr>
				<tr>
					<td>{lang key="number_sales"}:</td>
					<td>{$commission.Sales}</td>
				</tr>
				<tr style="font-weight: bold;">					
					<th colspan="2">{lang key="sales_this_payment"}:</th>
				</tr>
				<tr><td colspan=2>
					<div style="height:{$sales_height}px;width: auto; overflow: auto;">
						<ul>
						{foreach from=$sales item="sale"}
							<li><i>{$sale.date}:</i> {$sale.payment}</li>
						{/foreach}
						</ul>
					</div>
				</td></tr>
				<tr style="font-weight: bold;">
					<td>{lang key="earned_commission"}:</td>
					<td>{$format_commissions}</td>
				</tr>
			</tbody></table>
		</td>
	</tr></tbody></table>

	<input name="id" value="{$smarty.get.id}" type="hidden" />
	<input name="sales" value="{$commission.Total}" type="hidden" />
	<input name="commission" value="{$commission_total}" type="hidden" />

	<input name="action" value="arhive" type="hidden" />
	<center><input type="submit" name="submit" value="{lang key='pay_to_archive'}"/></center>
</form>
<table style="width: 100%;">
	<tr>
		<td style="text-align: center;">
		{if $acc.paypal_email}
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target=_blank>
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="amount" value="{$commission_total}" />
				<input type="hidden" name="item_number" value="Affiliate_Payment_{$smarty.now|date:'%Y-%m-%d'}"/>
				<input type="hidden" name="item_name" value="{$config.site} Affiliate Payment"/>
				<input type="hidden" name="business" value="{$acc.paypal_email}">
				<input type="hidden" name="cmd" value="_xclick"/>
				<input type="submit" name="submit" value="{lang key='pay_using_PayPal'}"/>
			</form>
		{else}
			<font color="#CC0000">{lang key="PayPal_payment_not_available"}</font>
		{/if}
		</td>
	</tr>
</table>
{include file="box-footer.tpl"}