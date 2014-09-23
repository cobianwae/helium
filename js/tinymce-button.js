(function($, window, undefined) {
        // Load plugin specific language pack
       // tinymce.PluginManager.requireLangPack('example');
        tinymce.create('tinymce.plugins.waeEditorHelper', {
                /**
                 * Initializes the plugin, this will be executed after the plugin has been created.
                 * This call is done before the editor instance has finished it's initialization so use the onInit event
                 * of the editor instance to intercept that event.
                 *
                 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
                 * @param {string} url Absolute URL to where the plugin is located.
                 */
                init : function(ed, url) {
                        // Register example button
                        ed.addButton('wae_editor_helper', {
                                title : 'wae Helper',
                                image : url + '/../images/shortcode.png',
                                onclick :function() {
									// triggers the thickbox
									var width = $(window).width(), H = $(window).height(), W = ( 720 < width ) ? 720 : width;
									W = W - 80;
									H = H - 124;
									tb_show( 'wae Editor Helper', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=wae_editor_helper' );
								}
                        });

                        ed.addButton('dropcap', {
                            title : 'DropCap',
                            cmd : 'dropcap',
                            image : url + '/../images/dropcap.png'
                        });

                        ed.addCommand('dropcap', function() {
                            var selected_text = ed.selection.getContent();
                            var return_text = '';
                            return_text = '<span class="dropcap">' + selected_text + '</span>';
                            ed.execCommand('mceInsertContent', 0, return_text);
                        });

                        // Add a node change handler, selects the button in the UI when a image is selected
                        ed.onNodeChange.add(function(ed, cm, n) {
                                cm.setActive('wae_editor_helper', n.nodeName == 'IMG');
                                cm.setActive('dropcap', n.nodeName == 'IMG');
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
                                longname : 'Example plugin',
                                author : 'Some author',
                                authorurl : 'http://tinymce.moxiecode.com',
                                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                                version : "1.0"
                        };
                }
        });

        // Register plugin
        tinymce.PluginManager.add('wae_editor_helper', tinymce.plugins.waeEditorHelper);

        var waeEditor = {};
        waeEditor.initiate = function(){
            $('#select-component').change(function(){
                var val = $(this).val();
                if($('.active-area').children(':first-child').length){
                    $('.hidden-area').append( $('.active-area').children(':first-child'));
                    $('.active-area').children(':first-child').remove();
                }
                $('.active-area').append( $('#'+val));
                $('.hidden-area').find('#'+val).remove();
            });
            $('#select-component').change();
        }

        waeEditor.finalize = function(){
            $('.submit-holder .button').click(function(){
                tb_remove();
            });
        }

        waeEditor.row = function(){
            $('#row #columns-type tr:not(.last) td').click(function(){
                $(this).closest('table').find(".choosen").removeClass("choosen");
                $(this).addClass("choosen");

            });

            $('.submit-row').click(function(){
                var table = $(this).closest('table');
                var wrapper = '[wae_row]%c$[/wae_row]';
                var column = "";
                var value = $.trim(table.find('.choosen .value').html());
                var map = {"1" : "1", "2" : "1/2", "3" : "1/3", "4" : "1/4", "2/5-3/5" : "2/5-3/5","3/5-2/5" : "3/5-2/5" };
                var mapResult = map[value];
                var mapResultArr = mapResult.split('-');
                var columns = mapResultArr.length == 1 ? value : mapResultArr.length;
                for (var i = 0; i < columns; i++) {
                    if(mapResultArr.length == 1){
                        console.log(mapResultArr);
                        var columnType = mapResultArr[0];
                    }else{
                        var columnType = mapResultArr[i];
                    }
                    column += '<p>[wae_column type="'+columnType+'"]';
                    column += 'ContentHere[/wae_column]</p>';
                };
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, wrapper.replace('%c$',column));
                table.find('.choosen').removeClass('choosen');
            });
        }

        waeEditor.ourFields = function(){
            $('#our-fields-icon').change(function(){
                var val = $(this).val();
                $('#our-fields-icons > div').hide();
                $('#' + val + '-icon').show();
            });
            $('.icon-option i').click(function(){
                var parent = $(this).closest('td');
                var choosen = parent.find('.selected');
                if(choosen.length == 1){
                    choosen.removeClass('selected');
                }
                $(this).addClass('selected');
            });
            $('.submit-our-fields').click(function(){
                var table = $(this).closest('table');
                var wrapper = '[wae_our_fields align="%a$" is_active="%ia$" short_desc="%s$" icon="%i$"]';
                var shortDesc = table.find('#short-desc').val();
                var icon = table.find('i.selected').removeClass('selected').attr('class');
                var isActive = table.find('#is-active').is(':checked') ? '1' : '0';
                var align = table.find('input[name="align"]:checked').val();
                wrapper = wrapper.replace('%s$', shortDesc);
                wrapper = wrapper.replace('%i$', icon);
                wrapper = wrapper.replace('%ia$', isActive);
                wrapper = wrapper.replace('%a$', align);
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, wrapper);
                table.find('#short-desc').val('');
                table.find('input[name="align"]:checked').prop('checked', false);
                table.find('.align-center').prop('checked', true);
                table.find('#is-active').prop('checked', false);
            });
        }
        
        waeEditor.teamMember = function(){
            $('.submit-team-member').click(function(){
                var table = $(this).closest('table');
                var wrapper = '[wae_team_member img_position="%p$" social_accounts="%s$" img_url="%u$"]Content[/wae_team_member]';
                var position = table.find('input[name="img-position"]:checked').val();
                var imgUrl = table.find('#member-photo').val();
                var socialAccounts = '';
                $('.social-accounts').each(function(){
                    var val = $(this).val();
                    var id = $(this).prop('id');
                    if( $.trim(val) != '' ){
                        socialAccounts += id + ',' + val + ',';
                    }
                });
                wrapper = wrapper.replace('%p$', position);
                wrapper = wrapper.replace('%u$', imgUrl);
                wrapper = wrapper.replace('%s$', socialAccounts);
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, wrapper);
                table.find('input[type="text"]').val('');
                table.find('input[name="img-position"]:checked').prop('checked',false);
                table.find('.left-pos').prop('checked', true);
                table.find('.remove-button').click();
            });
        }

        waeEditor.accordion = function(){
            $('.add-accordion').click(function(){
                var $tr = $(this).closest('tr');
                var $trClone = $tr.clone(true);
                $trClone.find('input[name="title"]').val('');
                $trClone.find('input[name="active"]').prop('checked', false);
                $trClone.find('.remove-accordion').show();
                if($tr.closest('table').find('.accordion-content').length == 1){
                    $tr.find('.remove-accordion').show();
                }
                $trClone.insertAfter($tr);
            });
            $('.remove-accordion').click(function(){
                if($(this).closest('table').find('.accordion-content').length == 2){
                    $(this).closest('tr').prev().find('.remove-accordion').hide();
                }
                $(this).closest('tr').remove();
            });
            $('.submit-accordion').click(function(){
                var table = $(this).closest('table');
                var wrapper = '<p>[wae_accordion]</p>%ac$<p>[/wae_accordion]</p>';
                var content = '';
                table.find('.accordion-content').each(function(){
                    var $this = $(this);
                    var title = $this.find('input[name="title"]').val();
                    var active = $this.find('input[name="active"]').is(':checked') ? '1' : '0';
                    content += '<p>[accordion_content title="' +  title + '" active="' + active +'"]</p>';
                    content += '<p>contentHere</p><p>[/accordion_content]</p>';
                });
                wrapper = wrapper.replace('%ac$', content);
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, wrapper);
                table.find('.accordion-content').each(function(){
                    if($(this).is(':first-child')){
                        $(this).find('input[name="title"]').val('');
                        $(this).find('input[name="active"]').prop('checked', false);
                        $(this).find('.remove-accordion').hide();
                    }else{
                        $(this).remove();
                    }
                });
            });
        }

         waeEditor.tabs = function(){
            $('.add-tab').click(function(){
                var $tr = $(this).closest('tr');
                var $trClone = $tr.clone(true);
                $trClone.find('input[name="title"]').val('');
                $trClone.find('input[name="active"]').prop('checked', false);
                $trClone.find('.remove-accordion').show();
                if($tr.closest('table').find('.tab-content').length == 1){
                    $tr.find('.remove-tab').show();
                }
                $trClone.insertAfter($tr);
            });
            $('.remove-tab').click(function(){
                if($(this).closest('table').find('.tab-content').length == 2){
                    $(this).closest('tr').prev().find('.remove-tab').hide();
                }
                $(this).closest('tr').remove();
            });
            $('.submit-tabs').click(function(){
                var table = $(this).closest('table');
                var wrapper = '<p>[wae_tabs type="%t$"]</p>%tc$<p>[/wae_tabs]</p>';
                var type = table.prev().find('select[name="type"]').val();
                wrapper = wrapper.replace('%t$', type);
                var content = '';
                table.find('.tab-content').each(function(){
                    var $this = $(this);
                    var title = $this.find('input[name="title"]').val();
                    var active = $this.find('input[name="active"]').is(':checked') ? '1' : '0';
                    content += '<p>[wae_tab title="' +  title + '" active="' + active +'"]</p>';
                    content += '<p>contentHere</p><p>[/wae_tab]</p>';
                });
                wrapper = wrapper.replace('%tc$', content);
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, wrapper);
                table.find('.tab-content').each(function(){
                    if($(this).is(':first-child')){
                        $(this).find('input[name="title"]').val('');
                        $(this).find('input[name="active"]').prop('checked', false);
                        $(this).find('.remove-tab').hide();
                    }else{
                        $(this).remove();
                    }
                });
            });
        }

        waeEditor.highlight = function(){
            $('.submit-highlight').click(function(){
                var table = $(this).closest('table');
                var color = table.find('.color-field').val();
                var fontColor = table.find('.font-color').val();
                var selected_text =  tinyMCE.activeEditor.selection.getContent();
                var return_text = '';
                return_text = '<span class="highlight-text '+fontColor+'" style="background-color:'+color+'">' + selected_text + '</span>';
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
            });
        }

        $(document).ready(function(){
            waeEditor.initiate();
            $('.color-field').wpColorPicker();
            waeEditor.row();
            waeEditor.ourFields();
            waeEditor.teamMember();
            waeEditor.accordion();
            waeEditor.tabs();
            waeEditor.highlight();
            waeEditor.finalize();
        });

})(jQuery,window);