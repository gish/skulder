;require(["lib/backbone", "lib/jquery", "lib/underscore", "lib/bootstrap"], function(Backbone, $, _)
{
	var App = function($, doc, win)
	{
		"use strict";

		// Modell för skuld
		var Debt = Backbone.Model.extend({
			defaults : function()
			{
				return {
					name      : "",
					date        : 0,
					description : "",
					sum         : 0,
					share       : 0,
					deleted     : false
				};
			},

			initialize : function()
			{
				_.each(this.defaults, function(num, key) {
					if (!this.get(key)) this.set({ key : this.defaults[key] });
				});

				this.on('error', function(model, error)
				{
					var message = new MessageView({
						model : new Message({
							'type' : 'error',
							'content' : error
						}),
						el : $("#message-container")
					});
					message.render();
				});
			},

			urlRoot : function()
			{
				return '/debt/';
			},

			validate : function()
			{
				var errorMessage = "Du har inte fyllt i ";
				var errors = [];
				if (this.get('name') == "")
				{
					errors.push("namn");
				}
				if (!this.get('share'))
				{
					errors.push("andel")
				}
				if (!this.get('sum'))
				{
					errors.push("summa");
				}
				if (this.get('description') == "")
				{
					errors.push("beskrivning");
				}
				if (errors.length > 0)
				{
					if (errors.length == 1)
					{
						return errorMessage + errors[0];
					}
					else
					{
						var s = " eller ";
						var em = "";
						for (var i = errors.length - 1, e; (e = errors[i]) && i > 0;i--)
						{
							em = s + e + em;
							s = ", ";
						}
						em = e + em;
						return errorMessage + em;
					}
				}
			}
		});

		// Vy för att visa skuld
		var DebtView = Backbone.View.extend({
			template  : _.template($("#debt-template").html()),
			el : '<tr>',
			events : {
				'click .remove' : 'remove',
				'click .restore' : 'restore'
			},
			initialize : function()
			{
				this.model.on('change', this.render, this);
			},
			render : function()
			{
				var html;
				html = this.template({debt : this.model});
				if ("1" == this.model.get('deleted'))
				{
					this.$el.addClass('deleted');
				}
				else
				{
					this.$el.removeClass('deleted');
				}
				this.$el.html(html);
				return this;
			},
			remove : function(evt)
			{
				var self = this;
				this.model.set('deleted', '1');
				this.model.save({wait: true});

				var message = new MessageView({
					model : new Message({
						'type' : 'success',
						'content' : 'Skulden raderad!'
					}),
					el : $("#message-container")
				});
				message.render();

				evt.preventDefault();
			},
			restore : function(evt)
			{
				var self = this;
				this.model.set('deleted', '0');
				this.model.save({wait: true});

				var message = new MessageView({
					model : new Message({
						'type' : 'success',
						'content' : 'Skulden återställd!'
					}),
					el : $("#message-container")
				});
				message.render();

				evt.preventDefault();
			}
		});

		// Samling av skulder
		var Debts = Backbone.Collection.extend({
			model : Debt,
			offset : 0,
			amount : 10,
			url : function()
			{
				return '/debts/';
			},
			load : function(cb)
			{
				var self = this;
				this.fetch({
					data : {
						offset : self.offset,
						amount : self.amount
					},
					success : function(c, r)
					{
						self.offset += self.amount;
						cb(c, r);
					}
				});
			}
		});

		// Modell för att representera ett meddelande
		var Message = Backbone.Model.extend({
			defaults : function()
			{
				return {
					'type' : '',
					'content' : ''
				};
			}
		});

		// Vy för att skriva ut meddelanden
		var MessageView = Backbone.View.extend({
			Model : Message,
			template  : _.template($("#message-template").html()),
			render : function()
			{
				var html;
				html = this.template({message : this.model});
				this.$el.empty();
				this.$el.append(html);
				return this;
			}
		});

		// Modell för att representera vem som är skyldig hur mycket
		var Own = Backbone.Model.extend({
			defaults : function()
			{
				return {
					name : 'Namn',
					sum  : '0'
				};
			},
			urlRoot : function()
			{
				return '/own/';
			}
		});

		// Vy för att skriv ut vem som är skyldig pengar
		var OwnView = Backbone.View.extend({
			Model : Own,
			templates : [
				_.template($("#own-template").html()),
				_.template($("#own-template-loading").html())
			],
			el: $("#status-message"),
			initialize : function()
			{
				this.model.on('change', this.render, this);
			},
			render : function()
			{
				var html;
				html = this.templates[0]({
					name : this.model.get('name'),
					sum  : this.model.get('sum')
				});
				this.$el.html(html);
				return this;
			},
			renderLoading : function()
			{
				var html;
				html = this.templates[1]();
				this.$el.html(html);
				return this;
			}
		});

		var App = Backbone.Model.extend({
			initialize : function()
			{
				var self = this;
				this.debts = new Debts();

				this.own = new Own();
				this.ownView = new OwnView({
					model : this.own
				});

				this.debts.on('change', function()
				{
					self.ownView.renderLoading();
					setTimeout(function()
					{
						self.own.fetch();
					}, 1000);
				});
				this.own.fetch();

				// Ladda fler skulder
				$("#load-debts").click(function()
				{
					self.loadDebts();
				});
				this.loadDebts();

				$("#add-form").submit(function(evt)
				{
					evt.preventDefault();
					self.addDebt();
				});
			},

			loadDebts : function()
			{
				var self = this;
				this.debts.load(function(c, r)
				{

					self.renderDebts(c, r);
				});
			},
			renderDebts : function(collection, response)
			{
				var $el = $('#table-container tbody');
				_.each(this.debts.toArray(), function(debt)
				{
					var view;
					view = new DebtView({
						model : debt,
					});
					$el.append(view.render().el);
				});

				if (!response || response.length < this.debts.amount)
				{
					$("#load-debts").hide();
				}
			},
			addDebt : function()
			{
				var self = this;
				var debt = new Debt({
					name : $('[name="name"]').val(),
					description : $('[name="description"]').val(),
					share : parseInt($('[name="share"]').val(),10)/100,
					sum : parseInt($('[name="sum"]').val(), 10)
				});
				var message = new MessageView({
					el : $("#message-container")
				});
				var debtView = new DebtView({
					model : debt,
				});
				debt.save({}, {
					success : function(m, r)
					{
						var $view = $(debtView.render().el);
						debt.id = r.id;
						debt.date = r.date;
						self.debts.add(debt, { at : 0 });
						$view.hide();
						$('#table-container tbody').prepend($view);
						$view.fadeIn();
						var message = new MessageView({
							model : new Message({
								'type' : 'success',
								'content' : 'Skulden tillagd!'
							}),
							el : $("#message-container")
						});
						message.render();
						self.own.fetch();

						$('[name="name"]').val('');
						$('[name="description"]').val('');
						$('[name="share"]').val('');
						$('[name="sum"]').val('');
					},
					error : function(m, r)
					{
						var message = new MessageView({
							model : new Message({
								'type' : 'error',
								'content' : r
							}),
							el : $("#message-container")
						});
						message.render();
					}
				});
			}
		});
		$(function()
		{
			var app = new App();
		});
	};
	$(document).ready(function()
	{
		var app = new App($, document, window);
		$(window).scrollTop(1);
		// $(".alert").alert();
	});
});
