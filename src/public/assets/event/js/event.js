$;jQuery(document).ready(function($) {
	var jqElemEventForm = $(".event-form");
	if (jqElemEventForm.length === 0) return;
	
	(function() {
		var EventParticipantForm = function(eventRegistrationForm, jqElem) {
			this.jqElemCbxOptional = jqElem.find(".event-registration-optional:first").hide();
			
			this.jqElem = jqElem;
			(function(that) {
				var jqElemRemove = jqElem.find(".event-participant-remove:first");
				if (jqElemRemove.length === 0) {
					jqElemRemove = $("<button />", {
						"class": "btn btn-danger event-participant-remove",
						"title": eventRegistrationForm.txtRemoveParticipant,
						"text": "x"
					}).appendTo(jqElem);
				}
				
				jqElemRemove.click(function(e) {
					e.preventDefault();
					eventRegistrationForm.addEventParticipantForm(that);
					eventRegistrationForm.updateNums();
				});
			}).call(this, this);
		};
		
		EventParticipantForm.prototype.isActive = function() {
			return this.jqElemCbxOptional.prop("checked");
		};
		
		EventParticipantForm.prototype.deactivate = function() {
			this.jqElemCbxOptional.prop("checked", false);
			this.jqElem.hide();
		};
		
		EventParticipantForm.prototype.activate = function() {
			this.jqElemCbxOptional.prop("checked", true);
			this.jqElem.show();
		};
		
		var EventForm = function(jqElem) {
			this.jqElem = jqElem;
			this.availableEventParticipantForms = [];
			this.jqElemEventParticipantForms = jqElem.find(".event-participant-forms");
			this.jqElemBtnAdd = null;
			this.txtAddParticipant = this.jqElemEventParticipantForms.data("txt-add-participant") || "Add Participant";
			this.txtRemoveParticipant = this.jqElemEventParticipantForms.data("txt-remove-participant") || "Remove Participant";
			
			(function(that) {
				this.jqElemEventParticipantForms.find(".event-participant-form").each(function() {
					var eventParticipantForm = new EventParticipantForm(that, $(this));
					if (!eventParticipantForm.isActive()) {
						that.availableEventParticipantForms.unshift(eventParticipantForm);
						eventParticipantForm.deactivate();
					}
				});
				
				this.jqElemBtnAdd = jqElem.find(".event-participant-add:first");
				if (this.jqElemBtnAdd.length === 0) {
					this.jqElemBtnAdd = $("<button />", {
						"class": "btn btn-success",
						"text": this.txtAddParticipant
					}).insertAfter(that.jqElemEventParticipantForms);
				}
				
				this.jqElemBtnAdd.click(function(e) {
					e.preventDefault();
					var eventParticipantForm = that.requestEventParticipantForm();
					that.jqElemEventParticipantForms.append(eventParticipantForm.jqElem);
					that.updateNums();
				});
				
				if (that.availableEventParticipantForms.length === 0) {
					this.jqElemBtnAdd.hide();
				} else {
					if (this.jqElemEventParticipantForms.find(".event-participant-form:visible").length === 0) {
						this.jqElemBtnAdd.click();
					} 
					this.updateNums();
				}
				
			}).call(this, this);
		};
		
		EventForm.prototype.updateNums = function() {
			var jqElemVisibleParticipantForms = this.jqElemEventParticipantForms.find(".event-participant-form:visible");
			
			jqElemVisibleParticipantForms.each(function(index) {
				var jqElem = $(this);
				if (jqElemVisibleParticipantForms.length === 1) {
					jqElem.find(".event-participant-remove").hide();
				} else {
					jqElem.find(".event-participant-remove").show();
				}
				jqElem.find(".event-participant-num").text(index + 1);
			});
			
		};
		
		EventForm.prototype.requestEventParticipantForm = function() {
			var eventParticipantForm = this.availableEventParticipantForms.pop();
			eventParticipantForm.activate();
			
			if (this.availableEventParticipantForms.length === 0) {
				this.jqElemBtnAdd.hide();
			}
			
			return eventParticipantForm;
		};
		
		EventForm.prototype.addEventParticipantForm = function(eventParticipantForm) {
			if (this.availableEventParticipantForms.length === 0) {
				this.jqElemBtnAdd.show();
			}
			eventParticipantForm.deactivate();
			this.availableEventParticipantForms.push(eventParticipantForm);
		};
		
		jqElemEventForm.each(function() {
			new EventForm($(this));
		});
	})();
});