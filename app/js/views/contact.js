ContactManager.Views.Contact = Backbone.View.extend({
    tagName: 'li',
    className: 'media col-md-6 col-lg-4',
    template: _.template($('#tpl-contact').html()),

    events: {
        'click .delete-contract': 'onClickDelete'
    },

    initialize: function() {
        this.listenTo(this.model, 'remove', this.remove);
    },

    render: function() {
        var html = this.template(this.model.toJSON());
        this.$el.append(html);
        return this;
    },

    onClickDelete: function(e) {
        e.preventDefault();
        this.model.collection.remove(this.model);
        var params = {email: this.model.attributes.email};
        console.log(this.model.email);
        $.ajax({
            url: '../../../database/test_delete.php',
            data: params,
            type: 'POST',
            success: function(){alert("success");},
            error: function(){},
            dataType: 'json'
        });
    }
});