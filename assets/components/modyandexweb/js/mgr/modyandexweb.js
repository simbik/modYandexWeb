var modYandexWeb = function (config) {
	config = config || {};
	modYandexWeb.superclass.constructor.call(this, config);
};
Ext.extend(modYandexWeb, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('modyandexweb', modYandexWeb);

modYandexWeb = new modYandexWeb();