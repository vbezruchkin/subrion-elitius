intelli.pay = function()
{	
	return {
		title: _t('manage_banners'),
		url: intelli.config.admin_url + '/ajax/pay/affiliates/',
		removeBtn: false,
		progressBar: true,
		statusesStore: ['active','approval'],
		record:['username', 'Total', 'Sales', 'aff_id', {name: 'edit', mapping: 'aff_id'}, 'remove'],
		/*tbar: [
			_t('field_banner_name') + ':',{
				xtype: 'textfield',
				name: 'searchName',
				id: 'searchName',
				emptyText: 'Enter banner name'
			},{
				text: _t('search'),
				iconCls: 'search-grid-ico',
				id: 'fltBtn',
				handler: function()
				{
					var name = Ext.getCmp('searchName').getValue();

					if('' != name)
					{
						intelli.banner.dataStore.baseParams.name = name;
						intelli.banner.dataStore.reload();
					}
				}
			},'-',{
				text: _t('reset'),
				id: 'resetBtn',
				handler: function()
				{
					Ext.getCmp('searchName').reset();
					intelli.banner.dataStore.baseParams.name = '';
					intelli.banner.dataStore.reload();
				}
			}
		],*/
		columns:[
			'checkcolumn',
			{
				custom: 'expander',
				tpl: '{desc}'
			},{
				header: _t('username'), 
				dataIndex: 'username', 
				sortable: true, 
				width: 150,
				renderer: function(val, item, obj){
					return '<a href="'+intelli.config.admin_url + '/elitius/accounts/history/?id=' + obj.json.aff_id+'">'+val+'</a>';
				}
			},{
				header: _t('sales'), 
				dataIndex: 'Sales', 
				sortable: true, 
				width: 150
			},{
				header: _t('balance'), 
				dataIndex: 'Total', 
				width: 100
			},{
				custom: 'aff_id',
				redirect: intelli.config.admin_url+'/pay/affiliates/?id=',
				icon: 'edit-grid-ico.png',
				title: _t('edit')
			}
			,'remove'
		]
	};
}();

Ext.onReady(function(){
	intelli.pay = new intelli.exGrid(intelli.pay);
	intelli.pay.init();
	
});