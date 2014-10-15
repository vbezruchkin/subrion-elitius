<form method="post" enctype="multipart/form-data" class="sap-form form-horizontal">
	{preventCsrf}

	{capture name='title' append='field_before'}
		<div class="row">
			<label for="" class="col col-lg-2 control-label">{lang key='product'}</label>
			<div class="col col-lg-4">
				<select name="product">
					<option value="-1">{lang key='_select_'}</option>
					{foreach $products as $product}
						<option value="{$product.id}" {if 'edit' == $pageAction && $product.id == $item.product_id}selected="selected"{/if}>{$product.title}</option>
					{/foreach}
				</select>
			</div>
		</div>
	{/capture}

	{include file='field-type-content-fieldset.tpl' item_sections=$fields_groups isSystem=true}
</form>