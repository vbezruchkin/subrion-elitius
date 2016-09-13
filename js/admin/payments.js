intelli.accounts = function()
{	
	return {
		title: _t('account_history'),
		url: intelli.config.admin_url + '/ajax/elitius/accounts/history/?user='+intelli.urlVal('id'),
		removeBtn: true,
		progressBar: true,
		statusesStore: ['active','approval'],
		record:['id','username', 'commission', 'avg', 'total'],
		tbar: [
			_t('field_username') + ':',{
				xtype: 'textfield',
				name: 'searchName',
				id: 'searchName',
				emptyText: 'Enter user name'
			},{
				text: _t('search'),
				iconCls: 'search-grid-ico',
				id: 'fltBtn',
				handler: function()
				{
					var name = Ext.getCmp('searchName').getValue();

					if('' != name)
					{
						intelli.accounts.dataStore.baseParams.name = name;
						intelli.accounts.dataStore.reload();
					}
				}
			},'-',{
				text: _t('reset'),
				id: 'resetBtn',
				handler: function()
				{
					Ext.getCmp('searchName').reset();
					intelli.accounts.dataStore.baseParams.name = '';
					intelli.accounts.dataStore.reload();
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
				header: _t('last_payment'), 
				dataIndex: 'commission', 
				sortable: false,
				width: 150
			},{
				header: _t('average_payment'), 
				dataIndex: 'avg',
				sortable: false,
				hideable: false,
				menuDisabled: true,
				width: 150
			},{
				header: _t('total_payments'), 
				dataIndex: 'total',
				sortable: false,
				hideable: false,
				menuDisabled: true,
				width: 150
			},{
				dataIndex: 'id',
				width: 30,
				sortable: false,
				hideable: false,
				menuDisabled: true,
				renderer: function(val, item, obj){
					return '<img onclick="reload('+obj.json.aff_id+')" src="' + intelli.config.admin_url + '/templates/' + intelli.config.admin_tmpl + '/img/icons/edit-grid-ico.png">';
				}
			}
		]
	};
}();
var reload = function(id){
	intelli.history.grid.show();
	intelli.history.dataStore.baseParams.user = id;
	intelli.history.dataStore.reload();
}
intelli.history = function()
{	
	return {
		title: _t('payment_history'),
		url: intelli.config.admin_url + '/ajax/elitius/accounts/history/',
		removeBtn: true,
		progressBar: true,
		action: 'gethistory',
		tbar: ['Summary: ',{
			xtype: 'textfield',
	        id: 'summary-text'
	    }],
		statusesStore: ['active','approval'],
		record:['id','uid','username', 'date', 'sales', 'commission', 'total'],
		columns:[
			'checkcolumn',
			{
				header: 'UID', 
				dataIndex: 'uid', 
				sortable: true, 
				hideable: false,
				width: 150
			},{
				header: _t('date'), 
				dataIndex: 'date', 
				hideable: false,
				width: 150
			},{
				header: _t('sales'), 
				dataIndex: 'sales',
				hideable: false,
				width: 150
			},{
				header: _t('amount'), 
				dataIndex: 'commission',
				hideable: false,
				width: 150
			}/*,{
				dataIndex: 'id',
				width: 30,
				hideable: false,
				menuDisabled: true,
				renderer: function(val, item, obj){
					return '<img onclick="console.log(\'ares\')" src="' + intelli.config.admin_url + '/templates/' + intelli.config.admin_tmpl + '/img/icons/edit-grid-ico.png">';
				}
			}*/
		]
	};
}();
Ext.onReady(function(){
	
	intelli.history = new intelli.exGrid(intelli.history);
	intelli.history.init();
	intelli.history.dataStore.on('load', function(item){
		if(item.data.items[0])
		{
			Ext.getCmp("summary-text").setValue(item.data.items[0].data.total);
		}
	}, 2000)
	intelli.history.grid.hide();
	
	intelli.accounts = new intelli.exGrid(intelli.accounts);
	intelli.accounts.init();
});