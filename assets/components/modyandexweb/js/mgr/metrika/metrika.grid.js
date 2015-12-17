modYandexWeb.grid.Metrika = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'modyandexweb-grid-metrika';
	}
	Ext.applyIf(config, {
		url: modYandexWeb.config.connector_url,
		fields: this.getFields(config),
		columns: this.getColumns(config),
		tbar: this.getTopBar(config),
		sm: new Ext.grid.CheckboxSelectionModel(),
		baseParams: {
			action: 'mgr/metrika/getlist'
		},
		listeners: {
			rowDblClick: function (grid, rowIndex, e) {
				var row = grid.store.getAt(rowIndex);
				this.updateCounter(grid, e, row);
			}
		},
		viewConfig: {
			forceFit: true,
			enableRowBody: true,
			autoFill: true,
			showPreview: true,
			scrollOffset: 0,
		},
		paging: true,
		remoteSort: true,
		autoHeight: true,
	});
	modYandexWeb.grid.Metrika.superclass.constructor.call(this, config);

	// Clear selection on grid refresh
	this.store.on('load', function () {
		if (this._getSelectedIds().length) {
			this.getSelectionModel().clearSelections();
		}
	}, this);
};
Ext.extend(modYandexWeb.grid.Metrika, MODx.grid.Grid, {
	windows: {},

	getMenu: function (grid, rowIndex) {
		var ids = this._getSelectedIds();

		var row = grid.getStore().getAt(rowIndex);
		var menu = modYandexWeb.utils.getMenu(row.data['actions'], this, ids);

		this.addContextMenuItem(menu);
	},

	/*createCounter: function (btn, e) {
		var w = MODx.load({
			xtype: 'modyandexweb-metrika-window-create',
			id: Ext.id(),
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		});
		w.reset();
		w.setValues({active: true});
		w.show(e.target);
	},

	udpdateCounter: function (btn, e, row) {
		if (typeof(row) != 'undefined') {
			this.menu.record = row.data;
		}
		else if (!this.menu.record) {
			return false;
		}
		var id = this.menu.record.id;

		MODx.Ajax.request({
			url: this.config.url,
			params: {
				action: 'mgr/metrika/get',
				id: id
			},
			listeners: {
				success: {
					fn: function (r) {
						var w = MODx.load({
							xtype: 'modyandexweb-metrika-window-update',
							id: Ext.id(),
							record: r,
							listeners: {
								success: {
									fn: function () {
										this.refresh();
									}, scope: this
								}
							}
						});
						w.reset();
						w.setValues(r.object);
						w.show(e.target);
					}, scope: this
				}
			}
		});
	},

	removeCounter: function (act, btn, e) {
		var ids = this._getSelectedIds();
		if (!ids.length) {
			return false;
		}
		MODx.msg.confirm({
			title: ids.length > 1
				? _('modyandexweb_metrika_remove')
				: _('modyandexweb_counter_remove'),
			text: ids.length > 1
				? _('modyandexweb_metrika_remove_confirm')
				: _('modyandexweb_counter_remove_confirm'),
			url: this.config.url,
			params: {
				action: 'mgr/counter/remove',
				ids: Ext.util.JSON.encode(ids),
			},
			listeners: {
				success: {
					fn: function (r) {
						this.refresh();
					}, scope: this
				}
			}
		});
		return true;
	},

	*/

	getFields: function (config) {
		return ['id', 'name', 'site', 'code_status', 'permission', 'actions'];
	},

	getColumns: function (config) {
		return [{
			header: _('modyandexweb_counter_id'),
			dataIndex: 'id',
			sortable: true,
			width: 70
		}, {
			header: _('modyandexweb_counter_name'),
			dataIndex: 'name',
			sortable: true,
			width: 200,
		}, {
			header: _('modyandexweb_counter_site'),
			dataIndex: 'site',
			sortable: false,
			width: 200,
		}, {
			header: _('modyandexweb_counter_code_status'),
			dataIndex: 'code_status',
			sortable: false,
			width: 100,
		}, {
			header: _('modyandexweb_counter_permission'),
			dataIndex: 'permission',
			sortable: false,
			width: 100,
		}, {
			header: _('modyandexweb_grid_actions'),
			dataIndex: 'actions',
			renderer: modYandexWeb.utils.renderActions,
			sortable: false,
			width: 100,
			id: 'actions'
		}];
	},

	getTopBar: function (config) {
		return [{
			text: '<i class="icon icon-plus"></i>&nbsp;' + _('modyandexweb_counter_create'),
			handler: this.createItem,
			scope: this
		}];
	},

	onClick: function (e) {
		var elem = e.getTarget();
		if (elem.nodeName == 'BUTTON') {
			var row = this.getSelectionModel().getSelected();
			if (typeof(row) != 'undefined') {
				var action = elem.getAttribute('action');
				if (action == 'showMenu') {
					var ri = this.getStore().find('id', row.id);
					return this._showMenu(this, ri, e);
				}
				else if (typeof this[action] === 'function') {
					this.menu.record = row.data;
					return this[action](this, e);
				}
			}
		}
		return this.processEvent('click', e);
	},

	_getSelectedIds: function () {
		var ids = [];
		var selected = this.getSelectionModel().getSelections();

		for (var i in selected) {
			if (!selected.hasOwnProperty(i)) {
				continue;
			}
			ids.push(selected[i]['id']);
		}

		return ids;
	},

	_doSearch: function (tf, nv, ov) {
		this.getStore().baseParams.query = tf.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	},

	_clearSearch: function (btn, e) {
		this.getStore().baseParams.query = '';
		Ext.getCmp(this.config.id + '-search-field').setValue('');
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}
});
Ext.reg('modyandexweb-grid-metrika', modYandexWeb.grid.Metrika);
