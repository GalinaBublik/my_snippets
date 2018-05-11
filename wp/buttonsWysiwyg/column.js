/*--------Create object for button-------*/

var column={
    title:"Nexa Column",
    id :'1pls1-form-column',
    pluginName: 'column'
};

/*--------Inisializade button-------*/

(function() {
    //******* Load plugin specific language pack
    //tinymce.PluginManager.requireLangPack('example');

    tinymce.create('tinymce.plugins.columnButton', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(editor, url) {

            editor.addButton('column', {
                title : 'Add column shortcode',
                image : url+'/images/icon_81.png',
                onclick : function() {
                    eval('create_1pls1_nexa(column, editor);open_dialogue("#'+column.id+'")');
                }
            });

            

            /*editor.addCommand('nexapopup', function() {
                var selected_text = editor.selection.getContent();
                var return_text = '';
                return_text = '<span class="dropcap">' + selected_text + '</span>';
                editor.execCommand('mceInsertContent', 0, return_text);

                var number = prompt("How many posts you want to show? "), 
                    shortcode;
                if (number !== null) {
                    number = parseInt(number);
                    if (number > 0 && number <= 20) {
                        shortcode = '[recent-posts numbers="' + number + '"/]';
                        editor.execCommand('mceInsertContent', 0, shortcode);
                    } else {
                        alert("The number value is invalid. It should be from 0 to 20.");
                    }
                }
            });*/

            

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
    tinymce.PluginManager.add('column', tinymce.plugins.columnButton);
})();

/*--------Open/close dialog by click on button-------*/

function open_dialogue(dialogueid,width,height){
    //console.log(dialogueid);
    if(typeof(width)==='undefined') width = 'auto';
    if(typeof(height)==='undefined') height = 'auto';
    jQuery( dialogueid ).dialog({
        dialogClass : 'wp-dialog osc-dialog',
        autoOpen: true,
        height: height,
        width: width,
        modal: true
    });

    jQuery( '.ui-dialog' ).css('z-index', 99999);
    jQuery('.ui-widget-overlay').css('z-index', 99998);
    jQuery('#amw_thumbnail_upload').width( jQuery( '.ui-dialog' ).width()*0.8 );
}

function close_dialogue(dialogueid){
    jQuery( dialogueid ).dialog('close');
}

/*--------Calback function by click on button-------*/

function create_1pls1_nexa(pluginObj, editor){
    //console.log(editor);


    // creates a form to be displayed everytime the button is clicked
    // you should achieve this using AJAX instead of direct html code like this
    var selected_text = tinyMCE.activeEditor.selection.getContent();

    var form = jQuery('<div id="'+pluginObj.id+'" class="1pls1-container" title="'+pluginObj.title+'"><table id="1pls1-table" class="form-table">\
            <tr>\
                <th><label for="1pls1-lg">Columns on large laptop:</label></th>\
                <td><input type="number" name="lg" max="12" id="1pls1-lg" value="4"/><br />\
                </td>\
            </tr>\
            <tr>\
                <th><label for="1pls1-md">Columns on medium laptop:</label></th>\
                <td><input type="number" name="md" max="12" id="1pls1-md" value="3"/><br />\
                </td>\
            </tr>\
            <tr>\
                <th><label for="1pls1-sm">Columns on tablet:</label></th>\
                <td><input type="number" name="sm" max="12" id="1pls1-sm" value="2"/><br />\
                </td>\
            </tr>\
            <tr>\
                <th><label for="1pls1-xs">Columns on mobile:</label></th>\
                <td><input type="number" name="xs" max="12" id="1pls1-xs" value="1"/><br />\
                </td>\
            </tr>\
        </table>\
        <p class="submit">\
            <input type="button" id="1pls1-column" class="button-primary" value="Insert Posts" name="submit" />\
        </p>\
        </div>');
        
    var table = form.find('table');
    form.appendTo('body').hide();
    

    // handles the click event of the submit button
    form.find('#1pls1-column').click(function(){
        var lg = parseInt( jQuery('#1pls1-lg').val() );
        var md = parseInt( jQuery('#1pls1-md').val() );
        var sm = parseInt( jQuery('#1pls1-sm').val() );
        var xs = parseInt( jQuery('#1pls1-xs').val() );
        var big = lg;

        if( md > big){
            big = md;
        }
        if( sm > big){
            big = sm;
        }
        if( xs > big){
            if( !confirm( 'Are you shure that you want this?') ){
                return false;
            }
            big = xs;
        }

        var shortcode = '[row]<br>';

        for (var i = 0; i < big; i++) {
            shortcode += '[column ';
            shortcode += ' lg="'+lg+'" ';
            shortcode += ' md="'+md+'" ';
            shortcode += ' sm="'+sm+'" ';
            shortcode += ' xs="'+xs+'" ]<br>';
            if( i==0 && selected_text!='' ){
                shortcode += selected_text;
            }

            shortcode += '[/column]<br>';

        };
            
        shortcode += '[/row]<br>';
        
            
        // inserts the shortcode into the active editor
        editor.execCommand('mceInsertContent', 0, shortcode);

        close_dialogue('#'+pluginObj.id);
    });
}

