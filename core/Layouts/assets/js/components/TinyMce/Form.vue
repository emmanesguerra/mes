<template>
    <div  class="form-group col-sm-12">
        <label for="html_template">{{ label }}</label>
        <Editor :name="textareaname"
                :value="value"
                :init="editorInit"
                :plugins="plugins"
                ></Editor>
    </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue';

    export default {
        props: ['value', 'textareaname', 'label', 'height', 'toolbar', 'plugins', 'showmenu', 'styles', 'bodyclass', 'imagelists'],
        components: {
            Editor,
        },
        computed: {
            editorInit () {
                return {
                    toolbar: this.toolbar,
                    height: this.height, 
                    content_css: this.styles,
                    visual_table_class:'ae-table',
                    image_advtab: true,
                    menubar: this.showmenu,
                    body_class: this.bodyclass,
                    image_list: this.imagelists,
                    relative_urls : false
                };
            }
        }
    }
</script>