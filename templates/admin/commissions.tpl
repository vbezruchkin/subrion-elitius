<form method="post" enctype="multipart/form-data" class="sap-form form-horizontal">
	{preventCsrf}

	{capture name='sale_amount' append='field_before'}
		<div class="row">
			<label for="field_product" class="col col-lg-2 control-label">{lang key='product'} <span class="text-danger">*</span></label>
			<div class="col col-lg-4">
				<select name="product" id="field_product">
					<option value="-1">{lang key='_select_'}</option>
					{foreach $products as $product}
						<option value="{$product.id}" {if 'edit' == $pageAction && $product.id == $item.product_id}selected="selected"{/if}>{$product.title}</option>
					{/foreach}
				</select>
			</div>
		</div>

		<div class="row">
			<label class="col col-lg-2 control-label" for="field_member">{lang key='member'} <span class="text-danger">*</span></label>

			<div class="col col-lg-4">
				<input type="text" name="member" autocomplete="off" id="field_member" value="{if isset($item.member)}{$item.member}{/if}">
			</div>
		</div>
	{/capture}

	{include file='field-type-content-fieldset.tpl' item_sections=$fields_groups isSystem=true}
</form>

{ia_add_media files='js:_IA_URL_packages/affiliates/js/admin/commissions'}