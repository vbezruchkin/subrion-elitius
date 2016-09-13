Ext.onReady(function()
{
	intelli.products = new IntelliGrid(
	{
		columns: [
			'selection',
			'expander',
			{name: 'title', title: _t('title'), width: 1, editor: 'text'},
			{name: 'url', title: _t('redirect_url'), width: 1, editor: 'text'},
			{name: 'amount', title: _t('amount'), width: 80},
			{name: 'commission_type', title: _t('type'), width: 80},
			'status',
			'update',
			'delete'
		],
		expanderTemplate: '{description}',
		fields: ['description', 'url'],
		url: intelli.config.admin_url + '/affiliates/products/'
	}, false);

	intelli.products.toolbar = Ext.create('Ext.Toolbar', {items:
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
		store: intelli.products.stores.statuses,
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
					intelli.products.store.getProxy().extraParams = {title: text, status: status};
					intelli.products.store.reload();
				}
			}
		}, '-', {
			text: '<i class="i-close"></i> ' + _t('reset'),
			id: 'resetBtn',
			handler: function()
			{
				Ext.getCmp('searchTitle').reset();
				Ext.getCmp('stsFilter').reset();

				intelli.products.store.getProxy().extraParams = {};
				intelli.products.store.reload();
			}
		}
	]});

	intelli.products.init();

	if (intelli.urlVal('status'))
	{
		Ext.getCmp('stsFilter').setValue(intelli.urlVal('status'));

		intelli.gridHelper.search(intelli.products);
	}
});