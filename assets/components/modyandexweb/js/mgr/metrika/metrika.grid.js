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
		paging: false,
		remoteSort: true,
		autoHeight: true,
	});
	modYandexWeb.grid.Metrika.superclass.constructor.call(this, config);
};
Ext.extend(modYandexWeb.grid.Metrika, MODx.grid.Grid, {
	windows: {},

	getMenu: function (grid, rowIndex) {
		var row = grid.getStore().getAt(rowIndex);
		var menu = modYandexWeb.utils.getMenu(row.data['actions'], this);

		this.addContextMenuItem(menu);
	},

	createCounter: function (btn, e) {
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

	checkCounter: function (act, btn, e) {
		if (!this.menu.record)
			return false;
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/metrika/check',
                counter_id: this.menu.record.id
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

    removeCounter: function (act, btn, e) {
        if (!this.menu.record)
            return false;
        MODx.msg.confirm({
            title: _('modyandexweb_counter_remove'),
            text: _('modyandexweb_counter_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/metrika/remove',
                counter_id: this.menu.record.id,
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
			width: 100,
		}, {
			header: _('modyandexweb_counter_site'),
			dataIndex: 'site',
			sortable: false,
			width: 100,
		}, {
			header: _('modyandexweb_counter_code_status'),
			dataIndex: 'code_status',
			sortable: false,
			width: 100,
            renderer:function(v) {
                return _(v);
            },
		}, {
			header: _('modyandexweb_counter_permission'),
			dataIndex: 'permission',
			sortable: false,
			width: 100,
            renderer:function(v) {
                return _(v);
            },
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
			handler: this.createCounter,
			scope: this
		},'->',{
            text: '<i class="icon icon-refresh"></i>',
            handler: function(btn, e){
                this.refresh();
            },
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

modYandexWeb.window.CreateCounter = function(config) {
    config = config || {};
    this.ident = config.ident || 'metrika-create-' + Ext.id();
    Ext.applyIf(config, {
        title: _('modyandexweb_counter_create')
        , id: this.ident
        , autoHeight: true
        , labelAlign: 'left'
        , labelWidth: 180
        , url: modYandexWeb.config.connector_url
        , action: 'mgr/metrika/create'
        , fields: [
            {xtype: 'textfield', name: 'name', fieldLabel: _('modyandexweb_counter_name')}
        ]
        , keys: [{
            key: Ext.EventObject.ENTER,
            shift: true,
            fn: function() {
                this.submit()
            }, scope: this
        }]
    });
    modYandexWeb.window.CreateCounter.superclass.constructor.call(this, config);
};
Ext.extend(modYandexWeb.window.CreateCounter, MODx.Window);
Ext.reg('modyandexweb-metrika-window-create', modYandexWeb.window.CreateCounter);