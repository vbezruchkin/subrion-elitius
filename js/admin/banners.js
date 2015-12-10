Ext.onReady(function()
{
	intelli.banners = new IntelliGrid(
	{
		columns: [
			'selection',
			'expander',
			{name: 'title', title: _t('title'), width: 1, editor: 'text'},
			{name: 'product', title: _t('product'), width: 2},
			'status',
			'update',
			'delete'
		],
		expanderTemplate: '{description}',
		fields: ['description'],
		url: intelli.config.admin_url + '/affiliates/banners/'
	}, false);

	intelli.banners.toolbar = Ext.create('Ext.Toolbar', {items:
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
			store: intelli.banners.stores.statuses,
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
					intelli.banners.store.getProxy().extraParams = {text: text, status: status};
					intelli.banners.store.reload();
				}
			}
		}, '-', {
			text: '<i class="i-close"></i> ' + _t('reset'),
			id: 'resetBtn',
			handler: function()
			{
				Ext.getCmp('searchTitle').reset();
				Ext.getCmp('stsFilter').reset();

				intelli.banners.store.getProxy().extraParams = {};
				intelli.banners.store.reload();
			}
		}
	]});

	intelli.banners.init();

	if (intelli.urlVal('status'))
	{
		Ext.getCmp('stsFilter').setValue(intelli.urlVal('status'));
	}

	var search = intelli.urlVal('quick_search');
	if (null != search)
	{
		Ext.getCmp('searchTitle').setValue(search);
	}
});