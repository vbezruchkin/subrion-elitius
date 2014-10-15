intelli.ad = function()
{	
	return {
		oGrid: null,
		title: _t('manage_ads'),
		url: intelli.config.admin_url + '/ajax/manage/eads/',
		removeBtn: true,
		progressBar: true,
		texts: {
			confirm_one: _t('are_you_sure_to_delete_this_ad'),			
			confirm_many: _t('are_you_sure_to_delete_selected_ads')
		},
		statusesStore: ['active','approval'],
		record:['title', 'product', 'pid', 'content', 'status', 'edit', 'remove'],
		tbar: [
				_t('ad_title') + ':',{
					xtype: 'textfield',
					name: 'searchTitle',
					id: 'searchTitle',
					emptyText: 'Enter ad title'
				},'-',_t('ad_text') + ':',{
					xtype: 'textfield',
					name: 'searchText',
					id: 'searchText',
					emptyText: 'Enter ad text'
				},{
					text: _t('search'),
					iconCls: 'search-grid-ico',
					id: 'fltBtn',
					handler: function()
					{
						var title = Ext.getCmp('searchTitle').getValue();
						var text = Ext.getCmp('searchText').getValue();

						if('' != title || '' != text)
						{
							intelli.ad.dataStore.baseParams.title = title;
							intelli.ad.dataStore.baseParams.text = text;
							intelli.ad.dataStore.reload();
						}
					}
				},'-',{
					text: _t('reset'),
					id: 'resetBtn',
					handler: function()
					{
						Ext.getCmp('searchTitle').reset();
						Ext.getCmp('searchText').reset();
						intelli.ad.dataStore.baseParams.title = '';
						intelli.ad.dataStore.baseParams.text = '';
						intelli.ad.dataStore.reload();
					}
				}
			],
		columns:[
			'checkcolumn',{
				header: _t('ad_title'), 
				dataIndex: 'title', 
				sortable: true, 
				width: 150,
				editor: new Ext.form.TextField({
					allowBlank: false
				})
			},{
				header: _t('product_name'), 
				dataIndex: 'product', 
				sortable: true, 
				width: 150,
				renderer: function(val, item, obj){
					return '<a href="'+intelli.config.admin_url + '/manage/products/edit/?id=' + obj.json.pid+'">'+val+'</a>';
				}
			},{
				header: _t('ad_text'), 
				dataIndex: 'content', 
				width: 100
			},'status',{
				custom: 'edit',
				redirect: intelli.config.admin_url+'/manage/eads/edit/?id=',
				icon: 'edit-grid-ico.png',
				title: _t('edit')
			},'remove'
		]
	};
}();

Ext.onReady(function(){
	intelli.ad = new intelli.exGrid(intelli.ad);
	intelli.ad.init();	
});