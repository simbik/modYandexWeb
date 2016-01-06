modYandexWeb.panel.Home = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'modyandexweb-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		style: {margin: '0 0 0 20px'},
		items: [{
			html: '<h2>' + _('modyandexweb') + '</h2>',
			cls: '',
			style: {margin: '15px 0'}
		}, {
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: true,
			hideMode: 'offsets',
			items: [{
				title: _('modyandexweb_metrika'),
				layout: 'anchor',
				items: [{
					html: _('modyandexweb_metrika_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'modyandexweb-grid-metrika',
					cls: 'main-wrapper',
				}]
			}/*,{
				title: _('modyandexweb_webmaster'),
				layout: 'anchor',
				items: [{
					html: _('modyandexweb_webmaster_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'modyandexweb-grid-webmaster',
					cls: 'main-wrapper',
				}]
			}*/]
		}]
	});
	modYandexWeb.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(modYandexWeb.panel.Home, MODx.Panel);
Ext.reg('modyandexweb-panel-home', modYandexWeb.panel.Home);
