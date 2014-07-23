intelli.commission = function()
{	
	return {
		oGrid: null,
		title: _t('manage_commissions'),
		url: intelli.config.admin_url + '/ajax/elitius/commissions/current/',
		removeBtn: true,
		progressBar: true,
		texts: {
			confirm_one: _t('are_you_sure_to_delete_this_commission'),			
			confirm_many: _t('are_you_sure_to_delete_selected_commissions')
		},
		statusesStore: ['active','approval'],
		record:['username', 'approval', 'approved', 'total'],
		tbar: [
			_t('username') + ':',
			{
				xtype: 'textfield',
				name: 'searchUsername',
				id: 'searchUsername',
				emptyText: 'Enter username'
			},{
				text: _t('search'),
				iconCls: 'search-grid-ico',
				id: 'fltBtn',
				handler: function()
				{
					var username = Ext.getCmp('searchUsername').getValue();

					if('' != username)
					{
						intelli.commission.dataStore.baseParams = { action: 'get', username: username};
						intelli.commission.dataStore.reload();
					}
				}
			},'-',{
				text: _t('reset'),
				id: 'resetBtn',
				handler: function()
				{
					Ext.getCmp('searchUsername').reset();
					intelli.commission.dataStore.baseParams = { action: 'get', username: '' };
					intelli.commission.dataStore.reload();
				}
			}
		],
		columns:[
			'checkcolumn',
			{
				header: _t('username'), 
				dataIndex: 'username', 
				sortable: true, 
				width: 150
			},{
				header: _t('approval'), 
				dataIndex: 'approval', 
				width: 150
			},{
				header: _t('approved'), 
				dataIndex: 'approved',
				width: 150
			},{
				header: _t('total'), 
				dataIndex: 'total',
				width: 150
			},{
				custom: 'user',
				redirect: intelli.config.admin_url+'/manage/commissions/?user=',
				icon: 'edit-grid-ico.png',
				title: _t('user')
			}
		]
	};
}();

Ext.onReady(function(){
	intelli.commission = new intelli.exGrid(intelli.commission);
	intelli.commission.init();
	
});