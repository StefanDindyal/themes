(function (window, document) {
	/*global HTMLElement */
	var typeof_string		= typeof "",
		 typeof_undefined	= typeof undefined,
		 typeof_function	= typeof function () {},
		 typeof_object		= typeof {},
		 isTypeOf			= function (item, type) { return typeof item === type; },
		 isString			= function (item) { return isTypeOf(item, typeof_string); },
		 isUndefined		= function (item) { return isTypeOf(item, typeof_undefined); },
		 isFunction			= function (item) { return isTypeOf(item, typeof_function); },
		 isObject			= function (item) { return isTypeOf(item, typeof_object); },
		 isElement				= function (o) {
		    return typeof HTMLElement === "object" ? o instanceof HTMLElement : typeof o === "object" && o.nodeType === 1 && typeof o.nodeName === "string";
		 },
		 BuildM2Store = function (space) {
	
			var selectorEngines = {"jQuery" : "*" },
				item_id					= 0,
				item_id_namespace		= "m2-",
				sc_items				= {},
				namespace				= space || "M2",
				selectorFunctions		= {},
				eventFunctions			= {},
				baseEvents				= {},
				keyID = "109177db7055de2e42958238572b4454",
				cartIdKey,
				cartId,
				values = {},
				itemID = [],
				productIds = [],

				localStorage			= window.localStorage,
				console					= window.console || { msgs: [], log: function (msg) { console.msgs.push(msg); } },

				_VALUE_		= 'value',
				_TEXT_		= 'text',
				_HTML_		= 'html',
				_CLICK_		= 'click',

				currencies = {
					"USD": { code: "USD", symbol: "&#36;", name: "US Dollar" },
					"AUD": { code: "AUD", symbol: "&#36;", name: "Australian Dollar" },
					"BRL": { code: "BRL", symbol: "R&#36;", name: "Brazilian Real" },
					"CAD": { code: "CAD", symbol: "&#36;", name: "Canadian Dollar" },
					"CZK": { code: "CZK", symbol: "&nbsp;&#75;&#269;", name: "Czech Koruna", after: true },
					"DKK": { code: "DKK", symbol: "DKK&nbsp;", name: "Danish Krone" },
					"EUR": { code: "EUR", symbol: "&euro;", name: "Euro" },
					"HKD": { code: "HKD", symbol: "&#36;", name: "Hong Kong Dollar" },
					"HUF": { code: "HUF", symbol: "&#70;&#116;", name: "Hungarian Forint" },
					"ILS": { code: "ILS", symbol: "&#8362;", name: "Israeli New Sheqel" },
					"JPY": { code: "JPY", symbol: "&yen;", name: "Japanese Yen", accuracy: 0 },
					"MXN": { code: "MXN", symbol: "&#36;", name: "Mexican Peso" },
					"NOK": { code: "NOK", symbol: "NOK&nbsp;", name: "Norwegian Krone" },
					"NZD": { code: "NZD", symbol: "&#36;", name: "New Zealand Dollar" },
					"PLN": { code: "PLN", symbol: "PLN&nbsp;", name: "Polish Zloty" },
					"GBP": { code: "GBP", symbol: "&pound;", name: "Pound Sterling" },
					"SGD": { code: "SGD", symbol: "&#36;", name: "Singapore Dollar" },
					"SEK": { code: "SEK", symbol: "SEK&nbsp;", name: "Swedish Krona" },
					"CHF": { code: "CHF", symbol: "CHF&nbsp;", name: "Swiss Franc" },
					"THB": { code: "THB", symbol: "&#3647;", name: "Thai Baht" },
					"BTC": { code: "BTC", symbol: " BTC", name: "Bitcoin", accuracy: 4, after: true	}
				},
				
				settings = {
					storename	: "",
					cart_id		: "",
					currency	: "USD",
					language	: "english-us",
					cartColumns	: ""

				},
				M2 = function (options) {
					if (isFunction(options)) {
						return M2.ready(options);
					}
					if (isObject(options)) {
						return M2.extend(settings, options);
					}
				},
				$engine,
				cartColumnViews;

			M2.extend = function (target, opts) {
				var next;
				if (isUndefined(opts)) {
					opts = target;
					target = M2;
				}
				for (next in opts) {
					if (Object.prototype.hasOwnProperty.call(opts, next)) {
						target[next] = opts[next];
					}
				}
				return target;
			};
						
			M2.extend({
				copy: function (n) {
					var cp = BuildM2Store(n);
					cp.init();
					return cp;
				}
			});

			// add in the core functionality
			M2.extend({
				isReady: false,
				
				add: function (values, opt_quiet) {
					var info		= values || {},
						newItem		= new M2.Item(info),
						addItem 	= true,
						quiet = opt_quiet === true ? opt_quiet : false,
						oldItem;

					if (!quiet) {
					  	addItem = M2.trigger('beforeAdd', [newItem]);
						if (addItem === false) {
							return false;
						}
					}
					
					oldItem = M2.has(newItem);
					if (oldItem) {
						//oldItem.increment(newItem.quantity());
						newItem = oldItem;
					} else {
						sc_items[newItem.id()] = newItem;
					}
					M2.update();
					if (!quiet) {
						M2.trigger('afterAdd', [newItem, isUndefined(oldItem)]);
					}
					return newItem;
				},
				// iteration function
				each: function (array, callback) {
					var next, x = 0, result, cb, items;
					if (isFunction(array)) {
						cb = array;
						items = sc_items;
					} else if (isFunction(callback)) {
						cb = callback;
						items = array;
					} else {
						return;
					}
					for (next in items) {
						if (Object.prototype.hasOwnProperty.call(items, next)) {
							result = cb.call(M2, items[next], x, next);
							if (result === false) {
								return;
							}
							x += 1;
						}
					}
				},

				find: function (id) {
					var items = [];
					if (isObject(sc_items[id])) {
						return sc_items[id];
					}
					if (isObject(id)) {
						M2.each(function (item) {
							var match = true;
							M2.each(id, function (val, x, attr) {

								if (isString(val)) {
									// less than or equal to
									if (val.match(/<=.*/)) {
										val = parseFloat(val.replace('<=', ''));
										if (!(item.get(attr) && parseFloat(item.get(attr)) <= val)) {
											match = false;
										}
									// less than
									} else if (val.match(/</)) {
										val = parseFloat(val.replace('<', ''));
										if (!(item.get(attr) && parseFloat(item.get(attr)) < val)) {
											match = false;
										}
									// greater than or equal to
									} else if (val.match(/>=/)) {
										val = parseFloat(val.replace('>=', ''));
										if (!(item.get(attr) && parseFloat(item.get(attr)) >= val)) {
											match = false;
										}

									// greater than
									} else if (val.match(/>/)) {
										val = parseFloat(val.replace('>', ''));
										if (!(item.get(attr) && parseFloat(item.get(attr)) > val)) {
											match = false;
										}
									// equal to
									} else if (!(item.get(attr) && item.get(attr) === val)) {
										match = false;
									}
								// equal to non string
								} else if (!(item.get(attr) && item.get(attr) === val)) {
									match = false;
								}
								return match;
							});
							// add the item if it matches
							if (match) {
								items.push(item);
							}
						});
						return items;
					}
					if (isUndefined(id)) {
						M2.each(function (item) {
							items.push(item);
						});
						return items;
					}
					return items;
				},
				// return all items
				items: function () {
					return this.find();
				},
				// check to see if item is in the cart already
				has: function (item) {
					var match = false;

					M2.each(function (testItem) {
						if (testItem.equals(item)) {
							match = testItem;
						}
					});
					return match;
				},
				// empty the cart
				empty: function () {
					var newItems = {};
					M2.each(function (item) {
						if (item.remove(true) === false) {
							newItems[item.id()] = item
						}
					});
					sc_items = newItems;
					M2.update();
				},
				quantity: function () {
					var quantity = 0;
					M2.each(function (item) {
						quantity += item.quantity();
					});
					return quantity;
				},
				total: function () {
					var total = 0;
					M2.each(function (item) {
						total += item.total();
					});
					return total;
				},
				update: function () {
					M2.save();
					M2.trigger("update");
				},

				init: function () {
					M2.load();
					M2.update();
					M2.ready();
					
					if (!cartId) {
				    M2.create();
				  } else {
				    M2.show();
				  }
				},
				$: function (selector) {
					return new M2.ELEMENT(selector);
				},
				$create: function (tag) {
					return M2.$(document.createElement(tag));
				},
				setupViewTool: function () {
					var members, member, context = window, engine;

					for (engine in selectorEngines) {
						if (Object.prototype.hasOwnProperty.call(selectorEngines, engine) && window[engine]) {
							members = selectorEngines[engine].replace("*", engine).split(".");
							member = members.shift();
							if (member) {
								context = context[member];
							}
							if (typeof context === "function") {
								$engine = context;
								M2.extend(M2.ELEMENT._, selectorFunctions[engine]);
								return;
							}
						}
					}
				},
				// return a list of id's in the cart
				ids: function () {
					var ids = [];
					M2.each(function (item) {
						ids.push(item.id());
					});
					return ids;
				},
				// storage
				save: function () {
					M2.trigger('beforeSave');
					var items = {};					
					// save all the items
					M2.each(function (item) {
						items[item.id()] = M2.extend(item.fields(), item.options());
					});
					
					localStorage.setItem(namespace + "_items", JSON.stringify(items));
										
					M2.trigger('afterSave');
				},

				load: function () {
					sc_items = {};
					cartIdKey = settings.storename + "-cart-id";
					cartId = localStorage.getItem(cartIdKey);
					console.log(localStorage);
					var items = localStorage.getItem(namespace + "_items");
					
					if (!cartId) { return; }
					if (!items) { return; }
					
					try {
						M2.each(JSON.parse(items), function (item) {
							M2.add(item, true);
						});
					} catch (e){
						M2.error( "Error Loading data: " + e );
					}
					
					M2.trigger('load');
				},
				
				create: function () {									
					cartIdKey = settings.storename + "-cart-id";
										
				  	jQuery.ajax({ 
				  	  type: "GET", 
				  	  dataType: "jsonp", 
				  	  cache: true, 
				  	  url: "http://api.myplaydirect.com/"+settings.storename+"/api/v1/cart/create.json?key="+keyID,
				  	  	success: function (response) {
				  	  		var ID = response.results[0].cart_id;
				  	  	   localStorage.setItem(cartIdKey, ID);
				  	  	}
				  	});
				},
				
				show: function () {
				  if (cartId) {
				    jQuery.ajax({ 
				  	  	type: "GET", 
				  	  	dataType: "jsonp", 
				  	  	cache: true, 
				  	  	url: "http://api.myplaydirect.com/"+settings.storename+"/api/v1/cart/show.json?key="+keyID,
				      success: function (response) {
						   for (var i = 0; i < response.length; i += 1) {
						   	var product = response.results[0].id;
						   	M2.update();
						   	console.log(product);
						   }
						}
				    });
				  }
				},
				
				addProduct: function (product_id) {
				  if (cartId) {
				  	jQuery.ajax({
				    	type: "GET", 
				  	  	dataType: "jsonp", 
				  	  	cache: true,
				  	  	url: "http://api.myplaydirect.com/"+settings.storename+"/api/v1/cart/"+cartId+"/add/"+product_id+".json?key="+keyID,
				  	  	success: function (response) {
				  	  		M2.update();
				  	  	}
				  	});
				  }
				},
				
				removeProduct: function (product_id) {
				  if (cartId) {
				  	 jQuery.ajax({
				    	type: "GET", 
				  	  	dataType: "jsonp", 
				  	  	cache: true,
				  	  	url: "http://api.myplaydirect.com/"+settings.storename+"/api/v1/cart/"+cartId+"/remove/"+product_id+".json?key="+keyID,
				  	  	success: function (response) {
				  	  		M2.update();
				  	  	}
				  	});
				  }
				},
				
				emptyCart: function () {
				  if (cartId) {
				    jQuery.ajax({
				    	type: "GET", 
				  	  	dataType: "jsonp", 
				  	  	cache: true, 
				  	  	url: "http://api.myplaydirect.com/"+settings.storename+"/api/v1/cart/"+cartId+"/empty.json?key="+keyID,
				      success: function (response) {
				        M2.empty();
				        M2.update();
				      }
				    });
				  }
				},
				ready: function (fn) {
					if (isFunction(fn)) {
						if (M2.isReady) {
							fn.call(M2);
						} else {
							M2.bind('ready', fn);
						}
					} else if (isUndefined(fn) && !M2.isReady) {
						M2.trigger('ready');
						M2.isReady = true;
					}

				},
				error: function (message) {
					var msg = "";
					if (isString(message)) {
						msg = message;
					} else if (isObject(message) && isString(message.message)) {
						msg = message.message;
					}
					try { console.log("M2(js) Error: " + msg); } catch (e) {}
					M2.trigger('error', [message]);
				}
			});

			/*******************************************************************
			 *	CART VIEWS
			 *******************************************************************/

			// built in cart views for item cells
			cartColumnViews = {
				attr: function (item, column) {
					return item.get(column.attr) || "";
				},
				currency: function (item, column) {
					return M2.toCurrency(item.get(column.attr) || 0);
				},
				link: function (item, column) {
					return "<a href='" + item.get(column.attr) + "'>" + column.text + "</a>";
				},
				image: function (item, column) {
					return "<img src='" + item.options()['image'] + "' style='max-width:90px;'/>";
				},
				remove: function (item, column) {
					return "<span class='btn'><a href='javascript:;' class='" + namespace + "_remove'>" + (column.text || "X") + "</a></span>";
				}
			};

			// cart column wrapper class and functions
			function cartColumn(opts) {
				var options = opts || {};
				return M2.extend({
					attr			: "",
					label			: "",
					view			: "attr",
					text			: "",
					className		: "",
					hide			: false
				}, options);
			}

			function cartCellView(item, column) {
				var viewFunc = isFunction(column.view) ? column.view : isString(column.view) && isFunction(cartColumnViews[column.view]) ? cartColumnViews[column.view] : cartColumnViews.attr;

				return viewFunc.call(M2, item, column);
			}

			M2.extend({
				
				renderCart: function(productIds){
					var cartHtml = '';
					
					  cartHtml += '<div class="m2-mini-cart">';
					    cartHtml += '<div class="m2-cart-header">';
					      cartHtml += '<span class="m2-cart-count '+namespace+'_quantity"></span>';
					      cartHtml += '<span class="btn"><a href="javascript:;" class="'+namespace+'_empty btn">Empty Cart</a></span>';
					    cartHtml += '</div>';
					    cartHtml += '<div class="'+namespace+'_items"></div>';
					    cartHtml += '<div class="m2-total-container">SubTotal: <span class="'+namespace+'_total"></span></div>';
						cartHtml += '<div class="m2-checkout-container"><a href="#" class="'+namespace+'_checkout">checkout</a></div>';
					  cartHtml += '</div>';
					     	  
					  jQuery('html').find('#m2-cart').append(cartHtml);
				},
				// write out cart
				writeCart: function (selector) {
					var DIV = 'div',
						 UL = 'ul',
						 LI = 'li',
						 cart_container = M2.$create(DIV).addClass(namespace+'_items_inner'),
						 container = M2.$(selector), column, klass, label, x, xlen;
						 
					container.html(' ').append(cart_container);
					
					M2.each(function (item, y) {
						M2.createCartRow(item, y, UL, LI, cart_container).attr('item-id', Object.keys(item.options())[0]);
					});

					return cart_container;
				},

				createCartRow: function (item, y, UL, LI, container) {
					var row = M2.$create(UL).addClass('productRow row-' + y + " " + (y % 2 ? "even" : "odd")).attr('id', "product_" + item.id()),
						i, ilen, column, klass, content, cell;
					
					container.append(row);

					for (i = 0, ilen = settings.cartColumns.length; i < ilen; i += 1) {
						column	= cartColumn(settings.cartColumns[i]);
						klass	= "item-" + (column.attr || (isString(column.view) ? column.view : column.label || column.text || "cell")) + " " + column.className;
						content = cartCellView(item, column);
						cell	= M2.$create(LI).addClass(klass).html(content);

						row.append(cell);
					}
					return row;
				}

			});
			
			/*******************************************************************
			 *	CART ITEM CLASS MANAGEMENT
			 *******************************************************************/

			M2.Item = function (info) {
				var _data = {},
					me = this;

				if (isObject(info)) {
					M2.extend(_data, info);
				}
				item_id += 1;
				_data.id = _data.id || item_id_namespace + item_id;
				while (!isUndefined(sc_items[_data.id])) {
					item_id += 1;
					_data.id = item_id_namespace + item_id;
				}

				function checkQuantityAndPrice() {
					if (isString(_data.price)) {
						_data.price = parseFloat(_data.price.replace(M2.currency().decimal, ".").replace(/[^0-9\.]+/ig, ""));

					}
					if (isNaN(_data.price)) { _data.price = 0; }
					if (_data.price < 0) { _data.price = 0; }

					if (isString(_data.quantity)) {
						_data.quantity = parseInt(_data.quantity.replace(M2.currency().delimiter, ""), 10);
					}
					if (isNaN(_data.quantity)) { _data.quantity = 1; }
					if (_data.quantity <= 0) { me.remove(); }
				}

				me.get = function (name, skipPrototypes) {
					var usePrototypes = !skipPrototypes;
					if (isUndefined(name)) {
						return name;
					}
					return isFunction(_data[name])	? _data[name].call(me) :
							!isUndefined(_data[name]) ? _data[name] :

							isFunction(me[name]) && usePrototypes		? me[name].call(me) :
							!isUndefined(me[name]) && usePrototypes	? me[name] :
							_data[name];
				};
				me.set = function (name, value) {
					if (!isUndefined(name)) {
						_data[name.toLowerCase()] = value;
						if (name.toLowerCase() === 'price' || name.toLowerCase() === 'quantity') {
							checkQuantityAndPrice();
						}
					}
					return me;
				};
				me.equals = function (item) {
					for( var label in _data ){
						if (Object.prototype.hasOwnProperty.call(_data, label)) {
							if (label !== 'quantity' && label !== 'id') {
								if (item.get(label) !== _data[label]) {
									return false;
								}
							}
						}
					}
					return true;
				};
				me.options = function () {
					var data = {};
					M2.each(_data,function (val, x, label) {
						var add = true;
						M2.each(me.reservedFields(), function (field) {
							if (field === label) {
								add = false;
							}
							return add;
						});

						if (add) {
							data[label] = me.get(label);
						}
					});
					return data;
				};
				checkQuantityAndPrice();
			};

			M2.Item._ = M2.Item.prototype = {
				remove: function (skipUpdate) {
					var removeItemBool = M2.trigger("beforeRemove", [sc_items[this.id()]]);
					if (removeItemBool === false ) {
						return false;
					}
					delete sc_items[this.id()];
					if (!skipUpdate) { 
						M2.update();
					}
					return null;
				},

				// special fields for items
				reservedFields: function () {
					return ['quantity', 'id', 'data-id', 'product_number', 'price', 'name'];
				},

				// return values for all reserved fields if they exist
				fields: function () {
					var data = {},
						me = this;
					M2.each(me.reservedFields(), function (field) {
						if (me.get(field)) {
							data[field] = me.get(field);
						}
					});
					return data;
				},
				quantity: function (val) {
					return isUndefined(val) ? parseInt(this.get("quantity", true) || 1, 10) : this.set("quantity", val);
				},
				price: function (val) {
					return isUndefined(val) ?
							parseFloat((this.get("price",true).toString()).replace(M2.currency().symbol,"").replace(M2.currency().delimiter,"") || 1) :
							this.set("price", parseFloat((val).toString().replace(M2.currency().symbol,"").replace(M2.currency().delimiter,"")));
				},
				id: function () {
					return this.get('id',false);
				},
				total:function () {
					return this.quantity()*this.price();
				}

			};

			/*******************************************************************
			 *	CHECKOUT MANAGEMENT
			 *******************************************************************/

			M2.extend({				
				checkout: function () {
					var params = {
				      cart_id: cartId,
				      //current_country: 'US'
				    };
				    
				    if (M2.items().length === 0) {
						return M2.error("There are no items in your cart.");
					}
					
					window.open(document.location.protocol + '//www.myplaydirect.com/'+ settings.storename +'/cart' + "?" + jQuery.param(params));
					
					return true;
				}

			});
			

			/*******************************************************************
			 *	EVENT MANAGEMENT
			 *******************************************************************/
			eventFunctions = {
				bind: function (name, callback) {
					if (!isFunction(callback)) {
						return this;
					}

					if (!this._events) {
						this._events = {};
					}
					
					var eventNameList = name.split(/ +/);
					M2.each( eventNameList , function( eventName ){
						if (this._events[eventName] === true) {
							callback.apply(this);
						} else if (!isUndefined(this._events[eventName])) {
							this._events[eventName].push(callback);
						} else {
							this._events[eventName] = [callback];
						}
					});
					return this;
				},
				
				// trigger event
				trigger: function (name, options) {
					var returnval = true,
						x,
						xlen;

					if (!this._events) {
						this._events = {};
					}
					if (!isUndefined(this._events[name]) && isFunction(this._events[name][0])) {
						for (x = 0, xlen = this._events[name].length; x < xlen; x += 1) {
							returnval = this._events[name][x].apply(this, (options || []));
						}
					}
					if (returnval === false) {
						return false;
					}
					return true;
				}

			};
			eventFunctions.on = eventFunctions.bind;
			M2.extend(eventFunctions);
			M2.extend(M2.Item._, eventFunctions);

			baseEvents = {
				  beforeAdd				: null
				, afterAdd				: null
				, load					: null
				, beforeSave			: null
				, afterSave				: null
				, update					: null
				, ready					: null
				, checkoutSuccess		: null
				, checkoutFail			: null
				, beforeCheckout		: null
				, beforeRemove			: null
			};
			
			M2(baseEvents);

 			M2.each(baseEvents, function (val, x, name) {
				M2.bind(name, function () {
					if (isFunction(settings[name])) {
						settings[name].apply(this, arguments);
					}
				});
			});

			/*******************************************************************
			 *	FORMATTING FUNCTIONS
			 *******************************************************************/
			M2.extend({
				toCurrency: function (number,opts) {
					var num = parseFloat(number),
						opt_input = opts || {},
						_opts = M2.extend(M2.extend({
							  symbol:		"$"
							, decimal:		"."
							, delimiter:	","
							, accuracy:		2
							, after: false
						}, M2.currency()), opt_input),

						numParts = num.toFixed(_opts.accuracy).split("."),
						dec = numParts[1],
						ints = numParts[0];
			
					ints = M2.chunk(ints.reverse(), 3).join(_opts.delimiter.reverse()).reverse();

					return	(!_opts.after ? _opts.symbol : "") +
							ints +
							(dec ? _opts.decimal + dec : "") +
							(_opts.after ? _opts.symbol : "");
	
				},
				// break a string in blocks of size n
				chunk: function (str, n) {
					if (typeof n==='undefined') {
						n=2;
					}
					var result = str.match(new RegExp('.{1,' + n + '}','g'));
					return result || [];
				}

			});
			// reverse string function
			String.prototype.reverse = function () {
				return this.split("").reverse().join("");
			};

			// currency functions
			M2.extend({
				currency: function (currency) {
					if (isString(currency) && !isUndefined(currencies[currency])) {
						settings.currency = currency;
					} else if (isObject(currency)) {
						currencies[currency.code] = currency;
						settings.currency = currency.code;
					} else {
						return currencies[settings.currency];
					}
				}
			});

			/*******************************************************************
			 *	VIEW MANAGEMENT
			 *******************************************************************/

			M2.extend({
				bindOutlets: function (outlets) {
					M2.each(outlets, function (callback, x, selector) {
						M2.bind('update', function () {
							M2.setOutlet("." + namespace + "_" + selector, callback);
						});
					});
				},
				setOutlet: function (selector, func) {
					var val = func.call(M2, selector);
					if (isObject(val) && val.el) {
						M2.$(selector).html(' ').append(val);
					} else if (!isUndefined(val)) {
						M2.$(selector).html(val);
					}
				},
				bindInputs: function (inputs) {
					M2.each(inputs, function (info) {
						M2.setInput("." + namespace + "_" + info.selector, info.event, info.callback);
					});
				},
				setInput: function (selector, event, func) {
					M2.$(selector).live(event, func);
				}
			});		

			M2.ELEMENT = function (selector) {
				this.create(selector);
				this.selector = selector || null;
			};

			M2.extend(selectorFunctions, {
				"jQuery": {
					passthrough: function (action, val) {
						if (isUndefined(val)) {
							return this.el[action]();
						}
						this.el[action](val);
						return this;
					},
					text: function (text) { return this.passthrough(_TEXT_, text); },
					html: function (html) { return this.passthrough(_HTML_, html); },
					val: function (val) { return this.passthrough("val", val); },
					append: function (item) {
						var target = item.el || item;
						this.el.append(target);
						return this;
					},
					attr: function (attr, val) {
						if (isUndefined(val)) {
							return this.el.attr(attr);
						}
						this.el.attr(attr, val);
						return this;
					},
					css: function (selector) { return M2.$(this.el.css(_TEXT_)); },
					remove: function () { this.el.remove(); return this; },
					addClass: function (klass) { this.el.addClass(klass); return this; },
					removeClass: function (klass) { this.el.removeClass(klass); return this; },
					each: function (callback) { return this.passthrough('each', callback); },
					click: function (callback) { return this.passthrough(_CLICK_, callback); },
					live: function (event, callback) { $engine(document).delegate(this.selector, event, callback); return this; },
					parent: function () { return M2.$(this.el.parent()); },
					parents: function () { return M2.$(this.el.parents()); },
					find: function (selector) { return M2.$(this.el.find(selector)); },
					closest: function (selector) { return M2.$(this.el.closest(selector)); },
					tag: function () { return this.el[0].tagName; },
					descendants: function () { return M2.$(this.el.find("*")); },
					create: function (selector) { this.el = $engine(selector); }
				}
			});
			M2.ELEMENT._ = M2.ELEMENT.prototype;

			M2.ready(M2.setupViewTool);

			M2.ready(function () {
				M2.renderCart(productIds);
				M2.bindOutlets({
					total: function () { return M2.toCurrency(M2.total()); },
					quantity: function () { return M2.quantity(); },
					items: function (selector) { M2.writeCart(selector); }
				});
				M2.bindInputs([
					{	  selector: 'checkout'
						, event: 'click'
						, callback: function () {
							M2.checkout();
						}
					}
					, {  selector: 'empty'
						, event: 'click'
						, callback: function () {
							M2.empty();
							M2.emptyCart();
						}
					}
					, {  selector: 'remove'
						, event: 'click'
						, callback: function () {
							M2.find(M2.$(this).closest('.productRow').attr('id').split("_")[1]).remove();
							M2.removeProduct(productIds);
							M2.update();
						}
					}
					, { selector: 'product-container .product_add'
						, event: 'click'
						, callback: function () {
							var $button = M2.$(this),
								fields = {};
							
							$button.closest("." + namespace + "_product-container").each(function (x,item) {
								var $item = M2.$(item);
								var productId = $item.closest("." + namespace + "_product-container").attr('item-id');
								itemID.push({productId:productId});
								
								var Ids = {};
								
								M2.each(itemID, function(item){
									Ids = item['productId'];
								});
								
								productIds = Ids;
							});
							
							$button.closest("." + namespace + "_product-container").descendants().each(function (x,item) {
								var $item = M2.$(item);
								// check to see if the class matches the item_[fieldname] pattern && !$item.attr('class').match(/product_add/)
								if ($item.attr("class") && $item.attr("class").match(/product_.+/g) && !$item.attr('class').match(/product_add/) ) {
									console.log($item.attr('class').split(' '));
									
									M2.each($item.attr('class').split(' '), function (item) {
										var attr, val, type;
										// get the value or text depending on the tagName klass.match(/product_.+/) product_[0-9]
										if (item.match(/product_.+/g)) {
											attr = item.split("_")[1];
											val = "";
											
											val = $item.text();
																					
											M2.addProduct(productIds);
											console.log(productIds);
																																	
											if (val !== null && val !== "") {
												fields[attr.toLowerCase()] = fields[attr.toLowerCase()] ? fields[attr.toLowerCase()] + ", " +  val : val;
											}
										}
									});
								}
							});
							M2.add(fields);
						}
					}
				]);
			});

			/*******************************************************************
			 *	DOM READY
			 *******************************************************************/
			// Cleanup functions for the document ready method
			// used from jQuery
			/*global DOMContentLoaded */
			if (document.addEventListener) {
				window.DOMContentLoaded = function () {
					document.removeEventListener("DOMContentLoaded", DOMContentLoaded, false);
					M2.init();
				};

			} else if (document.attachEvent) {
				window.DOMContentLoaded = function () {
					// Make sure body exists, at least, in case IE gets a little overzealous (ticket #5443).
					if (document.readyState === "complete") {
						document.detachEvent("onreadystatechange", DOMContentLoaded);
						M2.init();
					}
				};
			}
			// The DOM ready check for Internet Explorer
			// used from jQuery
			function doScrollCheck() {
				if (M2.isReady) {
					return;
				}

				try {
					document.documentElement.doScroll("left");
				} catch (e) {
					setTimeout(doScrollCheck, 1);
					return;
				}
				M2.init();
			}
			
			// bind ready event used from jquery
			function sc_BindReady () {
				// Catch cases where $(document).ready() is called after the
				// browser event has already occurred.
				if (document.readyState === "complete") {
					// Handle it asynchronously to allow scripts the opportunity to delay ready
					return setTimeout(M2.init, 1);
				}
				if (document.addEventListener) {
					document.addEventListener("DOMContentLoaded", DOMContentLoaded, false);
					// A fallback to window.onload, that will always work
					window.addEventListener("load", M2.init, false);
				// If IE event model is used
				} else if (document.attachEvent) {
					document.attachEvent("onreadystatechange", DOMContentLoaded);
					// A fallback to window.onload, that will always work
					window.attachEvent("onload", M2.init);
					// If IE and not a frame
					// continually check to see if the document is ready
					var toplevel = false;
					try {
						toplevel = window.frameElement === null;
					} catch (e) {}
					if (document.documentElement.doScroll && toplevel) {
						doScrollCheck();
					}
				}
			}
			sc_BindReady();

			return M2;
		};

	M2Store = BuildM2Store();
	
}(window, document));


/************ JSON *************/
var JSON;JSON||(JSON={});
(function () {function k(a) {return a<10?"0"+a:a}function o(a) {p.lastIndex=0;return p.test(a)?'"'+a.replace(p,function (a) {var c=r[a];return typeof c==="string"?c:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+a+'"'}function l(a,j) {var c,d,h,m,g=e,f,b=j[a];b&&typeof b==="object"&&typeof b.toJSON==="function"&&(b=b.toJSON(a));typeof i==="function"&&(b=i.call(j,a,b));switch(typeof b) {case "string":return o(b);case "number":return isFinite(b)?String(b):"null";case "boolean":case "null":return String(b);case "object":if (!b)return"null";
e += n;f=[];if (Object.prototype.toString.apply(b)==="[object Array]") {m=b.length;for (c=0;c<m;c += 1)f[c]=l(c,b)||"null";h=f.length===0?"[]":e?"[\n"+e+f.join(",\n"+e)+"\n"+g+"]":"["+f.join(",")+"]";e=g;return h}if (i&&typeof i==="object") {m=i.length;for (c=0;c<m;c += 1)typeof i[c]==="string"&&(d=i[c],(h=l(d,b))&&f.push(o(d)+(e?": ":":")+h))}else for (d in b)Object.prototype.hasOwnProperty.call(b,d)&&(h=l(d,b))&&f.push(o(d)+(e?": ":":")+h);h=f.length===0?"{}":e?"{\n"+e+f.join(",\n"+e)+"\n"+g+"}":"{"+f.join(",")+
"}";e=g;return h}}if (typeof Date.prototype.toJSON!=="function")Date.prototype.toJSON=function () {return isFinite(this.valueOf())?this.getUTCFullYear()+"-"+k(this.getUTCMonth()+1)+"-"+k(this.getUTCDate())+"T"+k(this.getUTCHours())+":"+k(this.getUTCMinutes())+":"+k(this.getUTCSeconds())+"Z":null},String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function () {return this.valueOf()};var q=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
p=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,e,n,r={"\u0008":"\\b","\t":"\\t","\n":"\\n","\u000c":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},i;if (typeof JSON.stringify!=="function")JSON.stringify=function (a,j,c) {var d;n=e="";if (typeof c==="number")for (d=0;d<c;d += 1)n += " ";else typeof c==="string"&&(n=c);if ((i=j)&&typeof j!=="function"&&(typeof j!=="object"||typeof j.length!=="number"))throw Error("JSON.stringify");return l("",
{"":a})};if (typeof JSON.parse!=="function")JSON.parse=function (a,e) {function c(a,d) {var g,f,b=a[d];if (b&&typeof b==="object")for (g in b)Object.prototype.hasOwnProperty.call(b,g)&&(f=c(b,g),f!==void 0?b[g]=f:delete b[g]);return e.call(a,d,b)}var d,a=String(a);q.lastIndex=0;q.test(a)&&(a=a.replace(q,function (a) {return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)}));if (/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"")))return d=eval("("+a+")"),typeof e==="function"?c({"":d},""):d;throw new SyntaxError("JSON.parse");}})();


/************ HTML5 Local Storage Support *************/
(function () {if (!this.localStorage)if (this.globalStorage)try {this.localStorage=this.globalStorage}catch(e) {}else{var a=document.createElement("div");a.style.display="none";document.getElementsByTagName("head")[0].appendChild(a);if (a.addBehavior) {a.addBehavior("#default#userdata");var d=this.localStorage={length:0,setItem:function (b,d) {a.load("localStorage");b=c(b);a.getAttribute(b)||this.length++;a.setAttribute(b,d);a.save("localStorage")},getItem:function (b) {a.load("localStorage");b=c(b);return a.getAttribute(b)},
removeItem:function (b) {a.load("localStorage");b=c(b);a.removeAttribute(b);a.save("localStorage");this.length=0},clear:function () {a.load("localStorage");for (var b=0;attr=a.XMLDocument.documentElement.attributes[b++];)a.removeAttribute(attr.name);a.save("localStorage");this.length=0},key:function (b) {a.load("localStorage");return a.XMLDocument.documentElement.attributes[b]}},c=function (a) {return a.replace(/[^-._0-9A-Za-z\xb7\xc0-\xd6\xd8-\xf6\xf8-\u037d\u37f-\u1fff\u200c-\u200d\u203f\u2040\u2070-\u218f]/g,
"-")};a.load("localStorage");d.length=a.XMLDocument.documentElement.attributes.length}}})();