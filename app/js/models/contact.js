ContactManager.Models.Contact = Backbone.Model.extend({
    defaults: {
        id: null,
        namefirst: null,
        namelast:null,
        email: null,
        avatar: null
    },

    initialize: function() {
        this.set('avatar', _.random(1, 15) + '.jpg');
    }
});