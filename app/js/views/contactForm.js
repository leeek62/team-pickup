ContactManager.Views.ContactForm = Backbone.View.extend({
    template: _.template($('#tpl-new-contact').html()),

    events: {
        'submit .contract-form': 'onFormSubmit'
    },

    render: function() {
        var html = this.template(_.extend(this.model.toJSON(), {
            isNew: this.model.isNew()
        }));
        this.$el.append(html);
        return this;
    },

    onFormSubmit: function(e) {
        e.preventDefault();
        var params = {
            namefirst: this.$('.contact-namefirst-input').val(),
            namelast: this.$('.contact-namelast-input').val(),
            email: this.$('.contact-email-input').val(),
            sex: 'M'
        };
        this.trigger('form:submitted', params);
        $.ajax({
            url: '../../../database/add_user.php',
            data: params,
            type: 'POST',
            success: function(){alert("success");},
            error: function(){},
            dataType: 'json'
        });
    }
});