/*--------Create object for button-------*/

var nexaClass={
    title:"Add Class to text",
    id :'1pls1-form-list',
    pluginName: 'nexaClass'
};

/*--------Inisializade button-------*/

(function() {
    var rs_val = [];

    tinymce.create('tinymce.plugins.nexaClass', {
        init : function(editor, url) {

            editor.addButton('class', {
                title : 'Add Class to text',
                image : url+'/images/icon_97.png',
                onclick : function() {
                    var selected_text = tinyMCE.activeEditor.selection.getContent();
                    console.log(selected_text);
                    selected_text.replace('>', ' class="body-30">');
                    selected_text = '<span class="body-30">'+selected_text+'</span>';
                    editor.execCommand('mceInsertContent', 0, selected_text);
                }
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
             
             return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Buttons',
                author : '1pls1',
                authorurl : 'http://1pls1.com',
                infourl : '',
                version : "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('class', tinymce.plugins.nexaClass);
})();
