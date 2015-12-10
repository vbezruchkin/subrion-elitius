Ext.onReady(function()
{
	var pageUrl = intelli.config.admin_url + '/affiliates/commissions/';

	if (Ext.get('js-grid-placeholder'))
	{
		intelli.commissions = new IntelliGrid(
		{
			columns: [
				'selection',
				{name: 'product', title: _t('product'), width: 1},
				{name: 'member', title: _t('member'), width: 1},
				{name: 'order_number', title: _t('reference_id'), width: 200},
				{name: 'sale_amount', title: _t('sale_amount'), width: 100},
				{name: 'payout_amount', title: _t('payout_amount'), width: 100},
				{name: 'sale_date', title: _t('sale_date'), width: 100},
				'status',
				'update',
				'delete'
			],
			statuses: ['active', 'pending', 'failed', 'refunded'],
			texts: {
				delete_single: _t('are_you_sure_to_delete_this_commission'),
				delete_multiple: _t('are_you_sure_to_delete_selected_commissions')
			},
			url: pageUrl
		}, false);

		intelli.commissions.toolbar = Ext.create('Ext.Toolbar', {items:
		[
			{
				emptyText: _t('title'),
				xtype: 'textfield',
				id: 'searchTitle',
				listeners: intelli.gridHelper.listener.specialKey
			}, {
				emptyText: _t('status'),
				xtype: 'combo',
				typeAhead: true,
				editable: false,
				id: 'stsFilter',
				lazyRender: true,
				store: intelli.commissions.stores.statuses,
				displayField: 'title',
				valueField: 'value'
			}, {
				text: '<i class="i-search"></i> ' + _t('search'),
				id: 'fltBtn',
				handler: function()
				{
					var text = Ext.getCmp('searchTitle').getValue();
					var status = Ext.getCmp('stsFilter').getValue();

					if (text || status)
					{
						intelli.commissions.store.getProxy().extraParams = {text: text, status: status};
						intelli.commissions.store.reload();
					}
				}
			}, '-', {
				text: '<i class="i-close"></i> ' + _t('reset'),
				id: 'resetBtn',
				handler: function()
				{
					Ext.getCmp('searchTitle').reset();
					Ext.getCmp('stsFilter').reset();

					intelli.commissions.store.getProxy().extraParams = {};
					intelli.commissions.store.reload();
				}
			}
		]});

		intelli.commissions.init();

		if (intelli.urlVal('status'))
		{
			Ext.getCmp('stsFilter').setValue(intelli.urlVal('status'));
		}

		var search = intelli.urlVal('quick_search');
		if (null != search)
		{
			Ext.getCmp('searchTitle').setValue(search);
		}
	}
	else
	{
		// get members autocomplete
		$('#field_member').typeahead(
		{
			source: function (query, process)
			{
				return $.ajax(
				{
					url: pageUrl + 'read.json',
					type: 'get',
					dataType: 'json',
					data: {q: query, action: 'members'},
					success: function (data)
					{
						return typeof data.options == 'undefined' ? false : process(data.options);
					}
				});
			}
		});
	}
});