import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials';

import Autoformat from '@ckeditor/ckeditor5-autoformat/src/autoformat';
import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold';
import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic';
import BlockQuote from '@ckeditor/ckeditor5-block-quote/src/blockquote';
import EasyImage from '@ckeditor/ckeditor5-easy-image/src/easyimage';
import Heading from '@ckeditor/ckeditor5-heading/src/heading';
import Image from '@ckeditor/ckeditor5-image/src/image';
import ImageCaption from '@ckeditor/ckeditor5-image/src/imagecaption';
import ImageStyle from '@ckeditor/ckeditor5-image/src/imagestyle';
import ImageToolbar from '@ckeditor/ckeditor5-image/src/imagetoolbar';
import ImageUpload from '@ckeditor/ckeditor5-image/src/imageupload';
import Link from '@ckeditor/ckeditor5-link/src/link';
import List from '@ckeditor/ckeditor5-list/src/list';
import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph';
import { Alignment } from '@ckeditor/ckeditor5-alignment';
import Base64UploadAdapter from '@ckeditor/ckeditor5-upload/src/adapters/base64uploadadapter';
import Font from '@ckeditor/ckeditor5-font/src/font';
import { Strikethrough, Subscript, Superscript, Underline } from '@ckeditor/ckeditor5-basic-styles';
import MediaEmbed from '@ckeditor/ckeditor5-media-embed/src/mediaembed';
import {AutoImage, ImageInsert, ImageResize, PictureEditing } from '@ckeditor/ckeditor5-image';
import { LinkImage } from '@ckeditor/ckeditor5-link';
import PasteFromOffice from '@ckeditor/ckeditor5-paste-from-office/src/pastefromoffice';
import { RemoveFormat } from '@ckeditor/ckeditor5-remove-format';
import { Indent, IndentBlock } from '@ckeditor/ckeditor5-indent';
import Table from '@ckeditor/ckeditor5-table/src/table';
import TableToolbar from '@ckeditor/ckeditor5-table/src/tabletoolbar';
import EditorWatchdog from '@ckeditor/ckeditor5-watchdog/src/editorwatchdog';
import { HorizontalLine } from '@ckeditor/ckeditor5-horizontal-line';
import { TextTransformation } from '@ckeditor/ckeditor5-typing';
import FileLink from './FileLink';




ClassicEditor.builtinPlugins = [
    Essentials,
    Autoformat,
    Bold,
    Italic,
    BlockQuote,
    Base64UploadAdapter,
    Heading,
    Image,
    ImageResize,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    ImageInsert,
    Link,
    List,
    LinkImage,
    Paragraph,
    Alignment,
    Font,
    Underline,
    MediaEmbed,  
    PasteFromOffice,
    RemoveFormat,
    Subscript,
    Superscript,
    Strikethrough,
    Indent,
    IndentBlock,
    PictureEditing,
    AutoImage,
    Table, TableToolbar,
    HorizontalLine,
    TextTransformation,
    // CUSTOM //
    FileLink,
     
];

// Editor configuration.
ClassicEditor.defaultConfig = {
    toolbar: {
        items: [
            'heading',
            '|',
            'bold',
            'underline',
            'italic',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor',                                                // <--- ADDED
            'link',
            'bulletedList',
            'numberedList',
            'subscript',
            'superscript',
            'strikethrough',
            'removeFormat',
            '|',
            'outdent',
            'indent',
            'alignment',
            '|',
            'insertImage',
            'mediaEmbed', 
            'insertTable',
            'blockQuote',
            'horizontalLine',
            '|',
            'filelink',
            '|',
            'undo',
            'redo'
        ]
    },
    image: {
        toolbar: [
            'imageStyle:inline',
            'imageStyle:block',
            'imageStyle:side',
            '|',
            'toggleImageCaption',
            'imageTextAlternative'
        ]
    },
    table: {
        contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
    },
    // This value must be kept in sync with the language defined in webpack.config.js.
    language: 'en'
};

class ToggleContent {

    constructor(element) {
        this.header = element.querySelector('[toggle-header]')
        this.content = element.querySelector('[toggle-content]')


        this.open = true

        clazz = this

        this.header.onclick = (e) => {
            console.log("g")
            this.content.classList.toggle('collapsed')
        }
    }



}

function start() {
    document.querySelectorAll('[toggle]').forEach(e => new ToggleContent(e))

}

window.onload = start()

const watchdog = new EditorWatchdog( ClassicEditor );
document.querySelectorAll('#editor').forEach(e => {
    watchdog
    .create( e, {
        
    } )
    .then( editor => {
        console.log( 'Editor was initialized', editor );
    } )
    .catch( error => {
        console.error( error.stack );
    } );
})







