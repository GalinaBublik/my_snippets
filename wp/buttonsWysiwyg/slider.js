/*--------Create object for button-------*/

var oneslider={
    title:"Add Slider block",
    id :'1pls1-form-slider',
    pluginName: 'oneSlider'
};

/*--------Inisializade button-------*/

(function() {
    var rs_val = [];
    
    for(var i in post_types){
        rs_val[i] = {
            text: post_types[i]
            /*, onclick : function() {
            tinymce.execCommand('mceInsertContent', false, '[sliders type="' + post_types[i] + '" posts="-1" orderby="date" order="DESC"]' );
            }*/
        };
    }

    tinymce.create('tinymce.plugins.oneSlider', {
        init : function(editor, url) {

            editor.addButton('sliders', {
                title : 'Add Slider block',
                image : url+'/images/icon_62.png',
                onclick : function() {
                    eval('create_1pls1_sliders(oneslider, editor);open_dialogue_sliders("#'+oneslider.id+'")');
                }
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like slidersboxes, split buttons etc then this
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
    tinymce.PluginManager.add('sliders', tinymce.plugins.oneSlider);
})();

/*--------Open/close dialog by click on button-------*/

function open_dialogue_sliders(dialogueid,width,height){
    console.log(dialogueid);
    if(typeof(width)==='undefined') width = 'auto';
    if(typeof(height)==='undefined') height = 'auto';
    jQuery( dialogueid ).dialog({
        dialogClass : 'wp-dialog sliders-dialog',
        autoOpen: true,
        height: height,
        width: width,
        modal: true
    });

    jQuery( '.ui-dialog' ).css('z-index', 99999);
    jQuery('.ui-widget-overlay').css('z-index', 99998);
}

function close_dialogue(dialogueid){
    jQuery( dialogueid ).dialog('close');
}

/*--------Calback function by click on button-------*/

function create_1pls1_sliders(pluginObj, editor){
    //console.log(editor);


    

    var form = jQuery('<div id="'+pluginObj.id+'" class="1pls1-container" title="'+pluginObj.title+'">\
        <table id="1pls1-table-2" class="form-table">\
        <tr>\
            <th><label for="1pls1-type">Type of posts:</label></th>\
            <td><select name="type" id="1pls1-type">\
                <option value="post">Post</option>\
            </select><br />\
            </td>\
        </tr>\
        <tr>\
            <th><label for="1pls1-orderby">Order by:</label></th>\
            <td><select name="orderby" id="1pls1-orderby">\
                <option value="date">Date</option>\
                <option value="title">Title</option>\
                <option value="menu_order">Menu order</option>\
                <option value="ID">ID</option>\
                <option value="rand ">Rand</option>\
            </select><br />\
            </td>\
        </tr>\
        <tr>\
            <th><label for="1pls1-order">Order:</label></th>\
            <td><select name="order" id="1pls1-order">\
                <option value="asc">ASC</option>\
                <option value="desc">DESC</option>\
            </select><br />\
            </td>\
        </tr>\
        <tr><th><label for="1pls1-number">Count:</label></th><td><input type="number" name="number" min="-1" id="1pls1-count-sliders" value="-1"/><br /><small>-1 - it\'s all<small></td></tr>\
        <tr><th><label for="1pls1-number">Column:</label></th><td><input type="number" name="number" min="1" max="4" id="1pls1-column-sliders" value="4"/><br /></td></tr>\
        <tr>\
            <td><input id="pagenavi" type="checkbox" name="pagenavi" value="1"/><label for="pagenavi">Show a bullets</label></td>\
        </tr>\
        </table>\
        <p class="submit"><input type="button" id="1pls1-sliders" class="button-primary" value="Insert Posts" name="submit" /></p></div>');
        
    var table = form.find('table');
    form.appendTo('body').hide();

    jQuery('#1pls1-type').html('<option value="post">Post</option>');
    for(var i in post_types){
        var caps = post_types[i];
        caps = caps.charAt(0).toUpperCase() + caps.slice(1);
        jQuery('#1pls1-type').append('<option value="'+post_types[i]+'">'+caps+'</option>');
    }

    // Script for image upload button


    // handles the click event of the submit button
    form.find('#1pls1-sliders').click(function(){
        var shortcode = '[slider ';
            
        shortcode += ' type="'+table.find('#1pls1-type').val()+ '" ';
        shortcode += ' column="'+table.find('#1pls1-column-sliders').val()+ '" ';
        shortcode += ' orderby="'+table.find('#1pls1-orderby').val()+ '" ';
        shortcode += ' order="'+table.find('#1pls1-order').val()+ '" ';
        shortcode += ' count="'+table.find('#1pls1-count-sliders').val()+ '" ';
        shortcode += ' bullets="'+table.find('#pagenavi:checked').length+ '" ';


        shortcode += ']';
            
        // inserts the shortcode into the active editor
        editor.execCommand('mceInsertContent', 0, shortcode);

        close_dialogue('#'+pluginObj.id);
    });
}

