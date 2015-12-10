Ext.onReady(function()
{
	intelli.traffic = new IntelliGrid(
	{
		columns: [
			'selection',
			{name: 'member', title: _t('member'), width: 2},
			{name: 'salt', title: _t('visitor_id'), width: 220},
			{name: 'product', title: _t('product'), width: 220},
			{name: 'referrer', title: _t('refererring_url'), width: 220},
			{name: 'datetime', title: _t('date'), width: 120},
			{name: 'ip', title: _t('ip_address'), width: 120},
			{name: 'status', title: _t('status'), width: 120},
			'delete'
		],
		url: intelli.config.admin_url + '/affiliates/visitors/'
	}, false);

	intelli.traffic.toolbar = Ext.create('Ext.Toolbar', {items:
	[
		{
			emptyText: _t('member'),
			xtype: 'textfield',
			id: 'searchMember',
			listeners: intelli.gridHelper.listener.specialKey
		}, {
			emptyText: _t('product'),
			xtype: 'textfield',
			id: 'searchProduct',
			listeners: intelli.gridHelper.listener.specialKey
		}, {
			text: '<i class="i-search"></i> ' + _t('search'),
			id: 'fltBtn',
			handler: function()
			{
				var text = Ext.getCmp('searchTitle').getValue();
				var status = Ext.getCmp('stsFilter').getValue();

				if (text || status)
				{
					intelli.traffic.store.getProxy().extraParams = {text: text, status: status};
					intelli.traffic.store.reload();
				}
			}
		}, '-', {
			text: '<i class="i-close"></i> ' + _t('reset'),
			id: 'resetBtn',
			handler: function()
			{
				Ext.getCmp('searchTitle').reset();
				Ext.getCmp('stsFilter').reset();

				intelli.traffic.store.getProxy().extraParams = {};
				intelli.traffic.store.reload();
			}
		}
	]});

	intelli.traffic.init();
});