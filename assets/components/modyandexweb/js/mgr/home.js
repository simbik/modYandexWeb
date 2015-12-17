modYandexWeb.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'modyandexweb-panel-home'
		}]
	});
	modYandexWeb.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(modYandexWeb.page.Home, MODx.Component);
Ext.reg('modyandexweb-page-home', modYandexWeb.page.Home);