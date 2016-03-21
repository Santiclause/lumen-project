(function(globals) {
    'use strict';
    var notes;
    var tag_bindings = {
        "default": $.fn.text,
        //"body": $.fn.val
    };
    
    /*function submit(data) {
        
    }*/
    
    $(function() {
        var $container = $('#notes');
        
        function addNote(note) {
            var $note = $('#note-template').clone().removeAttr('id').removeClass('hidden').data('id', note.id);
            $note.find('.note-data').each(function() {
                var tag = $(this).data('tag');
                //use our predefined behaviour to handle inserting data into the element appropriately
                tag_bindings[tag in tag_bindings ? tag : "default"].call($(this), note[tag]);
                //exceptional behaviour to add hover text to titles
                if (tag == "title") {
                    $(this).attr('title', note.title);
                }
            });
            applyNoteBindings($note);
            $note.prependTo($container);
        }
        
        //while this is a little bit ugly (for certain definitions thereof), it's simpler to create closures over the $note jquery object
        function applyNoteBindings($note) {
            $note.find('.note-delete').click(function () {
                //let's take out the confirmation dialog for now.
                //if (window.confirm("Are you sure you want to delete this note?")) {
                    $.ajax({
                        url: '/note/' + $note.data('id'),
                        type: 'DELETE',
                        complete: function() {
                            $(this).removeData('working');
                        },
                        success: function(data) {
                            $note.remove();
                        },
                        error: function(error) {
                            //do something here
                        },
                    });
                //}
            });
            $note.find('.note-edit').click(function() {
                if ($note.data('editing')) {
                    return;
                }
                var replacements = new Array();
                //replace the editable fields with their appropriate editing input tag
                $note.find('.editable').each(function() {
                    var tag = $(this).data('tag');
                    var $new = $('<' + $(this).data('type') + '>', {
                        data: $(this).data(),
                        attr: {
                            class: "editable edit-" + tag
                        }
                    });
                    $new.val(tag_bindings[tag in tag_bindings ? tag : "default"].call($(this)));
                    var $old = $(this).replaceWith($new);
                    replacements.push([$new, $old]);
                });
                var $footer = $('#note-footer-template').clone().removeAttr('id').removeClass('hidden');
                $footer.find('.note-cancel').click(function () {
                    $(replacements).each(function() {
                        this[0].replaceWith(this[1]).remove();
                    });
                    $footer.remove();
                    $note.removeData('editing');
                });
                $footer.find('.note-save').click(function () {
                    if ($(this).data('working')) {
                        //don't do anything!
                        return;
                    }
                    var data = {};
                    $note.find('.editable').each(function() {
                        data[$(this).data('tag')] = $(this).val();
                    });
                    $.ajax({
                        url: '/note/' + $note.data('id'),
                        type: 'PUT',
                        data: data,
                        dataType: 'json',
                        complete: function() {
                            $(this).removeData('working');
                        },
                        success: function(data) {
                            $note.remove();
                            addNote(data);
                        },
                        error: function(error) {
                            //do something here
                        },
                    });
                });
                $footer.appendTo($note.find('.note-content').first());
                $note.data('editing', true);
            });
        }
        
        $('#create-form').submit(function(event) {
            event.preventDefault();
            var $this = $(this);
            if ($this.data('working')) {
                return false;
            }
            $this.data('working', 1);
            var $submit = $this.find('.create-submit submit');
            var old_val = $submit.val();
            $submit.val('Working...');
            $.ajax({
                url: '/note/create',
                type: 'POST',
                data: $this.serialize(),
                dataType: 'json',
                complete: function() {
                    $this.removeData('working');
                    $submit.val(old_val);
                },
                success: function(data) {
                    addNote(data);
                },
                error: function(error) {
                    //do something here
                },
            });
            return false;
        });
        
        //populate our list of notes
        $.get({
            url: "/notes",
            dataType: "json",
            success: function(data) {
                notes = data;
                globals.notes = notes;
                //sort them beforehand
                notes.sort(function(a, b) {
                    return a.updated_at < b.updated_at ? -1 : 1;
                });
                //insert them into the dashboard
                $.each(notes, function() {
                    addNote(this);
                });
            },
            error: function(error) {
                //do something here
            }
        });
    });
})(this);